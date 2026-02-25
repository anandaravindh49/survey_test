<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Gram Panchayat Details</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">View gram panchayat information</p>
        </div>
        <a href="{{ route('gram-panchayats.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-zinc-200 dark:hover:bg-zinc-600 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-800 shadow-sm rounded-lg border border-zinc-200 dark:border-zinc-700">
        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $gramPanchayat->gp_name }}</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">GP Code: {{ $gramPanchayat->gp_code }}</p>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">State</dt>
                    <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $gramPanchayat->state_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Business Area</dt>
                    <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $gramPanchayat->business_area }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">District</dt>
                    <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $gramPanchayat->district_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Block</dt>
                    <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $gramPanchayat->block_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">GP Name</dt>
                    <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $gramPanchayat->gp_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">GP Code</dt>
                    <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $gramPanchayat->gp_code }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">GP Type</dt>
                    <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $gramPanchayat->gp_type ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Status</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gramPanchayat->status === 'ACTIVE' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' }}">
                            {{ $gramPanchayat->status }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Created At</dt>
                    <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $gramPanchayat->created_at?->format('M d, Y H:i') ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Updated At</dt>
                    <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $gramPanchayat->updated_at?->format('M d, Y H:i') ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 flex space-x-3">
            <a href="{{ route('gram-panchayats.edit', $gramPanchayat) }}" class="inline-flex items-center px-4 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-200 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
        </div>
    </div>
</div>
