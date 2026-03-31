<?php

// Copy of the Livewire temporary upload config with increased limits
return [
    'temporary_file_upload' => [
        // Keep disk default (uses default disk unless you override with LIVEWIRE_TEMPORARY_FILE_UPLOAD_DISK)
        'disk' => env('LIVEWIRE_TEMPORARY_FILE_UPLOAD_DISK'),
        // Allow temporary uploads up to 100 MB (size is in KB for validation rules)
        'rules' => ['required', 'file', 'max:102400'],
        'directory' => env('LIVEWIRE_TEMPORARY_FILE_UPLOAD_DIRECTORY', null),
        'middleware' => env('LIVEWIRE_TEMPORARY_FILE_UPLOAD_MIDDLEWARE', null),
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5, // minutes
        'cleanup' => true,
    ],

    // Fallback sensible defaults for other Livewire config keys the package expects
    'class_namespace' => 'App\\Livewire',
    'class_path' => app_path('Livewire'),
    'view_path' => resource_path('views/livewire'),
    'component_locations' => [resource_path('views/components'), resource_path('views/livewire')],
    'component_namespaces' => ['layouts' => resource_path('views/layouts'), 'pages' => resource_path('views/pages')],
    'component_layout' => 'layouts::app',
    'inject_assets' => true,
    'navigate' => ['show_progress_bar' => true, 'progress_bar_color' => '#2299dd'],
    'pagination_theme' => 'tailwind',
    'inject_morph_markers' => true,
    'smart_wire_keys' => true,
    'render_on_redirect' => false,
    'legacy_model_binding' => false,
    'release_token' => 'a',
];
