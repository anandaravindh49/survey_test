<div>
    <div class="mb-6">
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            {{ __('Back to Users') }}
        </a>
    </div>

    <div class="bg-white rounded shadow p-6">
        <h1 class="text-3xl font-bold mb-6">{{ __('Create New User') }}</h1>

        @if (session()->has('message'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Name') }} <span class="text-red-500">*</span>
                    </label>
                    <input
                        wire:model="name"
                        type="text"
                        id="name"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                        placeholder="Enter full name"
                    />
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Email') }} <span class="text-red-500">*</span>
                    </label>
                    <input
                        wire:model="email"
                        type="email"
                        id="email"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                        placeholder="Enter email address"
                    />
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Mobile -->
                <div>
                    <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Mobile') }}
                    </label>
                    <input
                        wire:model="mobile"
                        type="text"
                        id="mobile"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                        placeholder="Enter mobile number"
                    />
                    @error('mobile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Role') }}
                    </label>
                    <input
                        wire:model="role"
                        type="text"
                        id="role"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                        placeholder="e.g., Field Surveyor"
                    />
                    @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- States -->
                <div>
                    <label for="states" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('States') }}
                    </label>
                    <input
                        wire:model="states"
                        type="text"
                        id="states"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                        placeholder="e.g., Jammu & Kashmir"
                    />
                    @error('states') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Nodal -->
                <div>
                    <label for="nodal" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Nodal') }} <span class="text-red-500">*</span>
                    </label>
                    <select
                        wire:model="nodal"
                        id="nodal"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    >
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                    </select>
                    @error('nodal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Status') }} <span class="text-red-500">*</span>
                    </label>
                    <select
                        wire:model="status"
                        id="status"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    >
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                        <option value="SUSPENDED">SUSPENDED</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Password') }} <span class="text-red-500">*</span>
                    </label>
                    <input
                        wire:model="password"
                        type="password"
                        id="password"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                        placeholder="Enter password (min 8 characters)"
                    />
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Confirm Password') }} <span class="text-red-500">*</span>
                    </label>
                    <input
                        wire:model="password_confirmation"
                        type="password"
                        id="password_confirmation"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                        placeholder="Confirm password"
                    />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium"
                >
                    {{ __('Create User') }}
                </button>
                <a
                    href="{{ route('users.index') }}"
                    class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 font-medium"
                >
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
