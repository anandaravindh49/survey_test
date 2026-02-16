<div class="p-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ __('Users') }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('Manage all users in the system') }}</p>
        </div>
        <a href="{{ route('users.create') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            {{ __('Add User') }}
        </a>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 px-4 py-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search Section -->
    <div class="mb-6">
        <input
            wire:model.live="search"
            type="search"
            placeholder="{{ __('Search users by name, email, mobile, or role...') }}"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        />
    </div>

    <!-- Table -->
    <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-100 to-gray-50 dark:from-slate-800 dark:to-slate-700 border-b border-gray-200 dark:border-slate-600">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <button wire:click="sort('name')" class="flex items-center gap-2 text-sm font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                {{ __('Name') }}
                                @if ($sortBy === 'name')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path @if($sortDirection === 'asc') d="M3 9a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" @else d="M15.3 5.3a1 1 0 10-1.4-1.4l-4.9 4.9-4.9-4.9a1 1 0 00-1.4 1.4l4.9 4.9-4.9 4.9a1 1 0 101.4 1.4l4.9-4.9 4.9 4.9a1 1 0 001.4-1.4L9.7 10l4.9-4.9a1 1 0 00-.3-1.4z" @endif />
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <button wire:click="sort('email')" class="flex items-center gap-2 text-sm font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                {{ __('Email') }}
                                @if ($sortBy === 'email')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path @if($sortDirection === 'asc') d="M3 9a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" @else d="M15.3 5.3a1 1 0 10-1.4-1.4l-4.9 4.9-4.9-4.9a1 1 0 00-1.4 1.4l4.9 4.9-4.9 4.9a1 1 0 101.4 1.4l4.9-4.9 4.9 4.9a1 1 0 001.4-1.4L9.7 10l4.9-4.9a1 1 0 00-.3-1.4z" @endif />
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <button wire:click="sort('mobile')" class="flex items-center gap-2 text-sm font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                {{ __('Mobile') }}
                                @if ($sortBy === 'mobile')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path @if($sortDirection === 'asc') d="M3 9a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" @else d="M15.3 5.3a1 1 0 10-1.4-1.4l-4.9 4.9-4.9-4.9a1 1 0 00-1.4 1.4l4.9 4.9-4.9 4.9a1 1 0 101.4 1.4l4.9-4.9 4.9 4.9a1 1 0 001.4-1.4L9.7 10l4.9-4.9a1 1 0 00-.3-1.4z" @endif />
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <button wire:click="sort('role')" class="flex items-center gap-2 text-sm font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                {{ __('Role') }}
                                @if ($sortBy === 'role')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path @if($sortDirection === 'asc') d="M3 9a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" @else d="M15.3 5.3a1 1 0 10-1.4-1.4l-4.9 4.9-4.9-4.9a1 1 0 00-1.4 1.4l4.9 4.9-4.9 4.9a1 1 0 101.4 1.4l4.9-4.9 4.9 4.9a1 1 0 001.4-1.4L9.7 10l4.9-4.9a1 1 0 00-.3-1.4z" @endif />
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('Status') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('Created') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 text-white font-semibold rounded-full text-xs">
                                        {{ strtoupper(Str::substr($user->name, 0, 1)) }}
                                    </span>
                                    <span class="font-medium">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->mobile }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $user->role }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->status === 'ACTIVE' ? 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300' : ($user->status === 'INACTIVE' ? 'bg-amber-100 dark:bg-amber-900/20 text-amber-800 dark:text-amber-300' : 'bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-300') }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('users.show', $user->id) }}" wire:navigate class="inline-flex items-center px-3 py-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" wire:navigate class="inline-flex items-center px-3 py-2 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-colors duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button wire:click="delete({{ $user->id }})" onclick="return confirm('Are you sure?')" class="inline-flex items-center px-3 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="inline-flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 7a4 4 0 11-8 0 4 4 0 018 0zM6 17c-1.657 0-3-1.343-3-3v-2a6 6 0 0112 0v2c0 1.657-1.343 3-3 3H6z"></path>
                                    </svg>
                                    <p class="text-gray-600 dark:text-gray-400 font-medium">{{ __('No users found') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</div>
