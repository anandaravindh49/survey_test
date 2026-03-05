<div class="lg:flex lg:gap-6">
    <!-- Sidebar -->
    <aside class="w-full lg:w-64 mb-4 lg:mb-0">
        <div class="bg-white dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ __('Folders') }}</h3>
            <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                <li>
                    <button wire:click="setFolder('all')" class="w-full text-left px-2 py-1 rounded hover:bg-gray-50 dark:hover:bg-zinc-800">{{ __('All Files') }}</button>
                </li>
                @foreach($folders as $folder)
                    <li>
                        <button wire:click="setFolder('{{ $folder }}')" class="w-full text-left px-2 py-1 rounded hover:bg-gray-50 dark:hover:bg-zinc-800">{{ $folder === '.' ? __('(root)') : $folder }}</button>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400">{{ __('Quick Stats') }}</h4>
                @php
                    $totalFiles = \App\Models\ManagedFile::count();
                    $totalSize = \App\Models\ManagedFile::sum('size');
                @endphp
                <div class="text-sm text-gray-700 dark:text-gray-300 mt-2">{{ __('Total') }}: <strong>{{ $totalFiles }}</strong></div>
                <div class="text-sm text-gray-700 dark:text-gray-300">{{ __('Storage') }}: <strong>{{ number_format($totalSize) }} bytes</strong></div>
            </div>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1">
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('File Manager') }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Upload and manage files stored on the configured File Manager disk.') }}</p>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 px-4 py-2 rounded bg-green-50 dark:bg-green-900/20 text-green-700">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="mb-4 px-4 py-2 rounded bg-red-50 dark:bg-red-900/20 text-red-700">{{ session('error') }}</div>
        @endif

        <div class="mb-6 bg-white dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <!-- Single standard upload form (multipart/form-data) -->
            <form action="{{ route('file-manager.upload') }}" method="POST" enctype="multipart/form-data" class="flex gap-3 items-center">
                @csrf
                <input name="file" type="file" class="text-sm text-gray-700 dark:text-gray-300" required />
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Upload') }}</button>
                <div class="ml-auto flex items-center gap-2">
                    <input wire:model.debounce.500ms="search" placeholder="{{ __('Search files...') }}" class="px-3 py-2 rounded border bg-white dark:bg-zinc-800 border-gray-200 dark:border-zinc-700 text-sm" />
                    <div class="text-sm text-gray-500">{{ __('Max: 100 MB') }}</div>
                </div>
            </form>
            @error('upload') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ __('Files') }}</h3>
            <div class="grid gap-2">
                @forelse($files as $file)
                    <div class="flex items-center justify-between p-2 rounded hover:bg-gray-50 dark:hover:bg-zinc-800">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10v10H7z"></path></svg>
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $file['name'] }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($file['size']) }} bytes • {{ $file['created_at'] }} @if($file['user']) • {{ $file['user'] }} @endif</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            @if(!empty($file['download_url']))
                                <a href="{{ $file['download_url'] }}" target="_blank" rel="noopener noreferrer" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('View') }}</a>
                            @endif

                            <a href="{{ $file['download_url'] ?? $file['url'] ?? '#' }}" target="_blank" download="{{ $file['name'] }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">{{ __('Download') }}</a>

                            <button wire:click="deleteFile({{ $file['id'] }})" class="text-sm text-red-600 hover:underline">{{ __('Delete') }}</button>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-500">{{ __('No files found') }}</div>
                @endforelse
            </div>
        </div>
    </main>
</div>
