<div>
    <div class="bg-black dark:bg-gray-950 text-white px-6 py-4 -mx-6 -mt-6 mb-6 flex justify-between items-center rounded-t-xl">
        <div>
            <h1 class="text-xl font-semibold">{{ __('Edit User') }}</h1>
            <p class="text-sm text-gray-400 mt-0.5">{{ __('Update user information and settings') }}</p>
        </div>
        <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center w-8 h-8 bg-gray-800 hover:bg-gray-700 rounded-full transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </a>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 px-4 py-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-400 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 pt-6 px-6 pb-6">
        <form wire:submit.prevent="update">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Name') }}
                    </label>
                    <input
                        wire:model="name"
                        type="text"
                        id="name"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        placeholder="0"
                    />
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Email') }}
                    </label>
                    <input
                        wire:model="email"
                        type="email"
                        id="email"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        placeholder="0"
                    />
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Mobile -->
                <div>
                    <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Mobile') }}
                    </label>
                    <input
                        wire:model="mobile"
                        type="text"
                        id="mobile"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        placeholder="0"
                    />
                    @error('mobile') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Role') }}
                    </label>
                    <input
                        wire:model="role"
                        type="text"
                        id="role"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        placeholder="0"
                    />
                    @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- States -->
                <div>
                    <label for="states" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('States') }}
                    </label>
                    <input
                        wire:model="states"
                        type="text"
                        id="states"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        placeholder="0"
                    />
                    @error('states') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Nodal -->
                <div>
                    <label for="nodal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Nodal') }}
                    </label>
                    <select
                        wire:model="nodal"
                        id="nodal"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 pr-8 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                    </select>
                    @error('nodal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Status') }}
                    </label>
                    <select
                        wire:model="status"
                        id="status"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 pr-8 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                        <option value="SUSPENDED">SUSPENDED</option>
                    </select>
                    @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Password') }}
                    </label>
                    <input
                        wire:model="password"
                        type="password"
                        id="password"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        placeholder="0"
                    />
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Confirm Password') }}
                    </label>
                    <input
                        wire:model="password_confirmation"
                        type="password"
                        id="password_confirmation"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        placeholder="0"
                    />
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a
                    href="{{ route('users.index') }}"
                    class="px-6 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 font-medium transition-colors text-sm"
                >
                    {{ __('Cancel') }}
                </a>
                <button
                    type="submit"
                    class="px-6 py-2 bg-black dark:bg-gray-900 text-white rounded-lg hover:bg-gray-800 dark:hover:bg-gray-800 font-medium transition-colors text-sm"
                >
                    {{ __('Yeah, Submit') }}
                </button>
            </div>
        </form>
    </div>
</div>
