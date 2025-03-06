<x-custom-layout>

    <x-slot name="main">

        <style>
            .diagonal-cut {
                clip-path: polygon(0 0, 100% 0, 80% 100%, 0% 100%);
            }
            .diagonal-cover {
                clip-path: polygon(0 0, 100% 0, 80% 100%, 0% 100%);
            }
            @media (max-width: 768px) {
                .diagonal-cut, .diagonal-cover {
                    clip-path: none;
                    height: 200px;
                }
            }
            body {
                font-family: 'Poppins', sans-serif;
            }
        </style>

        <div class="bg-cover bg-center bg-no-repeat flex items-center justify-center min-h-screen relative" style="background-image: url('{{ asset('storage/assets/image/bg-image-voted.png') }}');">
            <div class="absolute inset-0 bg-white opacity-50"></div>
            <div class="bg-white bg-opacity-80 shadow-lg rounded-lg overflow-hidden max-w-5xl w-full relative z-10">
                <form>
                    <div class="flex flex-col md:flex-row min-w-5xl max-w-5xl">
                        <div class="md:w-1/2 relative bg-white">
                            <img alt="" class="w-full h-full object-cover diagonal-cut" src="{{ asset('storage/assets/image/bg-image-voted.png') }}"/>
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 diagonal-cover">
                                <img alt="Comelec logo" class="w-16 h-16 mb-3" src="{{ asset('storage/assets/logo/tsc_comelec_logo.png') }}"/>
                                <p class="text-white text-center text-[12px]">University of Southeastern Philippines</p>
                                <span class="text-white font-bold text-[20px] text-center">
                                    COMMISSION ON ELECTIONS
                                </span>
                                <p class="text-white text-center text-[12px]">Impartiality, Transparency, Integrity</p>
                            </div>
                        </div>
                        <div class="md:w-1/2 p-8 bg-white">
                            <h1 class="text-3xl font-bold text-black mb-4 text-center" style="font-size: 20px;">
                                LOGIN
                            </h1>
                            <p class="text-gray-700 mb-4 text-center" style="font-size: 12px;">
                                Please login to submit your feedback.
                            </p>
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-gray-700" for="student-id" style="font-size: 12px;">
                                        Username
                                    </label>
                                    <input class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black" id="student-id" placeholder="Username" type="text" style="font-size: 11px;"/>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700" for="password" style="font-size: 12px;">
                                        Password
                                    </label>
                                    <input class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black" id="password" placeholder="Password" type="password" style="font-size: 11px;"/>
                                </div>
                                <div class="mb-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input class="mr-2" id="remember-me" type="checkbox"/>
                                        <label class="text-gray-700" for="remember-me" style="font-size: 12px;">
                                            Remember Me
                                        </label>
                                    </div>
                                    <a class="text-black text-sm" href="#" style="font-size: 11px;">
                                        Forgot Password ?
                                    </a>
                                </div>
                                <button class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 mt-4" type="submit" style="font-size: 12px;">
                                    Login
                                </button>
                            </form>
                            <p class="text-gray-600 text-xs mt-4" style="font-size: 11px;">
                                By using this service, you understand and agree to the Terms of Use and Privacy Statement.
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="absolute bottom-4 left-4 z-10">
                <a class="text-black text-sm" href="{{ route('comelec-website.home') }}" style="font-size: 11px;">
                    ← Back to Homepage
                </a>
            </div>
        </div>
    </x-slot>
</x-custom-layout>

