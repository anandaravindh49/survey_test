<div class="p-8">
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('gram-panchayats.index') }}" wire:navigate class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                ← Back to Gram Panchayats
            </a>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mt-4">{{ __('Create Gram Panchayats') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('Add a new Gram Panchayat to the system') }}</p>
    </div>

    <form wire:submit="save" class="bg-white dark:bg-gray-900 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('State') }} *</label>
                <input type="text" wire:model="state_name" list="statesList" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <datalist id="statesList">
                    @foreach($states as $state)
                        <option value="{{ $state }}">
                    @endforeach
                </datalist>
                @error('state_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Business Area') }} *</label>
                <input type="text" wire:model="business_area" list="businessAreasList" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <datalist id="businessAreasList">
                    @foreach($businessAreas as $ba)
                        <option value="{{ $ba }}">
                    @endforeach
                </datalist>
                @error('business_area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('District') }} *</label>
                <input type="text" wire:model="district_name" list="districtsList" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <datalist id="districtsList">
                    @foreach($districts as $district)
                        <option value="{{ $district }}">
                    @endforeach
                </datalist>
                @error('district_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Block') }} *</label>
                <input type="text" wire:model="block_name" list="blocksList" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <datalist id="blocksList">
                    @foreach($blocks as $block)
                        <option value="{{ $block }}">
                    @endforeach
                </datalist>
                @error('block_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('GP Name') }} *</label>
                <input type="text" wire:model="gp_name" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('gp_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('GP Code') }} *</label>
                <input type="text" wire:model="gp_code" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('gp_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('GP Type') }}</label>
                <input type="text" wire:model="gp_type" list="gpTypesList" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <datalist id="gpTypesList">
                    @foreach($gpTypes as $type)
                        <option value="{{ $type }}">
                    @endforeach
                </datalist>
                @error('gp_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Status') }} *</label>
                <select wire:model="status" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="ACTIVE">{{ __('Active') }}</option>
                    <option value="INACTIVE">{{ __('Inactive') }}</option>
                </select>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-6">
            
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                {{ __('Create GP') }}
            </button>
            <a href="{{ route('gram-panchayats.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 font-medium">
                {{ __('Cancel') }}
            </a>
        </div>
    </form>
</div>
