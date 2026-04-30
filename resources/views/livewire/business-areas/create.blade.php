<div class="p-8">
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('business-areas.index') }}" wire:navigate class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                ← Back to Business Areas
            </a>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mt-4">{{ __('Create Business Area') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('Add a new business area to the system') }}</p>
    </div>

    <div class="max-w-2xl rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-8 shadow-md">
        <form wire:submit="save" class="space-y-6">
            <!-- Package Name -->
            <div>
                <label for="package_name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    {{ __('Package Name') }} <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="package_name" 
                    wire:model="package_name" 
                    placeholder="e.g., Package 4"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                @error('package_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- State Name -->
            <div>
                <label for="state_name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    {{ __('State Name') }} <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="state_name" 
                    wire:model="state_name" 
                    placeholder="e.g., Karnataka"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                @error('state_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Business Name -->
            <div>
                <label for="business_name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    {{ __('Business Name') }} <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="business_name" 
                    wire:model="business_name" 
                    placeholder="e.g., GULBARGA"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                @error('business_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Code -->
            <div>
                <label for="code" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    {{ __('Code') }} <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="code" 
                    wire:model="code" 
                    placeholder="e.g., 000"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                @error('code') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    {{ __('Status') }} <span class="text-red-500">*</span>
                </label>
                <select 
                    id="status" 
                    wire:model="status"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="ACTIVE">Active</option>
                    <option value="INACTIVE">Inactive</option>
                </select>
                @error('status') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-6">
            
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                {{ __('Create BA') }}
            </button>
            <a href="{{ route('business-areas.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 font-medium">
                {{ __('Cancel') }}
            </a>
        </div>
        </form>
    </div>
</div>
