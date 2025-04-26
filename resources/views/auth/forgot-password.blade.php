<x-guest-layout>
    <div class="bg-white flex items-center justify-center min-h-screen">
        <div class=" p-8 w-full max-w-lg mx-4 sm:mx-8 md:mx-16 lg:mx-32 xl:mx-64 ">

            <x-slot name="logo">
                <x-authentication-card-logo />
            </x-slot>

            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-4">Did you forgot your password?</h2>
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
            @endsession

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="block mb-6">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div class="flex items-center justify-center mt-6">
                    <x-button class="w-full bg-black text-white text-center py-2 justify-center rounded-lg hover:bg-gray-800 transition duration-200">
                        {{ __('Request Reset Link') }}
                    </x-button>
                </div>
            </form>

            <div class="text-center mt-2">
                <a href="{{ route('admin.login') }}" class="text-gray-600 text-[12px]">Back to Login</a>
            </div>
        </div>
    </div>

</x-guest-layout>
