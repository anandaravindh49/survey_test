<?php

use App\Livewire\Users\Main as UsersMain;
use App\Livewire\Users\Show as UsersShow;
use App\Livewire\Users\Create as UsersCreate;
use App\Livewire\Users\Edit as UsersEdit;
use App\Livewire\BusinessAreas\Main as BusinessAreasMain;
use App\Livewire\BusinessAreas\Show as BusinessAreasShow;
use App\Livewire\BusinessAreas\Create as BusinessAreasCreate;
use App\Livewire\BusinessAreas\Edit as BusinessAreasEdit;
use App\Livewire\Districts\Main as DistrictsMain;
use App\Livewire\Districts\Show as DistrictsShow;
use App\Livewire\Districts\Create as DistrictsCreate;
use App\Livewire\Districts\Edit as DistrictsEdit;
use App\Livewire\Blocks\Main as BlocksMain;
use App\Livewire\Blocks\Show as BlocksShow;
use App\Livewire\Blocks\Create as BlocksCreate;
use App\Livewire\Blocks\Edit as BlocksEdit;
use App\Livewire\Machines\Main as MachinesMain;
use App\Livewire\Machines\Show as MachinesShow;
use App\Livewire\Machines\Create as MachinesCreate;
use App\Livewire\Machines\Edit as MachinesEdit;
use App\Livewire\GramPanchayats\Main as GramPanchayatsMain;
use App\Livewire\GramPanchayats\Show as GramPanchayatsShow;
use App\Livewire\GramPanchayats\Create as GramPanchayatsCreate;
use App\Livewire\GramPanchayats\Edit as GramPanchayatsEdit;
use App\Livewire\FileManager as FileManager;
use App\Http\Controllers\FileManagerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');

Route::get('/test', function () {
    return "Working";
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Users Routes
    Route::get('users', UsersMain::class)->name('users.index');
    Route::get('users/create', UsersCreate::class)->name('users.create');
    Route::get('users/{user}', UsersShow::class)->name('users.show');
    Route::get('users/{user}/edit', UsersEdit::class)->name('users.edit');

    // Business Areas Routes
    Route::get('business-areas', BusinessAreasMain::class)->name('business-areas.index');
    Route::get('business-areas/create', BusinessAreasCreate::class)->name('business-areas.create');
    Route::get('business-areas/{businessArea}', BusinessAreasShow::class)->name('business-areas.show');
    Route::get('business-areas/{businessArea}/edit', BusinessAreasEdit::class)->name('business-areas.edit');

    // Districts Routes
    Route::get('districts', DistrictsMain::class)->name('districts.index');
    Route::get('districts/create', DistrictsCreate::class)->name('districts.create');
    Route::get('districts/{district}', DistrictsShow::class)->name('districts.show');
    Route::get('districts/{district}/edit', DistrictsEdit::class)->name('districts.edit');

    // Blocks Routes
    Route::get('blocks', BlocksMain::class)->name('blocks.index');
    Route::get('blocks/create', BlocksCreate::class)->name('blocks.create');
    Route::get('blocks/{block}', BlocksShow::class)->name('blocks.show');
    Route::get('blocks/{block}/edit', BlocksEdit::class)->name('blocks.edit');

    // Machines Routes
    Route::get('machines', MachinesMain::class)->name('machines.index');
    Route::get('machines/create', MachinesCreate::class)->name('machines.create');
    Route::get('machines/{machine}', MachinesShow::class)->name('machines.show');
    Route::get('machines/{machine}/edit', MachinesEdit::class)->name('machines.edit');

    // Gram Panchayats Routes
    Route::get('gram-panchayats', GramPanchayatsMain::class)->name('gram-panchayats.index');
    Route::get('gram-panchayats/create', GramPanchayatsCreate::class)->name('gram-panchayats.create');
    Route::get('gram-panchayats/{gramPanchayat}', GramPanchayatsShow::class)->name('gram-panchayats.show');
    Route::get('gram-panchayats/{gramPanchayat}/edit', GramPanchayatsEdit::class)->name('gram-panchayats.edit');
    
    // File Manager
Route::get('file-manager', FileManager::class)->name('file-manager.index');

// POST handler for uploads
Route::post('file-manager/upload', [FileManagerController::class, 'upload'])->name('file-manager.upload');

// Redirect GET upload
Route::get('file-manager/upload', function () {
    return redirect()->route('file-manager.index');
})->name('file-manager.upload.redirect');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', function () {
        return 'Admin panel';
    });
});

Route::get('/file-view/{path}', function ($path) {

    $path = base64_decode($path);

    try {

        $disk = Storage::disk('file_manager');

        // Some S3-compatible drivers may throw on exists()/HEAD checks even when
        // the object is readable via GET. Prefer attempting readStream directly.
        $stream = null;
        try {
            $stream = $disk->readStream($path);
        } catch (\Throwable $_) {
            $stream = null;
        }

        if (! $stream) {
            abort(404);
        }

        // Determine a sensible MIME type so browsers will attempt to display
        // the file inline instead of forcing a download. Preference order:
                $diskConfig = config('filesystems.disks.file_manager', []);
                $driver = $diskConfig['driver'] ?? null;

                if ($driver === 'local') {
                    $localPath = $disk->path($path);
                    if (file_exists($localPath)) {
                        $mime = mime_content_type($localPath) ?: 'application/octet-stream';
                        return response()->file($localPath, ['Content-Type' => $mime]);
                    }
                }
        // 2) guess from file extension
        // 3) fallback to application/octet-stream
        $mime = 'application/octet-stream';

        try {
            $mf = \App\Models\ManagedFile::where('path', $path)->first();
            if ($mf && ! empty($mf->mime) && $mf->mime !== 'application/octet-stream') {
                $mime = $mf->mime;
            } else {
                // Guess from extension for common displayable types.
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $map = [
                    'pdf' => 'application/pdf',
                    'txt' => 'text/plain',
                    'html' => 'text/html',
                    'htm' => 'text/html',
                    'md' => 'text/markdown',
                    'csv' => 'text/csv',
                    'json' => 'application/json',
                    'xml' => 'application/xml',
                    'svg' => 'image/svg+xml',
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp',
                    'bmp' => 'image/bmp',
                    'mp4' => 'video/mp4',
                    'webm' => 'video/webm',
                    'ogg' => 'video/ogg',
                    'mp3' => 'audio/mpeg',
                    'wav' => 'audio/wav',
                    'doc' => 'application/msword',
                    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'xls' => 'application/vnd.ms-excel',
                    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'ppt' => 'application/vnd.ms-powerpoint',
                    'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                ];

                if (isset($map[$ext])) {
                    $mime = $map[$ext];
                } else {
                    // As a last effort, attempt to use the disk adapter's mimeType
                    // if available — wrapped in try/catch because some adapters
                    // may not implement it or throw for remote files.
                    try {
                        if (method_exists($disk, 'mimeType')) {
                            $detected = $disk->mimeType($path);
                            if (! empty($detected)) {
                                $mime = $detected;
                            }
                        }
                    } catch (\Throwable $_) {
                        // ignore
                    }
                }
            }
        } catch (\Throwable $_) {
            // ignore and fallback to octet-stream
        }

        // For Office documents (Word/Excel/PowerPoint) browsers typically
        // force a download. Try to redirect to Google Docs Viewer which can
        // render these formats inside the browser if the file is reachable
        // by Google (i.e. public or temporary URL).
        $officeExts = ['doc','docx','xls','xlsx','ppt','pptx'];
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($ext, $officeExts, true)) {
            try {
                $publicUrl = null;

                if (! empty($mf) && method_exists($mf, 'url')) {
                    try {
                        $publicUrl = $mf->url();
                    } catch (\Throwable $_) {
                        $publicUrl = null;
                    }
                }

                // If we couldn't get a direct public URL, try generating a
                // temporary URL from the storage disk (S3, etc.).
                if (empty($publicUrl)) {
                    try {
                        if (method_exists(Storage::disk($mf->disk), 'temporaryUrl')) {
                            $publicUrl = Storage::disk($mf->disk)->temporaryUrl($path, now()->addMinutes(10));
                        }
                    } catch (\Throwable $_) {
                        $publicUrl = null;
                    }
                }

                if (! empty($publicUrl)) {
                    return redirect()->to('https://docs.google.com/gview?url=' . urlencode($publicUrl) . '&embedded=true');
                }
            } catch (\Throwable $_) {
                // ignore and fall back to streaming
            }
        }

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            "Content-Type" => $mime,
            "Content-Disposition" => "inline; filename=\"" . basename($path) . "\""
        ]);

    } catch (\Throwable $e) {
        abort(404);
    }

})->where('path', '.*')->name('file-manager.view');
});

require __DIR__.'/settings.php';

// Local-only diagnostic route to test `file_manager` disk connectivity.
// Returns a small JSON result and does not expose credentials. Only enabled
// when `APP_ENV=local` to avoid accidental exposure on production.
if (app()->environment('local')) {
    Route::get('file-manager/diagnose', function () {
        $cfg = config('filesystems.disks.file_manager', []);
        $safe = [
            'driver' => $cfg['driver'] ?? null,
            'bucket' => $cfg['bucket'] ?? null,
            'region' => $cfg['region'] ?? null,
            'endpoint' => $cfg['endpoint'] ?? null,
            'use_path_style_endpoint' => $cfg['use_path_style_endpoint'] ?? null,
        ];

        $results = ['disk' => $safe, 'flysystem' => null, 'aws_sdk' => null];

        // 1) Try Flysystem (Storage facade)
        try {
            $disk = \Illuminate\Support\Facades\Storage::disk('file_manager');
            $path = 'diagnostic/'.time().'-test.txt';
            $ok = $disk->put($path, 'ok');
            $exists = $disk->exists($path);
            $results['flysystem'] = ['put' => (bool) $ok, 'exists' => (bool) $exists];
            // Cleanup
            try { $disk->delete($path); } catch (\Exception $_) { /* ignore */ }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('file-manager/diagnose: flysystem test failed', ['message' => $e->getMessage(), 'disk' => $safe]);
            $results['flysystem'] = ['error' => $e->getMessage()];
        }

        // 2) Try AWS SDK directly (construct S3Client from disk config)
        try {
            if (empty($cfg['driver']) || ($cfg['driver'] !== 's3' && $cfg['driver'] !== 'aws')) {
                $results['aws_sdk'] = ['skipped' => 'disk driver not s3'];
            } else {
                $s3config = [
                    'version' => 'latest',
                    'region' => $cfg['region'] ?? env('AWS_DEFAULT_REGION'),
                ];

                // Credentials only set if present — we will not echo them back
                if (! empty($cfg['key']) && ! empty($cfg['secret'])) {
                    $s3config['credentials'] = ['key' => $cfg['key'], 'secret' => $cfg['secret']];
                } elseif (! empty(env('AWS_ACCESS_KEY_ID')) && ! empty(env('AWS_SECRET_ACCESS_KEY'))) {
                    $s3config['credentials'] = ['key' => env('AWS_ACCESS_KEY_ID'), 'secret' => env('AWS_SECRET_ACCESS_KEY')];
                }

                if (! empty($cfg['endpoint'])) {
                    $s3config['endpoint'] = $cfg['endpoint'];
                } elseif (! empty(env('AWS_ENDPOINT'))) {
                    $s3config['endpoint'] = env('AWS_ENDPOINT');
                }

                if (! empty($cfg['use_path_style_endpoint'])) {
                    $s3config['use_path_style_endpoint'] = (bool) $cfg['use_path_style_endpoint'];
                }

                $s3 = new \Aws\S3\S3Client($s3config);
                $bucket = $cfg['bucket'] ?? env('AWS_BUCKET');
                $key = 'diagnostic/'.time().'-sdk-test.txt';

                $put = $s3->putObject(['Bucket' => $bucket, 'Key' => $key, 'Body' => 'ok']);
                $results['aws_sdk'] = ['http_status' => $put['@metadata']['statusCode'] ?? null, 'request_id' => $put['@metadata']['requestId'] ?? null];
                // Cleanup
                try { $s3->deleteObject(['Bucket' => $bucket, 'Key' => $key]); } catch (\Exception $_) { /* ignore */ }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('file-manager/diagnose: aws sdk test failed', ['message' => $e->getMessage(), 'disk' => $safe]);
            $results['aws_sdk'] = ['error' => $e->getMessage()];
        }

        return response()->json($results);
    });
}
