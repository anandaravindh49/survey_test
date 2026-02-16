<div>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ __('Business Areas') }}</h1>
        <a href="{{ route('business-areas.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            {{ __('Add Business Area') }}
        </a>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 px-4 py-2 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6 flex gap-4">
        <input
            wire:model.debounce.300ms="search"
            type="search"
            placeholder="{{ __('Search business areas...') }}"
            class="flex-1 border rounded px-3 py-2"
        />
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
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
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('business_name')">
                        {{ __('Business Name') }}
                        @if ($sortField === 'business_name')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('code')">
                        {{ __('Code') }}
                        @if ($sortField === 'code')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($businessAreas as $area)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm">{{ $area->package_name }}</td>
                        <td class="px-4 py-2 text-sm">{{ $area->state_name }}</td>
                        <td class="px-4 py-2 text-sm">{{ $area->business_name }}</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">{{ $area->code }}</span>
                        </td>
                        <td class="px-4 py-2 text-sm">
                            @if($area->status === 'ACTIVE')
                                <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded font-semibold">ACTIVE</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">INACTIVE</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('business-areas.show', $area) }}" class="text-blue-600 hover:text-blue-700 font-medium">View</a>
                                <a href="{{ route('business-areas.edit', $area) }}" class="text-yellow-600 hover:text-yellow-700 font-medium">Edit</a>
                                <button wire:click="delete({{ $area->id }})" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-700 font-medium">Delete</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-500">
                            {{ __('No business areas found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($businessAreas->hasPages())
        <div class="mt-6">
            {{ $businessAreas->links() }}
        </div>
    @endif
</div>
