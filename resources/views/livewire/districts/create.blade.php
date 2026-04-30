<div class="p-8">
    <div class="mb-8">
        <a href="{{ route('districts.index') }}" wire:navigate class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Districts
        </a>
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ __('Create District') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('Add a new District to the system') }}</p>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-md p-8 border border-slate-200 dark:border-slate-700">
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Package Name -->
                <div>
                    <label for="package_name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Package Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="package_name"
                        wire:model="package_name" 
                        placeholder="e.g., Package 7"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('package_name') <span class="text-red-600 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- State Name -->
                <div>
                    <label for="state_name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        State Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="state_name"
                        wire:model="state_name" 
                        placeholder="e.g., Bihar"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('state_name') <span class="text-red-600 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Business Area -->
                <div>
                    <label for="business_area" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Business Area
                    </label>
                    <input 
                        type="text" 
                        id="business_area"
                        wire:model="business_area" 
                        placeholder="e.g., N/A"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('business_area') <span class="text-red-600 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- District Name -->
                <div>
                    <label for="district_name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        District Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="district_name"
                        wire:model="district_name" 
                        placeholder="e.g., AMROHA"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('district_name') <span class="text-red-600 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Code -->
                <div>
                    <label for="code" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Code <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="code"
                        wire:model="code" 
                        placeholder="e.g., 147"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('code') <span class="text-red-600 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="status"
                        wire:model="status"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                    </select>
                    @error('status') <span class="text-red-600 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Buttons -->
           <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                {{ __('Create District') }}
            </button>
                <a 
                    href="{{ route('districts.index') }}" 
                    wire:navigate
                    class="px-6 py-3 bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
