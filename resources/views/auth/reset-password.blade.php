<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="w-full max-w-md mx-auto p-6 sm:p-8 bg-white rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">{{ __('Reset Your Password') }}</h2>

            <x-validation-errors class="mb-6 bg-red-100 text-red-700 p-4 rounded-lg" />

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <!-- Hidden inputs for token and email -->
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request()->email }}">

                <!-- Email Field -->
                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="email"
                             class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                             type="email"
                             name="email"
                             :value="old('email', request()->email)"
                             required
                             autofocus
                             autocomplete="username" />
                </div>

                <!-- Password Field -->
                <div>
                    <x-label for="password" value="{{ __('Password') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="password"
                             class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                             type="password"
                             name="password"
                             required
                             autocomplete="new-password" />
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="password_confirmation"
                             class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                             type="password"
                             name="password_confirmation"
                             required
                             autocomplete="new-password" />
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <x-button class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                        {{ __('Reset Password') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
