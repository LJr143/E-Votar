<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center">
                <img  class="w-20 h-20 sm:w-24 sm:h-24" src="{{ asset('storage/assets/logo/tsc_comelec_logo.png') }}" alt="evotar_logo">
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6 mt-6">
                @csrf

                <!-- Token from URL parameter -->
                <input type="hidden" name="token" value="{{ $token }}">
                <!-- Get email from URL query string -->
                <input type="hidden" name="email" value="{{ request()->email }}">

                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="email"
                             class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                             type="email"
                             name="email"
                             :value="old('email', request()->email)"
                             required
                             readonly
                             autocomplete="email" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('Password') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="password"
                             class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                             type="password"
                             name="password"
                             required
                             autocomplete="new-password" />
                </div>

                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="password_confirmation"
                             class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                             type="password"
                             name="password_confirmation"
                             required
                             autocomplete="new-password" />
                </div>

                <div>
                    <x-button class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        {{ __('Reset Password') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
