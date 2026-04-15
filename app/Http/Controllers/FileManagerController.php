<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\ManagedFile;

class FileManagerController extends Controller
{
    /**
     * Fallback upload handler (non-Livewire) — useful when JS/AJAX uploads fail.
     */
    public function upload(Request $request)
    {
        try {
            $request->validate([
                // Laravel 'max' uses kilobytes; 102400 KB = 100 MB
                'file' => 'required|file|max:102400',
            ]);

            $file = $request->file('file');
            $original = $file->getClientOriginalName();
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $original);

            $diskConfig = config('filesystems.disks.file_manager');
            if (! is_array($diskConfig) || empty($diskConfig['driver'] ?? null)) {
                \Illuminate\Support\Facades\Log::error('FileManagerController: file_manager disk is missing or has no driver', ['disk_config' => $diskConfig]);
                return redirect()->back()->with('error', __('Upload failed: storage disk is not configured. Check `config/filesystems.php` and environment variables.'));
            }

            $disk = 'file_manager';
            $storage = Storage::disk($disk);
            $path = 'uploads/' . $filename;
            $diskConfig = config('filesystems.disks.' . $disk, []);
            $isLocal = ($diskConfig['driver'] ?? null) === 'local';
            if ($isLocal) {
                $publicUploadDir = public_path('uploads');
                if (! File::exists($publicUploadDir)) {
                    File::makeDirectory($publicUploadDir, 0755, true);
                }
                $file->move($publicUploadDir, $filename);
                $path = 'uploads/' . $filename;
            }

            try {
                if (! $isLocal && in_array($diskConfig['driver'], ['s3', 's3v3', 's3-compat'], true)) {
                    $realPath = $file->getRealPath() ?: $file->getPathname();
                    if ($realPath && file_exists($realPath)) {
                        $stream = fopen($realPath, 'r');
                        if ($stream === false) {
                            throw new \RuntimeException('Could not open uploaded file stream');
                        }

                        $visibility = $diskConfig['visibility'] ?? 'private';
                        $storage->put($path, $stream, ['visibility' => $visibility]);

                        if (is_resource($stream)) {
                            fclose($stream);
                        }
                    } else {
                        // Some upload flows (JS libraries, temporary files) may not
                        // expose a real path; let putFileAs handle the UploadedFile.
                        $stored = $storage->putFileAs('uploads', $file, $filename);
                        if ($stored) {
                            $path = $stored;
                        } else {
                            throw new \RuntimeException('Uploaded file missing on local disk: ' . ($realPath ?: 'null'));
                        }
                    }
                } elseif (! $isLocal) {
                    $stored = $storage->putFileAs('uploads', $file, $filename);
                    if ($stored) {
                        $path = $stored;
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('FileManagerController: exception while storing file', [
                    'message' => $e->getMessage(),
                    'exception' => get_class($e),
                    'disk' => $disk,
                    'bucket' => $diskConfig['bucket'] ?? null,
                    'region' => $diskConfig['region'] ?? null,
                    'endpoint' => $diskConfig['endpoint'] ?? null,
                    'use_path_style_endpoint' => $diskConfig['use_path_style_endpoint'] ?? null,
                    'filename' => $filename,
                ]);

                return redirect()->back()->with('error', __('Upload failed: storage exception occurred. Check logs for details.'));
            }

            // Keep a local public cache copy even when primary storage is remote.
            // This guarantees immediate in-app preview on environments where
            // S3-compatible read APIs are flaky or unavailable.
            if (! $isLocal) {
                try {
                    $publicUploadDir = public_path('uploads');
                    if (! File::exists($publicUploadDir)) {
                        File::makeDirectory($publicUploadDir, 0755, true);
                    }

                    $realPath = $file->getRealPath() ?: $file->getPathname();
                    if ($realPath && file_exists($realPath)) {
                        File::copy($realPath, $publicUploadDir . DIRECTORY_SEPARATOR . $filename);
                    }
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning('FileManagerController: failed to create local cache copy', [
                        'message' => $e->getMessage(),
                        'path' => $path,
                        'filename' => $filename,
                    ]);
                }
            }

            // Use the uploaded file size instead of asking the remote disk for metadata
            $size = $file->getSize() ?: 0;
            $mime = $file->getClientMimeType();

            $thumbnailPath = null;
            $shouldGenerateThumbnails = (bool) config('file-manager.generate_thumbnails', false);
            if ($shouldGenerateThumbnails && Str::startsWith($mime, 'image/') && ! Str::contains($mime, 'svg')) {
                try {
                    $realPath = $file->getRealPath() ?: $file->getPathname();
                    if ($realPath && file_exists($realPath)) {
                        $thumbFilename = 'thumb_' . $filename;
                        $thumbTarget = 'uploads/thumbnails/' . $thumbFilename;
                        if ($isLocal) {
                            $thumbDir = public_path('uploads/thumbnails');
                            if (! File::exists($thumbDir)) {
                                File::makeDirectory($thumbDir, 0755, true);
                            }
                            $thumbAbs = $thumbDir . DIRECTORY_SEPARATOR . $thumbFilename;
                            $this->generateImageThumbnail($realPath, $thumbAbs, null);
                            $thumbnailPath = 'uploads/thumbnails/' . $thumbFilename;
                        } else {
                            $this->generateImageThumbnail($realPath, $thumbTarget, $disk);
                            $thumbDir = public_path('uploads/thumbnails');
                            if (! File::exists($thumbDir)) {
                                File::makeDirectory($thumbDir, 0755, true);
                            }
                            $thumbAbs = $thumbDir . DIRECTORY_SEPARATOR . $thumbFilename;
                            $this->generateImageThumbnail($realPath, $thumbAbs, null);
                            $thumbnailPath = $thumbTarget;
                        }
                    }
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning('FileManagerController: could not generate thumbnail', [
                        'message' => $e->getMessage(),
                        'mime' => $mime,
                    ]);
                }
            }
            

            if (! $path) {
                \Illuminate\Support\Facades\Log::error('FileManagerController: stored file path is empty after upload', ['filename' => $filename, 'disk_config' => $diskConfig]);
                return redirect()->back()->with('error', __('Upload failed: could not store the file. Check storage configuration.'));
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
                \Illuminate\Support\Facades\Log::error('FileManagerController: failed to create ManagedFile record', [
                    'message' => $e->getMessage(),
                    'exception' => get_class($e),
                    'path' => $path,
                    'filename' => $filename,
                ]);

                // Attempt cleanup of remote file if present
                try {
                    Storage::disk('file_manager')->delete($path);
                } catch (\Exception $cleanup) {
                    \Illuminate\Support\Facades\Log::warning('FileManagerController: cleanup failed after DB error', ['message' => $cleanup->getMessage(), 'path' => $path]);
                }

                return redirect()->back()->with('error', __('Upload failed: could not persist file metadata. Check logs.'));
            }

            return redirect()->back()->with('message', __('File uploaded successfully (fallback)'));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('FileManagerController: unhandled upload error', [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', __('Upload failed due to an unexpected server error.'));
        }
    }

    private function generateImageThumbnail(string $sourcePath, string $thumbTarget, ?string $disk = null): void
    {
        if (
            ! function_exists('getimagesize') ||
            ! function_exists('imagecreatetruecolor') ||
            ! function_exists('imagecopyresampled') ||
            ! function_exists('imagejpeg')
        ) {
            throw new \RuntimeException('GD extension is not available for thumbnail generation');
        }

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
                if (! function_exists('imagecreatefromjpeg')) {
                    throw new \RuntimeException('JPEG image support is not available');
                }
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                if (! function_exists('imagecreatefrompng')) {
                    throw new \RuntimeException('PNG image support is not available');
                }
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                if (! function_exists('imagecreatefromgif')) {
                    throw new \RuntimeException('GIF image support is not available');
                }
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

        if ($disk) {
            Storage::disk($disk)->put($thumbTarget, $jpegData);
        } else {
            File::put($thumbTarget, $jpegData);
        }
    }
}
