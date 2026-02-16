<div class="p-8">
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('business-areas.index') }}" wire:navigate class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                ← Back to Business Areas
            </a>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mt-4">{{ $businessArea->business_name }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $businessArea->state_name }} • {{ $businessArea->package_name }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Details Card -->
        <div class="lg:col-span-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-8 shadow-md">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Business Area Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Package Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Package Name</label>
                    <p class="text-lg text-gray-900 dark:text-white">{{ $businessArea->package_name }}</p>
                </div>

                <!-- State Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">State Name</label>
                    <p class="text-lg text-gray-900 dark:text-white">{{ $businessArea->state_name }}</p>
                </div>

                <!-- Business Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Business Name</label>
                    <p class="text-lg text-gray-900 dark:text-white">{{ $businessArea->business_name }}</p>
                </div>

                <!-- Code -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Code</label>
                    <p class="text-lg font-mono text-gray-900 dark:text-white">{{ $businessArea->code }}</p>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Status</label>
                    <div>
                        @if($businessArea->status === 'ACTIVE')
                            <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-full text-sm font-semibold">✓ Active</span>
                        @else
                            <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-full text-sm font-semibold">⊘ Inactive</span>
                        @endif
                    </div>
                </div>

                <!-- Created -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Created</label>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $businessArea->created_at->format('M d, Y • H:i') }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-8 border-t border-gray-200 dark:border-gray-700 mt-8">
                <a 
                    href="{{ route('business-areas.edit', $businessArea) }}" 
                    wire:navigate
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 text-center"
                >
                    Edit Business Area
                </a>
                <a 
                    href="{{ route('business-areas.index') }}" 
                    wire:navigate
                    class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white font-semibold rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200 text-center"
                >
                    Back to List
                </a>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-8 shadow-md">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Summary</h3>
            
            <div class="space-y-4">
                <div class="p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Code</p>
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $businessArea->code }}</p>
                </div>

                <div class="p-4 rounded-lg bg-purple-50 dark:bg-purple-900/20">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Package</p>
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{ $businessArea->package_name }}</p>
                </div>

                <div class="p-4 rounded-lg bg-indigo-50 dark:bg-indigo-900/20">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Location</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">{{ $businessArea->state_name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
