<div>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ __('Districts') }}</h1>
        <a href="{{ route('districts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-800 dark:bg-zinc-700 text-white rounded hover:bg-zinc-900 dark:hover:bg-zinc-600 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            {{ __('Add District') }}
        </a>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 px-4 py-2 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Total Package') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalPackages }}</p>
            </div>
            <svg class="w-12 h-12 text-blue-200 dark:text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10m-4-4l4 2m-8-2l4-2"></path>
            </svg>
        </div>
        
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Total States') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalStates }}</p>
            </div>
            <svg class="w-12 h-12 text-emerald-200 dark:text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
        
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Total Business area') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalBusinessAreas }}</p>
            </div>
            <svg class="w-12 h-12 text-purple-200 dark:text-purple-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>
        
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Total Districts') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalDistricts }}</p>
            </div>
            <svg class="w-12 h-12 text-amber-200 dark:text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>
    </div>
    <div class="mb-6 bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex gap-2 items-center mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
            <button
                wire:click="resetFilters"
                class="inline-flex items-center gap-2 px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                {{ __('Reset') }}
            </button>
            {{-- <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Filter by:') }}</span> --}}
        </div>
        
        <div class="flex gap-3 flex-wrap items-center">
            <input
                wire:model.live="search"
                type="search"
                placeholder="{{ __('search district...') }}"
                class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
            />
            
            <select
                wire:model.live="filterPackage"
                class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
            >
                <option value="">{{ __('All Packages') }}</option>
                @foreach($packages as $package)
                    <option value="{{ $package }}">{{ $package }}</option>
                @endforeach
            </select>
            
            <select
                wire:model.live="filterState"
                class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
            >
                <option value="">{{ __('All States') }}</option>
                @foreach($states as $state)
                    <option value="{{ $state }}">{{ $state }}</option>
                @endforeach
            </select>
            
            <select
                wire:model.live="filterStatus"
                class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
            >
                <option value="">{{ __('All Status') }}</option>
                <option value="ACTIVE">{{ __('Active') }}</option>
                <option value="INACTIVE">{{ __('Inactive') }}</option>
            </select>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('package_name')">
                        {{ __('Package') }}
                        @if ($sortField === 'package_name')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('state_name')">
                        {{ __('State') }}
                        @if ($sortField === 'state_name')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('district_name')">
                        {{ __('District') }}
                        @if ($sortField === 'district_name')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('code')">
                        {{ __('Code') }}
                        @if ($sortField === 'code')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('status')">
                        {{ __('Status') }}
                        @if ($sortField === 'status')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($districts as $district)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-4 py-2 text-sm">{{ $district->package_name }}</td>
                        <td class="px-4 py-2 text-sm">{{ $district->state_name }}</td>
                        <td class="px-4 py-2 text-sm">{{ $district->district_name }}</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">{{ $district->code }}</span>
                        </td>
                        <td class="px-4 py-2 text-sm">
                            @if($district->status === 'ACTIVE')
                                <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded font-semibold">ACTIVE</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-800 rounded">INACTIVE</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('districts.show', $district) }}" class="inline-flex items-center px-2.5 py-1.5 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-all duration-200" title="View District">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('districts.edit', $district) }}" class="inline-flex items-center px-2.5 py-1.5 text-zinc-600 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white transition-all duration-200" title="Edit District">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                </a>
                                <button wire:click="delete({{ $district->id }})" wire:confirm="Are you sure you want to delete this district? This action cannot be undone." class="inline-flex items-center px-2.5 py-1.5 text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 transition-all duration-200" title="Delete District">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-500">
                            {{ __('No districts found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6 px-4 py-4">
            {{ $districts->links() }}
        </div>
    </div>
</div>
