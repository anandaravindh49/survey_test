<div>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ __('Users') }}</h1>
        <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            {{ __('Add User') }}
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
            placeholder="{{ __('Search users...') }}"
            class="flex-1 border rounded px-3 py-2"
        />
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('name')">
                        {{ __('Name') }}
                        @if ($sortBy === 'name')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('email')">
                        {{ __('Email') }}
                        @if ($sortBy === 'email')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('mobile')">
                        {{ __('Mobile') }}
                        @if ($sortBy === 'mobile')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('role')">
                        {{ __('Role') }}
                        @if ($sortBy === 'role')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left">{{ __('Nodal') }}</th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('states')">
                        {{ __('States') }}
                        @if ($sortBy === 'states')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('status')">
                        {{ __('Status') }}
                        @if ($sortBy === 'status')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('created_at')">
                        {{ __('Created On') }}
                        @if ($sortBy === 'created_at')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer" wire:click="sort('updated_at')">
                        {{ __('Updated On') }}
                        @if ($sortBy === 'updated_at')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-2 text-right">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">
                            <div class="flex items-center gap-3">
                                <span class="inline-block bg-gray-300 rounded-full w-8 h-8 text-center leading-8 font-bold text-gray-700">
                                    {{ strtoupper(Str::substr($user->name, 0, 1)) }}
                                </span>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-2 text-sm">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-sm">{{ $user->mobile }}</td>
                        <td class="px-4 py-2 text-sm">{{ $user->role }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if ($user->nodal === 'YES')
                                <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded">YES</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">NO</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">{{ $user->states }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if ($user->status === 'ACTIVE')
                                <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded font-semibold">ACTIVE</span>
                            @elseif ($user->status === 'INACTIVE')
                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">INACTIVE</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-800 rounded">SUSPENDED</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2 text-sm">{{ $user->updated_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('users.show', $user->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-md hover:from-blue-600 hover:to-blue-700 text-xs font-semibold shadow-sm hover:shadow-md transition-all duration-200" title="View User">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    View
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-md hover:from-amber-600 hover:to-amber-700 text-xs font-semibold shadow-sm hover:shadow-md transition-all duration-200" title="Edit User">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <button wire:click="delete({{ $user->id }})" wire:confirm="Are you sure you want to delete this user? This action cannot be undone." class="inline-flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-md hover:from-red-600 hover:to-red-700 text-xs font-semibold shadow-sm hover:shadow-md transition-all duration-200" title="Delete User">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-8 text-gray-500">
                            {{ __('No users found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6 px-4 py-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
