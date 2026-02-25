<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Create Gram Panchayat</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Add a new gram panchayat to the system</p>
        </div>
        <a href="{{ route('gram-panchayats.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-zinc-200 dark:hover:bg-zinc-600 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-800 shadow-sm rounded-lg border border-zinc-200 dark:border-zinc-700">
        <form wire:submit="save" class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="state_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">State *</label>
                    <input wire:model="state_name" type="text" id="state_name" list="statesList" class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <datalist id="statesList">
                        @foreach($states as $state)
                            <option value="{{ $state }}">
                        @endforeach
                    </datalist>
                    @error('state_name') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="business_area" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Business Area *</label>
                    <input wire:model="business_area" type="text" id="business_area" list="businessAreasList" class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <datalist id="businessAreasList">
                        @foreach($businessAreas as $ba)
                            <option value="{{ $ba }}">
                        @endforeach
                    </datalist>
                    @error('business_area') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="district_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">District *</label>
                    <input wire:model="district_name" type="text" id="district_name" list="districtsList" class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <datalist id="districtsList">
                        @foreach($districts as $district)
                            <option value="{{ $district }}">
                        @endforeach
                    </datalist>
                    @error('district_name') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="block_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Block *</label>
                    <input wire:model="block_name" type="text" id="block_name" list="blocksList" class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <datalist id="blocksList">
                        @foreach($blocks as $block)
                            <option value="{{ $block }}">
                        @endforeach
                    </datalist>
                    @error('block_name') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="gp_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">GP Name *</label>
                    <input wire:model="gp_name" type="text" id="gp_name" class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('gp_name') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="gp_code" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">GP Code *</label>
                    <input wire:model="gp_code" type="text" id="gp_code" class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('gp_code') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="gp_type" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">GP Type</label>
                    <input wire:model="gp_type" type="text" id="gp_type" list="gpTypesList" class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <datalist id="gpTypesList">
                        @foreach($gpTypes as $type)
                            <option value="{{ $type }}">
                        @endforeach
                    </datalist>
                    @error('gp_type') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Status *</label>
                    <select wire:model="status" id="status" class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="ACTIVE">Active</option>
                        <option value="INACTIVE">Inactive</option>
                    </select>
                    @error('status') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <a href="{{ route('gram-panchayats.index') }}" class="px-4 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-zinc-800 dark:bg-zinc-700 text-white rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-600 transition">
                    Create Gram Panchayat
                </button>
            </div>
        </form>
    </div>
</div>
