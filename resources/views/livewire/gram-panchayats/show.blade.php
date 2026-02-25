<div>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Gram Panchayat Details') }}</h1>
        <a href="{{ route('gram-panchayats.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 font-medium">
            {{ __('Back') }}
        </a>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $gramPanchayat->gp_name }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">GP Code: {{ $gramPanchayat->gp_code }}</p>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('State') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $gramPanchayat->state_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Business Area') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $gramPanchayat->business_area }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('District') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $gramPanchayat->district_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Block') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $gramPanchayat->block_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('GP Name') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $gramPanchayat->gp_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('GP Code') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $gramPanchayat->gp_code }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('GP Type') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $gramPanchayat->gp_type ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Status') }}</dt>
                    <dd class="mt-1">
                        @if($gramPanchayat->status === 'ACTIVE')
                            <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded font-semibold">ACTIVE</span>
                        @else
                            <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">INACTIVE</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Created At') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $gramPanchayat->created_at?->format('M d, Y H:i') ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Updated At') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $gramPanchayat->updated_at?->format('M d, Y H:i') ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex gap-2">
            <a href="{{ route('gram-panchayats.edit', $gramPanchayat) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-800 dark:bg-zinc-700 text-white rounded hover:bg-zinc-900 dark:hover:bg-zinc-600 font-medium">
                {{ __('Edit') }}
            </a>
        </div>
    </div>
</div>
