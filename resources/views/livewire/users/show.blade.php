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
        <div class="flex items-center gap-6 mb-8">
            <span class="inline-block bg-gray-300 rounded-full w-20 h-20 text-center leading-20 font-bold text-gray-700 text-3xl">
                {{ strtoupper(Str::substr($user->name, 0, 1)) }}
            </span>
            <div>
                <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold mb-4">{{ __('Personal Information') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                        <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('Mobile') }}</label>
                        <p class="mt-1 text-gray-900">{{ $user->mobile ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">{{ __('Assignment Details') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('Role') }}</label>
                        <p class="mt-1 text-gray-900">{{ $user->role ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('States') }}</label>
                        <p class="mt-1 text-gray-900">{{ $user->states ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('Nodal') }}</label>
                        <p class="mt-1">
                            @if ($user->nodal === 'YES')
                                <span class="inline-block px-3 py-1 text-sm bg-green-100 text-green-800 rounded font-semibold">YES</span>
                            @else
                                <span class="inline-block px-3 py-1 text-sm bg-gray-100 text-gray-800 rounded">NO</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">{{ __('Status & Verification') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                        <p class="mt-1">
                            @if ($user->status === 'ACTIVE')
                                <span class="inline-block px-3 py-1 text-sm bg-green-100 text-green-800 rounded font-semibold">ACTIVE</span>
                            @elseif ($user->status === 'INACTIVE')
                                <span class="inline-block px-3 py-1 text-sm bg-gray-100 text-gray-800 rounded">INACTIVE</span>
                            @else
                                <span class="inline-block px-3 py-1 text-sm bg-red-100 text-red-800 rounded">SUSPENDED</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('Email Verified') }}</label>
                        <p class="mt-1">
                            @if ($user->email_verified_at)
                                <span class="inline-block px-3 py-1 text-sm bg-green-100 text-green-800 rounded">{{ __('Yes') }} - {{ $user->email_verified_at->format('M d, Y H:i') }}</span>
                            @else
                                <span class="inline-block px-3 py-1 text-sm bg-gray-100 text-gray-800 rounded">{{ __('No') }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">{{ __('Timeline') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('Created On') }}</label>
                        <p class="mt-1 text-gray-900">{{ $user->created_at->format('M d, Y H:i:s') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('Updated On') }}</label>
                        <p class="mt-1 text-gray-900">{{ $user->updated_at->format('M d, Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
