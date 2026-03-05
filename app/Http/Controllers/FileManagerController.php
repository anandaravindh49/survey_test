<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\ManagedFile;

class FileManagerController extends Controller
{
    /**
     * Fallback upload handler (non-Livewire) — useful when JS/AJAX uploads fail.
     */
    public function upload(Request $request)
    {
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

        try {
            if (in_array($diskConfig['driver'], ['s3', 's3v3', 's3-compat'], true)) {
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
            } else {
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

        // Use the uploaded file size instead of asking the remote disk for metadata
        $size = $file->getSize() ?: 0;
        $mime = $file->getClientMimeType();

        if (! $path) {
            \Illuminate\Support\Facades\Log::error('FileManagerController: stored file path is empty after upload', ['filename' => $filename, 'disk_config' => $diskConfig]);
            return redirect()->back()->with('error', __('Upload failed: could not store the file. Check storage configuration.'));
        }

        try {
            ManagedFile::create([
                'name' => $original,
                'path' => $path,
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
    }
}
