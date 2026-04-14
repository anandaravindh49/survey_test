<div class="rounded-2xl bg-gradient-to-br from-indigo-50 via-white to-sky-50 p-4 shadow-sm ring-1 ring-black/5 dark:from-zinc-950 dark:via-zinc-950 dark:to-slate-950 dark:ring-white/10 sm:p-6">
<div class="lg:flex lg:gap-6">
    <!-- Sidebar -->
    <aside class="w-full lg:w-64 mb-4 lg:mb-0">
        <div class="rounded-2xl border border-black/5 bg-white/80 p-4 shadow-sm backdrop-blur dark:border-white/10 dark:bg-zinc-950/60">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('Folders') }}</h3>
                <span class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-200 dark:ring-indigo-500/20">
                    {{ count($folders) }} {{ __('groups') }}
                </span>
            </div>

            <ul class="mt-3 text-sm text-gray-700 dark:text-gray-200 space-y-1.5">
                <li>
                    <button
                        wire:click="setFolder('all')"
                        class="group w-full text-left px-3 py-2 rounded-xl transition flex items-center gap-2
                            {{ $filterFolder === null ? 'bg-indigo-600 text-white shadow-sm' : 'hover:bg-indigo-50/70 dark:hover:bg-white/5' }}"
                    >
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg {{ $filterFolder === null ? 'bg-white/15' : 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-200' }}">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M4 4a2 2 0 0 1 2-2h2.586A2 2 0 0 1 10 2.586L11.414 4H14a2 2 0 0 1 2 2v2H4V4Z"/><path d="M4 9h12v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9Z"/></svg>
                        </span>
                        <span class="font-medium">{{ __('All Files') }}</span>
                    </button>
                </li>
                @foreach($folders as $folder)
                    <li>
                        @php
                            $isActiveFolder = ($filterFolder === $folder);
                        @endphp
                        <button
                            wire:click="setFolder({{ \Illuminate\Support\Js::from($folder) }})"
                            class="group w-full text-left px-3 py-2 rounded-xl transition flex items-center gap-2
                                {{ $isActiveFolder ? 'bg-indigo-600 text-white shadow-sm' : 'hover:bg-indigo-50/70 dark:hover:bg-white/5' }}"
                        >
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg {{ $isActiveFolder ? 'bg-white/15' : 'bg-sky-100 text-sky-700 dark:bg-sky-500/10 dark:text-sky-200' }}">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M2 6a2 2 0 0 1 2-2h4.586A2 2 0 0 1 10 4.586L11.414 6H16a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6Z"/></svg>
                            </span>
                            <span class="font-medium truncate">{{ $folder === '.' ? __('(root)') : $folder }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400">{{ __('Quick Stats') }}</h4>
                @php
                    $totalFiles = \App\Models\ManagedFile::count();
                    $totalSize = \App\Models\ManagedFile::sum('size');
                @endphp
                <div class="mt-2 grid grid-cols-2 gap-2">
                    <div class="rounded-xl bg-emerald-50 px-3 py-2 ring-1 ring-inset ring-emerald-200 dark:bg-emerald-500/10 dark:ring-emerald-500/20">
                        <div class="text-[11px] font-medium text-emerald-700 dark:text-emerald-200">{{ __('Total') }}</div>
                        <div class="text-sm font-semibold text-emerald-900 dark:text-emerald-50">{{ $totalFiles }}</div>
                    </div>
                    <div class="rounded-xl bg-amber-50 px-3 py-2 ring-1 ring-inset ring-amber-200 dark:bg-amber-500/10 dark:ring-amber-500/20">
                        <div class="text-[11px] font-medium text-amber-700 dark:text-amber-200">{{ __('Storage') }}</div>
                        <div class="text-sm font-semibold text-amber-900 dark:text-amber-50">{{ number_format($totalSize) }} <span class="text-xs font-medium opacity-70">{{ __('bytes') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1">
        <div class="mb-4">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ __('File Manager') }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Upload and manage files stored on the configured File Manager disk.') }}</p>
                </div>
                <div class="mt-2 inline-flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                    <span class="inline-flex items-center gap-1 rounded-full bg-white/70 px-2 py-1 ring-1 ring-inset ring-black/5 dark:bg-white/5 dark:ring-white/10">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        {{ __('Max') }}: 100 MB
                    </span>
                </div>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-200">
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-600 text-white dark:bg-emerald-500">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.2 7.3a1 1 0 0 1-1.42.01l-3.5-3.4a1 1 0 1 1 1.394-1.43l2.79 2.71 6.49-6.58a1 1 0 0 1 1.44-.024Z" clip-rule="evenodd"/></svg>
                    </span>
                    <div class="text-sm font-medium">{{ session('message') }}</div>
                </div>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 shadow-sm dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-200">
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 inline-flex h-8 w-8 items-center justify-center rounded-xl bg-rose-600 text-white dark:bg-rose-500">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-1-11a1 1 0 0 1 2 0v4a1 1 0 1 1-2 0V7Zm1 8a1.25 1.25 0 1 0 0-2.5A1.25 1.25 0 0 0 10 15Z" clip-rule="evenodd"/></svg>
                    </span>
                    <div class="text-sm font-medium">{{ session('error') }}</div>
                </div>
            </div>
        @endif

        <div class="mb-6 rounded-2xl border border-black/5 bg-white/80 p-4 shadow-sm backdrop-blur dark:border-white/10 dark:bg-zinc-950/60">
            <!-- Single standard upload form (multipart/form-data) -->
            <div class="mb-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-600 to-sky-500 text-white shadow-sm">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M3 14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-3a1 1 0 1 0-2 0v3H5v-3a1 1 0 1 0-2 0v3Z"/><path d="M7 9a1 1 0 0 0 1 1h.586L9 10.414V4a1 1 0 1 1 2 0v6.414l.414-.414H12a1 1 0 1 0 0-2h-1.586L10 7.586 9.586 8H8a1 1 0 0 0-1 1Z"/></svg>
                    </span>
                    <div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('Upload') }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('Images, PDF, DOC/DOCX') }}</div>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <span class="inline-flex items-center rounded-full bg-sky-50 px-2.5 py-1 text-xs font-medium text-sky-700 ring-1 ring-inset ring-sky-200 dark:bg-sky-500/10 dark:text-sky-200 dark:ring-sky-500/20">
                        {{ __('Tip') }}: {{ __('Use search to filter quickly') }}
                    </span>
                </div>
            </div>

            <form action="{{ route('file-manager.upload') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                @csrf
                <div class="flex flex-1 flex-col gap-2 sm:flex-row sm:items-center">
                    <input
                        id="uploadInput"
                        name="file"
                        type="file"
                        accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                        class="w-full text-sm text-gray-700 file:mr-4 file:rounded-xl file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 dark:text-gray-200 dark:file:bg-indigo-500/10 dark:file:text-indigo-200 dark:hover:file:bg-indigo-500/20"
                        required
                        onchange="previewUploadFile(event)"
                    />
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-sky-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:from-indigo-500 hover:to-sky-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                        {{ __('Upload') }}
                    </button>
                </div>
                <div class="flex items-center gap-2 sm:ml-auto">
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9 3a6 6 0 1 0 3.476 10.95l3.287 3.287a1 1 0 0 0 1.414-1.414l-3.287-3.287A6 6 0 0 0 9 3Zm-4 6a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"/></svg>
                        </span>
                        <input wire:model.debounce.500ms="search" placeholder="{{ __('Search files...') }}" class="w-full rounded-xl border border-black/10 bg-white/80 py-2 pl-9 pr-3 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 dark:border-white/10 dark:bg-white/5 dark:text-white dark:placeholder:text-zinc-500" />
                    </div>
                </div>
            </form>
            <div id="uploadPreviewContainer" class="mt-3 hidden">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('Image preview before upload') }}</p>
                <img id="uploadPreview" class="h-36 w-36 object-cover rounded-2xl border border-black/10 shadow-sm dark:border-white/10" alt="{{ __('Preview') }}" />
            </div>
            @error('upload') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="rounded-2xl border border-black/5 bg-white/80 p-4 shadow-sm backdrop-blur dark:border-white/10 dark:bg-zinc-950/60">
            <div class="mb-3 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Files') }}</h3>
                <span class="inline-flex items-center rounded-full bg-violet-50 px-2.5 py-1 text-xs font-medium text-violet-700 ring-1 ring-inset ring-violet-200 dark:bg-violet-500/10 dark:text-violet-200 dark:ring-violet-500/20">
                    {{ count($files) }} {{ __('items') }}
                </span>
            </div>

            <div class="grid gap-2">
                @forelse($files as $file)
                    <div class="group flex flex-col justify-between gap-3 rounded-2xl border border-black/5 bg-white/60 p-3 shadow-sm transition hover:bg-white/90 hover:shadow md:flex-row md:items-center dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/7">
                        <div class="flex items-center gap-3 min-w-0">
                                @php
                                    $isImage = str_starts_with($file['mime'] ?? '', 'image/');
                                    $previewUrl = $file['thumbnail_url'] ?: ($isImage ? ($file['download_url'] ?? '#') : null);
                                    $mime = $file['mime'] ?? '';
                                @endphp
                                @if(!empty($previewUrl))
                                    <img class="h-12 w-12 rounded-2xl object-cover border border-black/10 shadow-sm dark:border-white/10" src="{{ $previewUrl }}" alt="{{ $file['name'] }} thumbnail" />
                                @else
                                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-200 to-rose-200 text-rose-700 shadow-sm dark:from-amber-500/20 dark:to-rose-500/20 dark:text-rose-200">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M4 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.414A2 2 0 0 0 19.414 6L14 0.586A2 2 0 0 0 12.586 0H4Z"/><path d="M13 1.5V6a1 1 0 0 0 1 1h4.5"/></svg>
                                    </div>
                                @endif
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <div class="truncate text-sm font-semibold text-gray-900 dark:text-white">{{ $file['name'] }}</div>
                                    @if($mime)
                                        <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-[11px] font-medium text-slate-700 ring-1 ring-inset ring-slate-200 dark:bg-white/5 dark:text-slate-200 dark:ring-white/10">
                                            {{ $mime }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500 dark:text-gray-400">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path fill="#fff" d="M10 5.5a.75.75 0 0 1 .75.75v4.03l2.36 1.36a.75.75 0 1 1-.75 1.3l-2.75-1.59A.75.75 0 0 1 9.25 11V6.25A.75.75 0 0 1 10 5.5Z"/></svg>
                                        {{ $file['created_at'] }}
                                    </span>
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M4 3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8.414A2 2 0 0 0 19.414 7L14 1.586A2 2 0 0 0 12.586 1H4Z"/></svg>
                                        {{ number_format($file['size']) }} {{ __('bytes') }}
                                    </span>
                                    @if($file['user'])
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 2a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-7 16a7 7 0 0 1 14 0H3Z" clip-rule="evenodd"/></svg>
                                            {{ $file['user'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 md:justify-end">
                            @if(!empty($file['download_url']))
                                <a href="{{ $file['download_url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-xl bg-indigo-50 px-3 py-2 text-sm font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200 transition hover:bg-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-200 dark:ring-indigo-500/20 dark:hover:bg-indigo-500/20">
                                    {{ __('View') }}
                                </a>
                            @endif

                            <a href="{{ $file['download_url'] ?? $file['url'] ?? '#' }}" target="_blank" download="{{ $file['name'] }}" class="inline-flex items-center justify-center rounded-xl bg-sky-50 px-3 py-2 text-sm font-semibold text-sky-700 ring-1 ring-inset ring-sky-200 transition hover:bg-sky-100 dark:bg-sky-500/10 dark:text-sky-200 dark:ring-sky-500/20 dark:hover:bg-sky-500/20">
                                {{ __('Download') }}
                            </a>

                            <button wire:click="deleteFile({{ $file['id'] }})" class="inline-flex items-center justify-center rounded-xl bg-rose-50 px-3 py-2 text-sm font-semibold text-rose-700 ring-1 ring-inset ring-rose-200 transition hover:bg-rose-100 dark:bg-rose-500/10 dark:text-rose-200 dark:ring-rose-500/20 dark:hover:bg-rose-500/20">
                                {{ __('Delete') }}
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-black/10 bg-white/60 px-6 py-10 text-center dark:border-white/10 dark:bg-white/5">
                        <div class="mx-auto mb-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-sky-500 text-white shadow-sm">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M4 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.414A2 2 0 0 0 19.414 6L14 0.586A2 2 0 0 0 12.586 0H4Z"/><path d="M13 1.5V6a1 1 0 0 0 1 1h4.5"/></svg>
                        </div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('No files found') }}</div>
                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('Try a different folder or clear your search.') }}</div>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
</div>

<script>
    function previewUploadFile(event) {
        const file = event.target.files[0];
        const previewEl = document.getElementById('uploadPreview');
        const container = document.getElementById('uploadPreviewContainer');

        if (!file || !file.type.startsWith('image/')) {
            container.classList.add('hidden');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            previewEl.src = e.target.result;
            container.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
</script>
