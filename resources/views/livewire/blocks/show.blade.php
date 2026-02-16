<div>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ __('View Block') }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('blocks.edit', $block) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700 font-medium">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                </svg>
                {{ __('Edit') }}
            </a>
            <a href="{{ route('blocks.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 font-medium">
                {{ __('Back') }}
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Package') }}</label>
                <p class="text-lg text-gray-900 dark:text-white">{{ $block->package_name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('State') }}</label>
                <p class="text-lg text-gray-900 dark:text-white">{{ $block->state_name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Business Area') }}</label>
                <p class="text-lg text-gray-900 dark:text-white">{{ $block->business_area }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('District') }}</label>
                <p class="text-lg text-gray-900 dark:text-white">{{ $block->district_name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Block Name') }}</label>
                <p class="text-lg text-gray-900 dark:text-white">{{ $block->block_name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Code') }}</label>
                <p class="text-lg text-gray-900 dark:text-white">{{ $block->code }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Status') }}</label>
                <p class="text-lg">
                    @if($block->status === 'ACTIVE')
                        <span class="inline-block px-3 py-1 text-sm bg-green-100 text-green-800 rounded font-semibold">ACTIVE</span>
                    @else
                        <span class="inline-block px-3 py-1 text-sm bg-gray-100 text-gray-800 rounded">INACTIVE</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
