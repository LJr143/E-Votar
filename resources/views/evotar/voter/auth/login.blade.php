<x-guest-layout>
    <div>
        <div class="flex justify-between items-center p-3 bg-white sm:flex w-full h-[55px] bg-transparent">
            <div class="flex space-x-4">
                <img class="h-[28px] " src="{{ asset('storage/assets/logo/evotar_red.png') }}" alt="evotar_logo"/>
            </div>
            <div class="flex space-x-2 mr-8">
                <img alt="Logo 1" class=" h-[35px] mx-1 rounded-full"
                     src="{{ asset('storage/assets/logo/usep_logo.jpg') }}"/>
                <img alt="Logo 2" class=" h-[35px] mx-1 rounded-full"
                     src="{{ asset('storage/assets/logo/usg_logo.png') }}">
                <img alt="Logo 3" class=" h-[35px] mx-1 rounded-full"
                     src="{{ asset('storage/assets/logo/tsc_logo.png') }}"/>
                <img alt="Logo 4" class=" h-[35px] mx-1 rounded-full"
                     src="{{ asset('storage/assets/logo/tsc_comelec_logo.png') }}"/>

            </div>
        </div>

        <div class="w-full">
            <div class="w-full flex flex-col lg:flex-row h-full ">
                <div class="flex w-full lg:w-1/2 overflow-hidden">
                    <img alt="Background image " class="w-full h-auto lg:max-h-screen object-cover"
                         src="{{ asset('storage/assets/image/voter_login_bg.png') }}" width="710"/>
                </div>
                <div class="flex w-full lg:w-1/2 bg-white p-4 lg:p-1 text-black lg:px-20 lg:py-6 h-auto lg:max-h-screen">

                    <div class="flex w-full">
                        <div class="w-full">
                            <div class="text-left">
                                <p class="italic text-[14px]">USeP Comelec</p>
                            </div>
                            <h2 class="text-[22px] italic font-bold">E-Votar</h2>
                            <p class="text-[12px] mb-5 lg:mb-[60px]">Integrity, Impartiality, and Transparency</p>

                            <h2 class="text-[30px] font-bold mb-1">Welcome Back!</h2>
                            <p class="text-[12px] mb-5">The E-Votar system makes voting a less stressful and fast!</p>

                            <x-validation-errors class="mb-4 w-full lg:w-[60%]"/>


                            <form method="POST" class="space-y-2 ">
                                @csrf

                                <div class="flex flex-col mb-4">
                                    <label for="username" class="text-gray-600 text-[12px] mb-1">Username</label>
                                    <input type="text" id="username" name="username"
                                           class="w-full lg:w-[60%] px-4 py-5 text-[12px] border border-gray-300 rounded-md focus:ring-black focus:border-black h-8"
                                           placeholder="Enter your username" required>
                                </div>

                                <div class="flex flex-col">
                                    <label for="password" class="text-gray-600 text-[12px] mb-1">Password</label>
                                    <div class="relative w-full lg:w-[60%] mb-8">
                                    <input type="password" id="password" name="password"
                                           class="w-full px-4 py-5 text-[12px] border border-gray-300 rounded-md focus:ring-black focus:border-black h-8 pr-10"
                                           placeholder="Enter your password" required>
                                    <button type="button" id="togglePassword"
                                            class="absolute inset-y-0 right-0 flex items-center px-2 focus:outline-none">
                                        <svg width="31" height="20" viewBox="0 0 31 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g clip-path="url(#clip0_1607_9295)">
                                                <g clip-path="url(#clip1_1607_9295)">
                                                    <path d="M31 0H0V20H31V0Z" fill="url(#pattern0_1607_9295)"/>
                                                </g>
                                            </g>
                                            <defs>
                                                <pattern id="pattern0_1607_9295" patternContentUnits="objectBoundingBox"
                                                         width="1" height="1">
                                                    <use xlink:href="#image0_1607_9295"
                                                         transform="matrix(0.00645161 0 0 0.01 0.177419 0)"/>
                                                </pattern>
                                                <clipPath id="clip0_1607_9295">
                                                    <rect width="31" height="20" fill="white"/>
                                                </clipPath>
                                                <clipPath id="clip1_1607_9295">
                                                    <rect width="31" height="20" fill="white"/>
                                                </clipPath>
                                                <image id="image0_1607_9295" width="100" height="100"
                                                       xlink:href="data:image/png;base64,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"/>
                                            </defs>
                                        </svg>
                                    </button>
                                    </div>
                                </div>





                                <div class="flex flex-col space-y-3">
                                    <button type="submit"
                                            class="w-full lg:w-[60%] rounded text-[14px] bg-black font-semibold text-white py-3 hover:bg-gray-800 transition">
                                        Login
                                    </button>

                                    <button type="button" onclick="window.location.href='{{ route('login.google') }}'"
                                            class="w-full lg:w-[60%] text-[14px] flex items-center font-semibold justify-center border border-gray-300 py-3 rounded hover:bg-gray-100 transition">
                                        <img src="{{ asset('storage/assets/icon/google.png') }}" alt="Google Logo"
                                             class="w-5 h-5 mr-2">
                                        Login with Google
                                    </button>

                                    <!-- Forget Password Link -->
                                    <p class="text-[12px] text-left">
                                        Forget Password? <a href="/forgot-password"
                                                            class="underline font-bold text-black">Click here</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>





    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            // Toggle password visibility
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            // Toggle eye icon
            eyeIcon.innerHTML = isPassword
                ? `
            <!-- Eye Icon (Visible) -->
           <svg width="31" height="20" viewBox="0 0 31 20" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g clip-path="url(#clip0_1607_9292)">
                                    <path d="M31 0H0V20H31V0Z" fill="url(#pattern0_1607_9292)"/>
                                    </g>
                                    <defs>
                                    <pattern id="pattern0_1607_9292" patternContentUnits="objectBoundingBox" width="1" height="1">
                                    <use xlink:href="#image0_1607_9292" transform="matrix(0.00645161 0 0 0.01 0.177419 0)"/>
                                    </pattern>
                                    <clipPath id="clip0_1607_9292">
                                    <rect width="31" height="20" fill="white"/>
                                    </clipPath>
                                    <image id="image0_1607_9292" width="100" height="100" xlink:href="data:image/png;base64,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"/>
                                    </defs>
                                    </svg>
            `
                : `
            <!-- Hidden Eye with Slash -->
           <svg width="31" height="20" viewBox="0 0 31 20" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g clip-path="url(#clip0_1607_9295)">
                                    <g clip-path="url(#clip1_1607_9295)">
                                    <path d="M31 0H0V20H31V0Z" fill="url(#pattern0_1607_9295)"/>
                                    </g>
                                    </g>
                                    <defs>
                                    <pattern id="pattern0_1607_9295" patternContentUnits="objectBoundingBox" width="1" height="1">
                                    <use xlink:href="#image0_1607_9295" transform="matrix(0.00645161 0 0 0.01 0.177419 0)"/>
                                    </pattern>
                                    <clipPath id="clip0_1607_9295">
                                    <rect width="31" height="20" fill="white"/>
                                    </clipPath>
                                    <clipPath id="clip1_1607_9295">
                                    <rect width="31" height="20" fill="white"/>
                                    </clipPath>
                                    <image id="image0_1607_9295" width="100" height="100" xlink:href="data:image/png;base64,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"/>
                                    </defs>
                                    </svg>
            `;
        });

        document.addEventListener('keydown', function (event) {
            if (event.ctrlKey && event.shiftKey && event.key.toLowerCase() === 'u') {
                window.location.href = '{{ route("admin.login") }}';
            }
        });
    </script>

</x-guest-layout>


