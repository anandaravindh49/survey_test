<div>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ __('Users') }}</h1>
        <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-800 dark:bg-zinc-700 text-white rounded hover:bg-zinc-900 dark:hover:bg-zinc-600 font-medium">
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

    <!-- Filter Section -->
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
            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Filter by:') }}</span>
        </div>
        
        <div class="flex gap-3 flex-wrap items-center">
            <input
                wire:model.live="search"
                type="search"
                placeholder="{{ __('search user...') }}"
                class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
            />
            
            <select
                wire:model.live="filterStatus"
                class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
            >
                <option value="">{{ __('All Status') }}</option>
                <option value="ACTIVE">{{ __('Active') }}</option>
                <option value="INACTIVE">{{ __('Inactive') }}</option>
                <option value="SUSPENDED">{{ __('Suspended') }}</option>
            </select>
            
            <select
                wire:model.live="filterRole"
                class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
            >
                <option value="">{{ __('All Roles') }}</option>
                <option value="ADMIN">{{ __('Admin') }}</option>
                <option value="USER">{{ __('User') }}</option>
                <option value="NODAL">{{ __('Nodal Officer') }}</option>
            </select>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
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
                    <th class="px-4 py-2 text-left">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-4 py-2 text-gray-900 dark:text-white">
                            <div class="flex items-center gap-3">
                                <span class="inline-block bg-gray-300 dark:bg-gray-600 rounded-full w-8 h-8 text-center leading-8 font-bold text-gray-700 dark:text-white">
                                    {{ strtoupper(Str::substr($user->name, 0, 1)) }}
                                </span>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $user->mobile }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $user->role }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if ($user->nodal === 'YES')
                                <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded">YES</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">NO</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $user->states }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if ($user->status === 'ACTIVE')
                                <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded font-semibold">ACTIVE</span>
                            @elseif ($user->status === 'INACTIVE')
                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">INACTIVE</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-800 rounded">SUSPENDED</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $user->updated_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('users.show', $user->id) }}" class="inline-flex items-center px-2.5 py-1.5 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-all duration-200" title="View User">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center px-2.5 py-1.5 text-zinc-600 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white transition-all duration-200" title="Edit User">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                </a>
                                <button wire:click="delete({{ $user->id }})" wire:confirm="Are you sure you want to delete this user? This action cannot be undone." class="inline-flex items-center px-2.5 py-1.5 text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 transition-all duration-200" title="Delete User">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-8 text-gray-500 dark:text-gray-400">
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
