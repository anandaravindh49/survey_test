<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\ManagedFile;

class FileManager extends Component
{
    use WithFileUploads;

    public $upload;
    public $files = [];
    public $folders = [];
    public $filterFolder = null;
    public $search = '';

    protected $listeners = ['updateFiles' => 'loadFiles'];

    public function mount()
    {
        $this->loadFiles();
    }

    public function loadFiles()
    {
        $query = ManagedFile::query();

        if ($this->filterFolder) {
            // folder '.' means root uploads folder
            if ($this->filterFolder === '.') {
                $query->whereRaw("path NOT LIKE ?", ['%/%']);
            } else {
                $prefix = rtrim($this->filterFolder, '/') . '/';
                $query->where('path', 'like', $prefix . '%');
            }
        }

        if ($this->search) {
            $query->where('name', 'like', '%'.$this->search.'%');
        }

        $items = $query->orderBy('created_at', 'desc')->get();

        // compute folders from all paths (top-level segment)
        $allPaths = ManagedFile::pluck('path')->toArray();
        $folders = collect($allPaths)->map(function ($p) {
            // normalize: take first segment
            if (Str::contains($p, '/')) {
                return Str::before($p, '/');
            }
            return '.'; // root
        })->unique()->values()->toArray();

        $this->folders = $folders;

        $this->files = $items->map(function ($m) {
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            $disk = Storage::disk($m->disk);
            $diskSettings = config('filesystems.disks.' . $m->disk, []);
            $driver = $diskSettings['driver'] ?? null;

            if (in_array($driver, ['s3', 's3v3', 's3-compat'], true)) {
                $downloadUrl = null;
                try {
                    $downloadUrl = $disk->temporaryUrl($m->path, now()->addMinutes(60));
                } catch (\Exception $e) {
                    Log::warning('FileManager: could not generate temporary URL for content', ['path' => $m->path, 'disk' => $m->disk, 'error' => $e->getMessage()]);
                    $downloadUrl = route('file-manager.view', base64_encode($m->path));
                }
            } elseif ($driver === 'local') {
                $downloadUrl = url('/') . '/' . ltrim($m->path, '/');
            } else {
                $downloadUrl = route('file-manager.view', base64_encode($m->path));
            }

            $thumbnailUrl = null;
            if (! empty($m->thumbnail_path)) {
                // Prefer local cache thumbnail when present (for mixed local/S3 sync behavior)
                $localThumb = public_path('uploads/thumbnails/' . basename($m->thumbnail_path));
                if (file_exists($localThumb)) {
                    $thumbnailUrl = url('/') . '/uploads/thumbnails/' . basename($m->thumbnail_path);
                } else {
                if (in_array($driver, ['s3', 's3v3', 's3-compat'], true)) {
                    try {
                        $thumbnailUrl = $disk->temporaryUrl($m->thumbnail_path, now()->addMinutes(60));
                    } catch (\Exception $e) {
                        Log::warning('FileManager: could not generate temporary URL for thumbnail', ['path' => $m->thumbnail_path, 'disk' => $m->disk, 'error' => $e->getMessage()]);
                        $thumbnailUrl = route('file-manager.view', base64_encode($m->thumbnail_path));
                    }
                } elseif ($driver === 'local') {
                    $thumbnailUrl = url('/') . '/' . ltrim($m->thumbnail_path, '/');
                } else {
                    $thumbnailUrl = route('file-manager.view', base64_encode($m->thumbnail_path));
                }
                }
            }

    return [
        'id' => $m->id,
        'name' => $m->name,
        'path' => $m->path,
        'thumbnail_path' => $m->thumbnail_path,
        'thumbnail_url' => $thumbnailUrl,
        'size' => $m->size,
        'mime' => $m->mime,
        'download_url' => $downloadUrl,
        'created_at' => $m->created_at->toDateTimeString(),
        'user' => $m->user?->name,
    ];
})->toArray();
    }

    public function setFolder($folder)
    {
        $this->filterFolder = $folder === 'all' ? null : $folder;
        $this->loadFiles();
    }

    public function updatedSearch()
    {
        $this->loadFiles();
    }

    public function uploadFile()
    {
        // If Livewire did not receive the uploaded file, provide a helpful message.
        if (! $this->upload) {
            $uploadMax = ini_get('upload_max_filesize') ?: 'unknown';
            $postMax = ini_get('post_max_size') ?: 'unknown';

            // Log diagnostics to help debug missing upload
            try {
                $headers = request()->headers->all();
                $contentLength = request()->server('CONTENT_LENGTH') ?: null;
                $files = $_FILES ?? null;
                $livewireConfig = config('livewire.temporary_file_upload');

                Log::warning('FileManager upload missing - diagnostics', [
                    'upload_max_filesize' => $uploadMax,
                    'post_max_size' => $postMax,
                    'content_length' => $contentLength,
                    'headers' => $headers,
                    '_files' => $files,
                    'livewire_temp_upload_config' => $livewireConfig,
                ]);
            } catch (\Exception $e) {
                Log::error('FileManager: failed to log upload diagnostics: '.$e->getMessage());
            }

            session()->flash('error', __('No file received. This often means the file exceeded PHP limits (upload_max_filesize or post_max_size), or the server rejected the multipart request. upload_max_filesize=:upload, post_max_size=:post', ['upload' => $uploadMax, 'post' => $postMax]));
            return;
        }

        $this->validate([
            // Allow any file type, up to 100 MB (102400 KB)
            'upload' => 'required|file|max:102400', // 100 MB
        ]);

        // Preserve original filename and avoid collisions by prefixing timestamp
        $original = $this->upload->getClientOriginalName();
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $original);

        $disk = 'file_manager';
        $diskConfig = config('filesystems.disks.' . $disk);
        if (! is_array($diskConfig) || empty($diskConfig['driver'] ?? null)) {
            Log::error('FileManager: file_manager disk is missing or has no driver', ['disk_config' => $diskConfig]);
            session()->flash('error', __('Upload failed: storage disk is not configured. Check server configuration.'));
            return;
        }

        $storage = Storage::disk($disk);
        $path = 'uploads/' . $filename;
        $isLocal = ($diskConfig['driver'] === 'local');
        if ($isLocal) {
            $publicUploadDir = public_path('uploads');
            if (! File::exists($publicUploadDir)) {
                File::makeDirectory($publicUploadDir, 0755, true);
            }
            $targetFile = $publicUploadDir . DIRECTORY_SEPARATOR . $filename;
            $this->upload->move($publicUploadDir, $filename);
            $path = 'uploads/' . $filename;
        }

        try {
            // For S3 / S3-compatible endpoints use a stream upload to avoid issues
            if (in_array($diskConfig['driver'], ['s3', 's3v3', 's3-compat'], true)) {
                $realPath = $this->upload->getRealPath() ?: $this->upload->getPathname();
                if ($realPath && file_exists($realPath)) {
                    $stream = fopen($realPath, 'r');
                    if ($stream === false) {
                        throw new \RuntimeException('Could not open uploaded file stream');
                    }

                    $visibility = $diskConfig['visibility'] ?? 'private';
                   $storage->put($path, $stream, [
    'visibility' => 'public',
    'ACL' => 'public-read'
]);

                    if (is_resource($stream)) {
                        fclose($stream);
                    }   
                } else {
                    // Some upload implementations (Livewire temporary files) may not
                    // expose a real local path; fall back to putFileAs which can
                    // handle UploadedFile instances directly.
                    $stored = $storage->putFileAs('uploads', $this->upload, $filename, ['visibility' => 'public']);
                    if ($stored) {
                        $path = $stored;
                    } else {
                        throw new \RuntimeException('Uploaded file missing on local disk: ' . ($realPath ?: 'null'));
                    }
                }
            } else {
                // Local disks: use putFileAs which handles moving the uploaded file
                $stored = $storage->putFileAs('uploads', $this->upload, $filename);
                if ($stored) {
                    $path = $stored;
                }
            }
        } catch (\Exception $e) {
            Log::error('FileManager: exception while storing file', [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'disk' => $disk,
                'bucket' => $diskConfig['bucket'] ?? null,
                'region' => $diskConfig['region'] ?? null,
                'endpoint' => $diskConfig['endpoint'] ?? null,
                'use_path_style_endpoint' => $diskConfig['use_path_style_endpoint'] ?? null,
                'filename' => $filename,
            ]);

            session()->flash('error', __('Upload failed: storage exception occurred. Check logs for details.'));
            return;
        }

        // Prefer the uploaded file's reported size to avoid relying on remote metadata
        $size = $this->upload->getSize() ?: 0;
        $mime = $this->upload->getClientMimeType();

        $thumbnailPath = null;
        if (Str::startsWith($mime, 'image/') && ! Str::contains($mime, 'svg')) {
            try {
                $sourcePath = $this->upload->getRealPath() ?: $this->upload->getPathname();
                if ($sourcePath && file_exists($sourcePath)) {
                    $thumbFilename = 'thumb_' . $filename;
                    $thumbTarget = 'uploads/thumbnails/' . $thumbFilename;
                    if ($isLocal) {
                        $thumbDir = public_path('uploads/thumbnails');
                        if (! File::exists($thumbDir)) {
                            File::makeDirectory($thumbDir, 0755, true);
                        }
                        $thumbAbs = $thumbDir . DIRECTORY_SEPARATOR . $thumbFilename;
                        $this->generateImageThumbnail($sourcePath, $thumbAbs, null, true);
                        $thumbnailPath = 'uploads/thumbnails/' . $thumbFilename;
                    } else {
                        $this->generateImageThumbnail($sourcePath, $thumbTarget, $disk);
                        $thumbnailPath = $thumbTarget;
                    }
                }
            } catch (\Exception $e) {
                Log::warning('FileManager: could not generate image thumbnail', [
                    'message' => $e->getMessage(),
                    'mime' => $mime,
                    'path' => $path,
                ]);
            }
        }

        // For local disks we can check existence reliably. Some S3-compatible
        // endpoints or drivers may throw on `exists()` (HEAD) immediately after
        // upload; treat a successful `put()` as success for S3-like drivers.
        if (! in_array($diskConfig['driver'], ['s3', 's3v3', 's3-compat'], true)) {
            try {
                if (! $storage->exists($path)) {
                    Log::error('FileManager: stored file does not exist after upload', ['path' => $path, 'disk' => $disk, 'disk_config' => $diskConfig]);
                    session()->flash('error', __('Upload failed: could not store the file. Check storage configuration.'));
                    return;
                }
            } catch (\Exception $e) {
                Log::error('FileManager: exception while verifying stored file', ['message' => $e->getMessage(), 'path' => $path, 'disk' => $disk]);
                session()->flash('error', __('Upload failed: could not verify stored file. Check logs.'));
                return;
            }
        }

        try {
            ManagedFile::create([
                'name' => $original,
                'path' => $path,
                'thumbnail_path' => $thumbnailPath,
                'disk' => 'file_manager',
                'size' => $size,
                'mime' => $mime,
                'user_id' => Auth::id(),
            ]);
        } catch (\Exception $e) {
            Log::error('FileManager: failed to create ManagedFile record', [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'path' => $path,
                'filename' => $filename,
            ]);

            // Attempt cleanup of remote file if present
            try {
                Storage::disk('file_manager')->delete($path);
            } catch (\Exception $cleanup) {
                Log::warning('FileManager: cleanup failed after DB error', ['message' => $cleanup->getMessage(), 'path' => $path]);
            }

            session()->flash('error', __('Upload failed: could not persist file metadata. Check logs.'));
            return;
        }

        $this->upload = null;
        $this->loadFiles();

        session()->flash('message', __('File uploaded successfully'));
    }

    public function deleteFile($id)
    {
        $m = ManagedFile::find($id);
        if (! $m) {
            return;
        }

        try {
            Storage::disk($m->disk)->delete($m->path);
        } catch (\Exception $e) {
            Log::error('FileManager: failed to delete remote file', ['message' => $e->getMessage(), 'path' => $m->path, 'disk' => $m->disk]);
            session()->flash('error', __('Failed to delete file from storage. Check logs.'));
            return;
        }

        try {
            $m->delete();
        } catch (\Exception $e) {
            Log::error('FileManager: failed to delete DB record', ['message' => $e->getMessage(), 'id' => $m->id]);
            session()->flash('error', __('Failed to delete file metadata. Check logs.'));
            return;
        }

        $this->loadFiles();
        session()->flash('message', __('File deleted'));
    }

    public function render()
    {
        return view('livewire.file-manager');
    }

    private function generateImageThumbnail(string $sourcePath, string $thumbTarget, ?string $disk = null, bool $useAbsolute = false): void
    {
        $info = getimagesize($sourcePath);
        if (! $info) {
            throw new \RuntimeException('Unable to obtain image metadata');
        }

        [$width, $height, $type] = $info;
        if ($width <= 0 || $height <= 0) {
            throw new \RuntimeException('Invalid image dimensions');
        }

        switch ($type) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            default:
                throw new \RuntimeException('Unsupported image type for thumbnail');
        }

        if (! $sourceImage) {
            throw new \RuntimeException('Failed to create image resource');
        }

        $thumbWidth = 320;
        $thumbHeight = (int) round($height * ($thumbWidth / $width));
        $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);

        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
            imagealphablending($thumbImage, false);
            imagesavealpha($thumbImage, true);
            $transparent = imagecolorallocatealpha($thumbImage, 0, 0, 0, 127);
            imagefilledrectangle($thumbImage, 0, 0, $thumbWidth, $thumbHeight, $transparent);
        }

        imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

        ob_start();
        imagejpeg($thumbImage, null, 75);
        $jpegData = ob_get_clean();

        imagedestroy($sourceImage);
        imagedestroy($thumbImage);

        if ($jpegData === false) {
            throw new \RuntimeException('Failed to encode thumbnail');
        }

        if ($useAbsolute) {
            file_put_contents($thumbTarget, $jpegData);
        } elseif ($disk !== null) {
            Storage::disk($disk)->put($thumbTarget, $jpegData);
        } else {
            throw new \RuntimeException('No storage destination configured for thumbnail');
        }
    }
}
