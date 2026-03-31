<div class="p-8">
    <div class="mb-8">
        <a href="{{ route('districts.index') }}" wire:navigate class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Districts
        </a>
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ __('District Details') }}</h1>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-md p-8 border border-slate-200 dark:border-slate-700">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Package Name -->
                <div class="bg-gray-50 dark:bg-slate-800 rounded-lg p-4">
                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Package Name</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $district->package_name }}</p>
                </div>

                <!-- State Name -->
                <div class="bg-gray-50 dark:bg-slate-800 rounded-lg p-4">
                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">State Name</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $district->state_name }}</p>
                </div>

                <!-- Business Area -->
                <div class="bg-gray-50 dark:bg-slate-800 rounded-lg p-4">
                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Business Area</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $district->business_area ?? 'N/A' }}</p>
                </div>

                <!-- District Name -->
                <div class="bg-gray-50 dark:bg-slate-800 rounded-lg p-4">
                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">District Name</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $district->district_name }}</p>
                </div>

                <!-- Code -->
                <div class="bg-gray-50 dark:bg-slate-800 rounded-lg p-4">
                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Code</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $district->code }}</p>
                </div>

                <!-- Status -->
                <div class="bg-gray-50 dark:bg-slate-800 rounded-lg p-4">
                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</p>
                    <div class="mt-1">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $district->status === 'ACTIVE' ? 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-300' }}">
                            {{ $district->status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Created/Updated Info -->
            <div class="border-t border-gray-200 dark:border-slate-700 pt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <div>
                        <p class="font-semibold mb-1">Created:</p>
                        <p>{{ $district->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="font-semibold mb-1">Last Updated:</p>
                        <p>{{ $district->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                <a 
                    href="{{ route('districts.edit', $district) }}" 
                    wire:navigate
                    class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
                >
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a 
                    href="{{ route('districts.index') }}" 
                    wire:navigate
                    class="px-6 py-3 bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
                >
                    Back
                </a>
            </div>
        </div>
    </div>
</div>
