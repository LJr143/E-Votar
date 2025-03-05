<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader /> <!-- Use the header component -->
    </x-slot>

    <x-slot name="main">
        <main>
            <div class="mx-auto md:py-20 px-4 md:px-12">
                <!-- Main Content -->
                <div class="sm:flex  ">
                    <!-- Left Side - Register Form -->
                    <div class="flex flex-col w-full md:w-1/2 items-center justify-start ">
                        <div class="w-full p-6 2xl:px-20 ">
                            <!-- Voting Steps -->
                            <div class="flex flex-col items-start w-full">
                                <p class="font-bold text-sm text-left">VOTING MADE EASY!</p>
                                <p class="text-xs text-left mt-2">Follow these easy steps to vote!</p>

                                <ol class="list-decimal ml-4 text-[12px] mt-4 space-y-2 text-left">
                                    <li>After logging in, you will be directed to the Tagum Student Council Election Page for the phase 1 of voting.</li>
                                    <li>You can either select a candidate to vote or abstain from a certain position.</li>
                                    <li>You can vote 1 for each student council position. Remember! You can either select or choose to abstain.</li>
                                    <li>Click on the <b>see more</b> to see the candidate's details including their college, program, year level, and motto.</li>
                                    <li>To select, just pick your candidate and make it the first to show!</li>
                                    <li>After carefully selecting, click the submit button to see a summary of your vote.</li>
                                    <li>If all your votes are correct, you can now click confirm and you will be directed to phase 2 of the voting process.</li>
                                    <li>Otherwise, you can always go back and correct your vote, just click the back button.</li>
                                </ol>
                            </div>
                        </div>
                    </div>


                    <!-- Right Side - SVG Content -->
                    <div class="relative flex flex-wrap sm:flex sm:w-1/2 h-auto justify-center bg-no-repeat bg-center bg-contain">

                        <!-- Background Image (Hidden on Mobile) -->
                        <div class="absolute inset-0 hidden sm:block h-auto justify-center bg-no-repeat bg-center bg-contain"
                             style="background-image: url('{{ asset('storage/evotarAssets/img_2.png') }}');">
                        </div>



                        <!-- Card moved to the left -->
                        <div class="bg-white border border-gray-400 p-4 rounded-lg shadow-lg text-center relative w-[250px] h-[280px] md:mt-10 ml-17 mb-5 sm:mb-0">
                            <p class="text-black text-[12px] font-semibold">PRESIDENT</p>
                            <div class="mt-8 flex items-center space-x-2">
                                <!-- Left Arrow -->
                                <button class="p-1 rounded-full">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>

                                <!-- Profile Image -->
                                <div class="relative">
                                    <img alt="Portrait of Juan Dela Cruz"
                                         class="w-20 h-20 ml-7 relative z-10"
                                         src="{{ asset('storage/evotarAssets/img_1.png') }}"
                                         width="100" height="100"/>

                                    <img alt="University Seal"
                                         class="w-10 h-10 absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 z-0"
                                         src="{{ asset('storage/evotarAssets/seal.png') }}"
                                         width="60" height="60"/>
                                </div>

                                <!-- Right Arrow -->
                                <button class="p-1 rounded-full">
                                    <svg class="w-5 h-5 text-gray-700 ml-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="mt-2">
                                <h2 class="text-[11px] font-semibold">JUAN DELA CRUZ</h2>
                                <p class="text-black text-[10px] font-regular">BS in Information Technology</p>
                                <p class="text-black text-[10px] font-regular">Major in Information Security</p>
                            </div>
                            <div class="mt-1">
                                <p class="font-semibold italic text-[10px]">Yanong Agila</p>
                            </div>
                            <div class="mt-7 ml-20">
                                <p class="font-semibold text-red-800 underline italic text-[10px]">see more</p>
                            </div>
                        </div>

                        <div class="bg-white border border-black p-6 rounded-lg shadow-lg text-left relative w-[250px] h-[280px] mb-10 sm:ml-10">
                            <div class="mb-4 flex">
                                <p class="font-semibold text-[10px] mr-2">Name:</p>
                                <p class="text-[10px] font-semibold text-gray-700 ml-7">Juan Dela Cruz</p>
                            </div>

                            <div class="mb-4 flex">
                                <p class="font-semibold text-[10px] mr-2">College:</p>
                                <p class="text-[10px] font-regular text-gray-500 ml-5">College of Teacher Education and Technology</p>
                            </div>

                            <div class="mb-4 flex">
                                <p class="font-semibold text-[10px] mr-2">Program:</p>
                                <p class="text-[10px] font-regular text-gray-500 ml-3">Bachelor of Science in Information Technology</p>
                            </div>

                            <div class="mb-4 flex">
                                <p class="font-semibold text-[10px] mr-2">Major:</p>
                                <p class="text-[10px] font-regular text-gray-500 ml-7">Information Security</p>
                            </div>

                            <div class="mb-4 flex">
                                <p class="font-semibold text-[10px] mr-2">Year Level:</p>
                                <p class="text-[10px] font-regular text-gray-500 ml-1">4</p>
                            </div>

                            <div class="mb-4 flex">
                                <p class="font-semibold text-[10px] mr-2">Motto:</p>
                                <p class="text-[10px] font-regular text-gray-500 ml-7">lorem ipsum dolor ipsum dolor ipsum dolor ipsum</p>
                            </div>
                        </div>

                        <!-- Added SVGs below the two cards -->
                        <div class="absolute  bottom-[-50px] xl:bottom-[-90px] 2xl:bottom-[-80px] w-full sm:flex justify-center space-x-4 mt-4 hidden ">
                            <!-- First SVG -->
                            <svg width="200" height="201" viewBox="0 0 517 518" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect x="267.172" y="517.844" width="356.155" height="376.366" transform="rotate(-138.604 267.172 517.844)" fill="url(#pattern0_1375_11718)"/>
                                <defs>
                                    <pattern id="pattern0_1375_11718" patternContentUnits="objectBoundingBox" width="1" height="1">
                                        <use xlink:href="#image0_1375_11718" transform="matrix(0.00206396 0 0 0.00195312 -0.0283737 0)"/>
                                    </pattern>
                                    <image id="image0_1375_11718" width="512" height="512" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAYAAAD0eNT6AAAAAXNSR0IArs4c6QAAIABJREFUeAHt3Qm0LVV5J/A/s4Ko2AgCDi2KBqMozmOMSloNmjgR08bGOKHRqEvbBI3pVtMqBINT2iguEw0dNUorDnEKg8nSOIa2DRoTh0WLI4IICijTs8+Wcxf3Xd99795zathV9TtrvXXvu/ecqtq/r+p+367atSvxIkCAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAwHICOye5UZKDk9wlyRFJHpPkKUn+IMnLk5yY5KQk/yvJu5J8NMmZSf559t4vJvn6/N95SS5c8++nSX42/3dFku8n+WySNyX57dmy915u832aAAECBAgQWBG4bpJbJ7lPkkfMku4zZr94SZLXJzl1luQ/keSrSS5elZxXknTXXy9N8uYkh6xsvK8ECBAgQIDALwrsMkuYN50n99KDLr301yV5X5Kz5j3srpN4E+srZwdOSHKdX2yynxAgQIAAgWkI7Do/JV9Oxx8zS4rHz0+9l1PupcfcRMKtdRmfml1uOGAaYdZKAgQIEJiqwF7z6+5Hz5P8B+an5ktvuNYE3cV2fTPJYVPdKbSbAAECBMYjsFuSOyVZnejLwLktE0/02ysmShFwk/Hs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"/>
                                </defs>
                            </svg>

                        </div>
                    </div>
                </div>
            </div>

            <div class="flex min-h-screen">
                <!-- Left Side - Register Form -->
                <div class="relative hidden md:flex w-1/2 h-screen items-center justify-start ml-10 "
                     style="background-image: url('{{ asset('storage/evotarAssets/img_3.png') }}'); background-repeat: no-repeat; background-position: center; background-size: 600px;">
                    <!-- Card  left -->
                    <div class="bg-blue-600 border  p-4 rounded-lg shadow-lg text-center relative w-[200px] h-[60px] mb-20 ml-17 ">
                        <p class="text-white text-lg font-semibold">Submit Vote</p>
                    </div>
                    <svg class="mt-20 absolute top-30 right-150" width="150" height="150" viewBox="0 0 208 204" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect x="64.7578" y="203.873" width="150" height="158.512" transform="rotate(-115.427 64.7578 203.873)" fill="url(#pattern0_1375_11768)"/>
                        <defs>
                            <pattern id="pattern0_1375_11768" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_1375_11768" transform="matrix(0.00206396 0 0 0.00195312 -0.0283737 0)"/>
                            </pattern>
                            <image id="image0_1375_11768" width="512" height="512" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAYAAAD0eNT6AAAAAXNSR0IArs4c6QAAIABJREFUeAHt3Qm0LVV5J/A/s4Ko2AgCDi2KBqMozmOMSloNmjgR08bGOKHRqEvbBI3pVtMqBINT2iguEw0dNUorDnEKg8nSOIa2DRoTh0WLI4IICijTs8+Wcxf3Xd99795zathV9TtrvXXvu/ecqtq/r+p+367atSvxIkCAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAwHICOye5UZKDk9wlyRFJHpPkKUn+IMnLk5yY5KQk/yvJu5J8NMmZSf559t4vJvn6/N95SS5c8++nSX42/3dFku8n+WySNyX57dmy915u832aAAECBAgQWBG4bpJbJ7lPkkfMku4zZr94SZLXJzl1luQ/keSrSS5elZxXknTXXy9N8uYkh6xsvK8ECBAgQIDALwrsMkuYN50n99KDLr301yV5X5Kz5j3srpN4E+srZwdOSHKdX2yynxAgQIAAgWkI7Do/JV9Oxx8zS4rHz0+9l1PupcfcRMKtdRmfml1uOGAaYdZKAgQIEJiqwF7z6+5Hz5P8B+an5ktvuNYE3cV2fTPJYVPdKbSbAAECBMYjsFuSOyVZnejLwLktE0/02ysmShFwk/Hs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"/>
                        </defs>
                    </svg>

                    <div class="bg-white p-6 shadow-lg text-center relative w-[300px] h-[350px] mb-10 ml-10">
                        <p class="text-gray-700 text-[15px] font-semibold mb-2">Summary of Vote</p>

                        <div class="mb-4 mt-8 flex">
                            <p class="font-regular text-[11px] mr-2">President:</p>
                            <p class="text-[11px] font-semibold text-gray-700">YYYYYYYYYYYYYYYY</p>
                        </div>

                        <div class="mb-4 flex">
                            <p class="font-regular text-[11px] mr-2">Vice President Internal:</p>
                            <p class="text-[11px] font-semibold text-gray-500">YYYYYYYYY</p>
                        </div>

                        <div class="mb-4 flex">
                            <p class="font-regular text-[11px] mr-2">Vice President External:</p>
                            <p class="text-[11px] font-semibold text-gray-500">YYYYYYYY</p>
                        </div>

                        <div class="mb-4 flex">
                            <p class="font-regular text-[11px] mr-2">General Secretary:</p>
                            <p class="text-[11px] font-semibold text-gray-500">YYYYYYY</p>
                        </div>

                        <div class="mb-4 flex">
                            <p class="font-regular text-[11px] mr-2">Treasurer:</p>
                            <p class="text-[11px] font-semibold text-gray-500">YYYYYYYYYY</p>
                        </div>

                        <div class="mb-4 flex">
                            <p class="font-regular text-[11px] mr-2">Auditor:</p>
                            <p class="text-[11px] font-semibold text-gray-500">YYYYYYYYYY</p>
                        </div>

                        <div class="mb-4 flex">
                            <p class="font-regular text-[11px] mr-2">PIO:</p>
                            <p class="text-[11px] font-semibold text-gray-500">YYYYYYYYYY</p>
                        </div>

                        <!-- Confirm Button -->
                        <div class="mt-2 text-right">
                            <p class=" mb-2 border border-green-500 text-xs bg-green-500 text-black py-2 px-4 inline-block rounded-lg">
                                Confirm
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Side - SVG Content -->

                <div class="flex flex-col w-full md:w-1/2 items-center justify-start">
                    <div class="w-full 2xl:py-40 py-34">
                        <!-- Voting Steps -->
                        <div class="flex flex-col items-start w-full p-8">
                            <p class="font-bold text-sm text-left">VOTING MADE EASY!</p>
                            <p class="text-xs text-left mt-2">Follow these easy steps to vote!</p>

                            <ol class="list-decimal ml-5 text-[12px] mt-4 space-y-2 text-left">
                                <li>After logging in, you will be directed to the Tagum Student Council Election Page for the phase 1 of voting.</li>
                                <li>You can either select a candidate to vote or abstain from a certain position.</li>
                                <li>You can vote 1 for each student council position. Remember! You can either select or choose to abstain.</li>
                                <li>Click on the <b>see more</b> to see the candidate's details including their college, program, year level, and motto.</li>
                                <li>To select, just pick your candidate and make it the first to show!</li>
                                <li>After carefully selecting, click the submit button to see a summary of your vote.</li>
                                <li>If all your votes are correct, you can now click confirm and you will be directed to phase 2 of the voting process.</li>
                                <li>Otherwise, you can always go back and correct your vote, just click the back button.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </x-slot>

    <x-slot name="wfooter">
        <x-wfooter /> <!-- Use the footer component -->
    </x-slot>




</x-custom-layout>


