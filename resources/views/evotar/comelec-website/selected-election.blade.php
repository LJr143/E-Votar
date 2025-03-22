<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader /> <!-- Use the header component -->
    </x-slot>

    <x-slot name="main">

        <main>
            <div class="bg-gray-600 flex items-center justify-center p-8">

                <div class="container mx-auto py-8 md:px-4">
                    <div class="flex items-center text-white space-x-4">
                        <div class="text-[12px]">
                            Tagum Unit
                        </div>
                        <div class="text-[12px]">
                            Jan 04, 2025 - Jan 10, 2025
                        </div>
                    </div>
                    <div class="mt-4">
                        <h1 class="text-[20px] font-bold text-white">
                            Tagum Student Council and Local Council Election 2025 Requirements
                        </h1>
                    </div>


                </div>
            </div>

            <div x-data="{ activeTab: 0 }" class="w-full text-center">
                <div class="flex justify-center">
                    <div @click="activeTab = 0" :class="activeTab === 0 ? 'border-b-2 border-white' : 'opacity-50'" class="tab bg-black text-white py-2 px-4 w-full cursor-pointer text-[12px]">
                        Candidates
                    </div>
                    <div @click="activeTab = 1" :class="activeTab === 1 ? 'border-b-2 border-white' : 'opacity-50'" class="tab bg-black text-white py-2 px-4 w-full cursor-pointer text-[12px]">
                        Vote Tally
                    </div>
                    <div @click="activeTab = 2" :class="activeTab === 2 ? 'border-b-2 border-white' : 'opacity-50'" class="tab bg-black text-white py-2 px-4 w-full cursor-pointer text-[12px]">
                        Elected Officials
                    </div>
                </div>
                <div class="tab-content-container mt-4 text-[12px]">
                    <div x-show="activeTab === 0" class="tab-content">
                        <div class="mx-auto  px-4 md:px-12">
                            <div class="flex flex-col lg:flex-row">
                                <!-- Main Content -->
                                <div class="w-full lg:w-3/4 p-4 md:px-0 pt-16 mr-6">
                                    <div class="mb-10">
                                        <h1 class="text-[16px] font-semibold mb-4 text-left">
                                            Tagum Student Council Candidates
                                        </h1>
                                        <div class="flex flex-col sm:flex-row mb-4">
                                            <input
                                                class="text-[12px] border border-gray-300 p-2 rounded mb-2 sm:mb-0 sm:mr-2 w-full sm:w-1/3 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Search candidate name"
                                                type="text"/>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                            <!-- Candidate Card -->
                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">PRESIDENT</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">PRESIDENT CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">PRESIDENT CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">VP FOR INTERNAL AFFAIRS</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">VP FOR INTERNAL AFFAIRS CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">VP FOR INTERNAL AFFAIRS CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">VP FOR EXTERNAL AFFAIRS</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">VP FOR EXTERNAL AFFAIRS CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">VP FOR EXTERNAL AFFAIRS CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">GENERAL SECRETARY</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">GENERAL SECRETARY CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">GENERAL SECRETARY CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">GENERAL TREASURER</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">GENERAL TREASURER CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">GENERAL TREASURER CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">GENERAL AUDITOR</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">GENERAL AUDITOR CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">GENERAL AUDITOR CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">PUBLIC INFORMATION OFFICER</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">PIO CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">PIO CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>
                                        </div>
                                    </div>


                                    <div>
                                        <h1 class="text-[16px] font-semibold mb-4 text-left">
                                            SOCIETY OF INFORMATION TECHNOLOGY STUDENTS (SITS) CANDIDATES
                                        </h1>
                                        <div class="flex flex-col sm:flex-row mb-4">
                                            <input
                                                class="text-[12px] border border-gray-300 p-2 rounded mb-2 sm:mb-0 sm:mr-2 w-full sm:w-1/3 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Search candidate name"
                                                type="text"/>
                                            <select class="text-[12px] border border-gray-300 p-2 rounded w-full sm:w-auto transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option class="text-gray-500" disabled selected>Select organization</option>
                                                <option>SOCIETY OF AGRICULTURAL BIOSYSTEMS ENGINEERING STUDENTS (SABES)</option>
                                                <option>SOCIETY OF INFORMATION TECHNOLOGY STUDENTS (SITS)</option>
                                                <option>ASSOCIATION OF FUTURE SECONDARY EDUCATION TEACHERS (AFSET)</option>
                                                <option>ORGANIZATION OF FUTURE ELEMENTARY EDUCATORS (OFEE)</option>
                                                <option>BACHELOR OF EARLY CHILDHOOD EDUCATION (BECEd)</option>
                                                <option>BACHELOR OF SPECIAL NEEDS EDUCATION (BSNEd)</option>
                                                <option>BACHELOR OF TECHNICAL VOCATIONAL TEACHER EDUCATION (BTVTEd)</option>
                                            </select>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                            <!-- Candidate Card -->
                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">GOVERNOR</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">GOVERNOR CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">GOVERNOR CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">VICE GOVERNOR</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">VICE GOVERNOR CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">VICE GOVERNOR CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">AUDITOR</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">AUDITOR CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">AUDITOR CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">TREASURER</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">TREASURER CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">TREASURER CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">SECRETARY</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">TREASURER CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">TREASURER CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>
                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">TREASURER</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">TREASURER CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">TREASURER CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                            <div x-data="carousel(2)" x-init="startAutoplay()" class="relative w-50 overflow-hidden">
                                                <p class="text-[11px] text-gray-500 h-8">
                                                    Running for <span class="font-semibold text-red-500">LEGISLATOR</span>
                                                </p>
                                                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 1" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/sample_profile.png') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">LEGISLATOR CANDIDATE 1, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 2" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">LEGISLATOR CANDIDATE 2, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                    <div class="p-2 relative flex-none w-full">
                                                        <img alt="Candidate 3" class="w-full h-50 object-cover rounded mt-2" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" />
                                                        <p class="mt-2 font-semibold text-[12px]">LEGISLATOR CANDIDATE 3, <span class="font-normal text-[10px] italic">BSIT</span></p>
                                                        <p class="text-[11px] text-gray-500">Paragon</p>
                                                    </div>
                                                </div>
                                                <button @click="prev()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10094;</button>
                                                <button @click="next()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg">&#10095;</button>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                                <!-- Sidebar -->
                                <div class="w-full md:w-1/3 lg:w-1/4 p-2 mb-10 md:py-20">
                                    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mb-4">
                                        <div class="text-black">
                                            <h1 class="text-[12px] font-bold mb-4">Election ends in:</h1>
                                            <div class="flex items-center justify-center space-x-2 mb-6">
                                                <div class="text-center">
                                                    <div class="border-2 border-black p-2 w-12 h-12 text-[12px] font-bold bg-white bg-opacity-10 rounded-lg shadow-lg backdrop-blur-md flex items-center justify-center">03</div>
                                                    <div class="mt-2 text-[11px]">Days</div>
                                                </div>
                                                <div class="text-[12px] font-bold relative -top-2">:</div>
                                                <div class="text-center">
                                                    <div class="border-2 border-black p-2 w-12 h-12 text-[12px] font-bold bg-white bg-opacity-10 rounded-lg shadow-lg backdrop-blur-md flex items-center justify-center">05</div>
                                                    <div class="mt-2 text-[11px]">Hours</div>
                                                </div>
                                                <div class="text-[12px] font-bold relative -top-2">:</div>
                                                <div class="text-center">
                                                    <div class="border-2 border-black p-2 w-12 h-12 text-[12px] font-bold bg-white bg-opacity-10 rounded-lg shadow-lg backdrop-blur-md flex items-center justify-center">12</div>
                                                    <div class="mt-2 text-[11px]">Mins</div>
                                                </div>
                                                <div class="text-[12px] font-bold relative -top-2">:</div>
                                                <div class="text-center">
                                                    <div class="border-2 border-black p-2 w-12 h-12 text-[12px] font-bold bg-white bg-opacity-10 rounded-lg shadow-lg backdrop-blur-md flex items-center justify-center">06</div>
                                                    <div class="mt-2 text-[11px]">Secs</div>
                                                </div>
                                            </div>
                                            <button class="bg-black  hover:bg-gray-600 text-white py-2 px-6 rounded text-[12px] w-full">Vote now</button>
                                        </div>
                                    </div>


                                    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md text-left">
                                        <h1 class="text-base  font-bold mb-4">
                                            Elections
                                        </h1>
                                        <h2 class="text-[12px]  font-semibold mb-2">
                                            Upcoming Election
                                        </h2>
                                        <div class="bg-gray-200 p-2 rounded mb-6">
                                            <p class="text-center text-[11px] text-gray-600">
                                                There are no upcoming election
                                            </p>
                                        </div>
                                        <h2 class="text-[12px] font-semibold mb-2">
                                            Past Election
                                        </h2>
                                        <div class="space-y-4">
                                            <div class="flex items-start space-x-4 hover:bg-gray-100 p-2 rounded">
                                                <div>
                                                    <h3 class="font-semibold text-[10px]">
                                                        Tagum Unit
                                                    </h3>
                                                    <p class="text-[12px] ">
                                                        Tagum Student Council and Local Council Election 2025
                                                    </p>
                                                    <p class="text-[10px] text-gray-500">
                                                        Jan 04, 2025 - Jan 10, 2025
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-start space-x-4 hover:bg-gray-100 p-2 rounded">
                                                <div>
                                                    <h3 class="font-semibold text-[10px]">
                                                        Tagum Unit
                                                    </h3>
                                                    <p class="text-[12px] ">
                                                        Tagum Student Council and Local Council Election 2025
                                                    </p>
                                                    <p class="text-[10px] text-gray-500">
                                                        Jan 04, 2025 - Jan 10, 2025
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-start space-x-4 hover:bg-gray-100 p-2 rounded">
                                                <div>
                                                    <h3 class="font-semibold text-[10px]">
                                                        Tagum Unit
                                                    </h3>
                                                    <p class="text-[12px] ">
                                                        Tagum Student Council and Local Council Election 2025
                                                    </p>
                                                    <p class="text-[10px] text-gray-500">
                                                        Jan 04, 2025 - Jan 10, 2025
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('comelec-website.list-of-elections') }}" class="mt-6 w-full bg-black hover:bg-gray-800 text-white py-2 rounded flex items-center justify-center">
                                <span class="text-[11px]">
                                    View More
                                </span>
                                            <i class="fas fa-chevron-right ml-2 text-[11px]"></i>
                                        </a>
                                    </div>



                                </div>
                            </div>
                        </div>
                        <script>
                            function carousel() {
                                return {
                                    currentIndex: 0,
                                    totalItems: 0,
                                    interval: null,
                                    init() {
                                        // Get the parent container and count only the divs inside it
                                        this.totalItems = this.$el.querySelectorAll('.flex > div').length;
                                    },
                                    startAutoplay() {
                                        this.interval = setInterval(() => {
                                            this.next();
                                        }, 3000);
                                    },
                                    stopAutoplay() {
                                        clearInterval(this.interval);
                                    },
                                    next() {
                                        this.currentIndex = (this.currentIndex + 1) % this.totalItems;
                                    },
                                    prev() {
                                        this.currentIndex = (this.currentIndex - 1 + this.totalItems) % this.totalItems;
                                    }
                                }
                            }
                        </script>

                    </div>
                    <div x-show="activeTab === 1" class="tab-content">
                        <p>Content for Second tab</p>
                    </div>
                    <div x-show="activeTab === 2" class="tab-content">
                        <p>Content for Third tab</p>
                    </div>
                </div>
            </div>
        </main>

    </x-slot>

    <x-slot name="wfooter">
        <x-wfooter /> <!-- Use the footer component -->
    </x-slot>




</x-custom-layout>


