<div>
    <style>
        @keyframes shine {
            to { background-position: 200% center; }
        }
    </style>
    <div class="min-h-screen font-poppins text-black p-2 sm:p-4 bg-white">
        <div class="container mx-auto max-w-4xl">
            <div class="p-4">
                <div class="mb-6 sm:mb-8 text-center">
                    <!-- Logos -->
                    <div class="flex justify-center gap-3 sm:gap-6 mb-4 sm:mb-6">
                        <img src="{{ asset('storage/assets/logo/tsc_logo.png') }}" alt="TSC Logo" class="h-12 w-12 sm:h-16 sm:w-16">
                        <img src="{{ asset('storage/assets/logo/usep_logo.jpg') }}" alt="USeP Logo" class="h-12 w-12 sm:h-16 sm:w-16">
                        <img src="{{ asset('storage/assets/logo/tsc_comelec_logo.png') }}" alt="Comelec Logo" class="h-12 w-12 sm:h-16 sm:w-16">
                    </div>

                    <div class="mb-8 sm:mb-10 p-4 sm:p-6 border-t border-b border-gray-200">
                        <h2 class="text-center text-2xl sm:text-3xl md:text-4xl font-bold mb-2" style="background-size: 200% auto; -webkit-background-clip: text; background-clip: text; color: transparent; text-shadow: 0px 2px 4px rgba(0,0,0,0.1); background-image: linear-gradient(to right, #D4AF37, #8B0000, #D4AF37); animation: shine 2s linear infinite;">
                            CONGRATULATIONS
                        </h2>
                        <p class="text-gray-700 text-sm sm:text-base">
                            To the newly elected Student Council Officers for Academic Year 2024-2025
                        </p>
                    </div>
                </div>

                <!-- Main Title -->
                <div class="h-0.5 w-36 sm:w-48 mx-auto mb-3 bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent"></div>

                <!-- Subtitle -->
                <h1 class="text-center text-gray-800 text-[14px] sm:text-[16px] md:text-[18px] font-medium mb-2">
                    TAGUM STUDENT COUNCIL
                </h1>
                <div class="h-px w-24 sm:w-32 mx-auto mb-6 sm:mb-8 bg-gradient-to-r from-transparent via-[#8B0000] to-transparent"></div>

                <!-- Candidates - First Row (PRESIDENT only) -->
                <div class="flex justify-center mb-8 sm:mb-12">
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[160px] sm:h-[160px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white "></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative ">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">PRESIDENT</p>
                    </div>
                </div>

                <!-- Candidates - Second Row -->
                <div class="grid sm:grid-cols-3 gap-4 sm:gap-6 md:gap-8 mb-8 sm:mb-12 justify-items-center">
                    <!-- VP FOR INTERNAL AFFAIRS -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">VP FOR INTERNAL AFFAIRS</p>
                    </div>

                    <!-- VP FOR EXTERNAL AFFAIRS -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">VP FOR EXTERNAL AFFAIRS</p>
                    </div>

                    <!-- GENERAL SECRETARY -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">GENERAL SECRETARY</p>
                    </div>
                </div>

                <!-- Candidates - Third Row -->
                <div class="grid sm:grid-cols-3 gap-4 sm:gap-6 md:gap-8 justify-items-center">
                    <!-- GENERAL TREASURER -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">GENERAL TREASURER</p>
                    </div>

                    <!-- GENERAL AUDITOR -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">GENERAL AUDITOR</p>
                    </div>

                    <!-- PUBLIC INFORMATION OFFICER -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">PUBLIC INFORMATION OFFICER</p>
                    </div>
                </div>


                <div class="w-full px-4">
                    <!-- Alpine.js dropdown component -->
                    <div x-data="{
                    open: false,
                    selected: 'SOCIETY OF AGRICULTURAL BIOSYSTEMS ENGINEERING STUDENTS (SABES)',
                    options: [
                        'SOCIETY OF AGRICULTURAL BIOSYSTEMS ENGINEERING STUDENTS (SABES)',
                        'SOCIETY OF INFORMATION TECHNOLOGY STUDENTS (SITS)',
                        'ASSOCIATION OF FUTURE SECONDARY EDUCATION TEACHERS (AFSET)',
                        'ORGANIZATION OF FUTURE ELEMENTARY EDUCATORS (OFEE)',
                        'BACHELOR OF EARLY CHILDHOOD EDUCATION (BECEd)',
                        'BACHELOR OF SPECIAL NEEDS EDUCATION (BSNEd)',
                        'BACHELOR OF TECHNICAL VOCATIONAL TEACHER EDUCATION (BTVTEd)'
                    ]
                }">
                        <!-- Top decorative line -->
                        <div class="h-0.5 w-36 sm:w-48 mx-auto mb-3 mt-20 bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent"></div>

                        <!-- Dropdown button -->
                        <div class="relative">
                            <button @click="open = !open" type="button" class="w-full text-center text-gray-800 text-[14px] sm:text-[16px] md:text-[18px] font-medium mb-2 hover:text-gray-600 focus:outline-none">
                                <span x-text="selected"></span>
                                <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute z-50 mt-1 w-full bg-white shadow-lg rounded-md py-1 text-gray-800 text-[14px] sm:text-[16px] max-h-60 overflow-auto"
                                style="display: none;"
                            >
                                <template x-for="option in options" :key="option">
                                    <a
                                        href="#"
                                        @click.prevent="selected = option; open = false"
                                        class="block px-4 py-2 hover:bg-gray-100"
                                        :class="{'bg-gray-100': selected === option}"
                                        x-text="option"
                                    ></a>
                                </template>
                            </div>
                        </div>

                        <!-- Bottom decorative line -->
                        <div class="h-px w-24 sm:w-32 mx-auto mb-6 sm:mb-8 bg-gradient-to-r from-transparent via-[#8B0000] to-transparent"></div>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4 sm:gap-6 md:gap-8 mb-8 sm:mb-12 justify-items-center">
                    <!-- Governor -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[160px] sm:h-[160px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white "></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative ">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">GOVERNOR</p>
                    </div>

                    <!-- Vice Governor -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[160px] sm:h-[160px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative ">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">VICE GOVERNOR</p>
                    </div>
                </div>

                <!-- Candidates - Second Row -->
                <div class="grid sm:grid-cols-3 gap-4 sm:gap-6 md:gap-8 mb-8 sm:mb-12 justify-items-center">
                    <!-- Auditor -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">AUDITOR</p>
                    </div>

                    <!-- Secretary -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">SECRETARY</p>
                    </div>

                    <!-- Treasurer -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">TREASURER</p>
                    </div>
                </div>

                <!-- Candidates - Third Row -->
                <div class="grid sm:grid-cols-3 gap-4 sm:gap-6 md:gap-8 justify-items-center">
                    <!-- Legislator 1 -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">LEGISLATOR</p>
                    </div>

                    <!-- Legislator 2 -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">LEGISLATOR</p>
                    </div>

                    <!-- Legislator 3 -->
                    <div class="flex flex-col items-center">
                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-4">
                            <div class="relative rounded-full overflow-hidden w-[140px] h-[140px] sm:w-[120px] sm:h-[120px]">
                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                <img src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="candidate profile" class="w-full h-full object-cover relative">
                            </div>
                        </div>
                        <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">CANDIDATE NAME</p>
                        <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">LEGISLATOR</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
