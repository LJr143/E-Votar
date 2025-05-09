<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader /> <!-- Use the header component -->
    </x-slot>

    <x-slot name="main">
        <main>
            <div class="relative">
                <div class="relative w-full h-64">
                    <img alt="Eagle" class="w-full h-full object-cover" src="{{ asset('storage/assets/image/eaglee.png') }}" />
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>

                <div class="absolute top-0 left-10 bg-gradient-to-b from-red-600 to-black text-white p-4 text-center">
                    <div class="text-xs sm:text-base">Mon Jun</div>
                    <div class="text-3xl sm:text-4xl md:text-5xl font-bold">10</div>
                </div>

                <div class="absolute inset-0 flex flex-col justify-center items-center text-white text-left">
                    <div class="text-center py-6">
                        <h1 class="text-white text-xs sm:text-sm md:text-lg lg:text-xl font-light tracking-widest">
                            UNIVERSITY OF SOUTHEASTERN PHILIPPINES
                        </h1>
                        <h2 class="text-white text-xl sm:text-2xl md:text-3xl lg:text-5xl font-bold tracking-widest" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                            COMMISSION ON ELECTIONS
                        </h2>
                        <p class="text-white text-xs md:text-sm lg:text-base font-light tracking-widest">
                            IMPARTIALITY, TRANSPARENCY, INTEGRITY
                        </p>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-2 flex justify-center" style="transform: translateY(50%);">
                    <div class="rounded-lg shadow-lg p-4 flex flex-col items-center w-full max-w-2xl" style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);">
                        <h2 class="text-center text-gray-800 font-semibold mb-2 text-lg">Election ends in</h2>
                        <div class="flex flex-wrap justify-around w-full">
                            <div class="text-center mb-2 md:mb-0">
                                <p class="text-2xl font-bold text-gray-800">04</p>
                                <p class="text-xs text-gray-600">DAYS</p>
                            </div>
                            <div class="border-l border-gray-300 mx-2 hidden md:block"></div>
                            <div class="text-center mb-2 md:mb-0">
                                <p class="text-2xl font-bold text-gray-800">10</p>
                                <p class="text-xs text-gray-600">HOURS</p>
                            </div>
                            <div class="border-l border-gray-300 mx-2 hidden md:block"></div>
                            <div class="text-center mb-2 md:mb-0">
                                <p class="text-2xl font-bold text-gray-800">45</p>
                                <p class="text-xs text-gray-600">MINUTES</p>
                            </div>
                            <div class="border-l border-gray-300 mx-2 hidden md:block"></div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-800">56</p>
                                <p class="text-xs text-gray-600">SECONDS</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .carousel-container {
                    overflow: hidden;
                }
                .carousel-track {
                    display: flex;
                    transition: transform 0.5s ease;
                }


                .carousel-item {
                    min-width: calc(80% / 4); /* Show 3 items at once */
                    box-sizing: border-box;
                }
                @media (max-width: 768px) {
                    .carousel-item {
                        min-width: 100%; /* Show 1 item at a time on smaller screens */
                    }
                }
            </style>






            <div class="mt-20  px-4 md:px-0 container mx-auto ">

                <div class="flex flex-wrap justify-center">
                    <div class="w-full md:w-3/4 lg:w-4/5 xl:w-3/4 sm:mb-10">
                        <div class="w-full bg-white shadow-lg p-4 rounded-lg">
                            <div class=" space-y-4">
                                <div class="flex items-center space-x-4">
                                    <img alt="User avatar" class="w-12 h-12 rounded-full" height="50" src="https://storage.googleapis.com/a1aa/image/1RL5_b2NL7UgetrbQdlIqkytMStBqMe89uf2_w4a7Rk.jpg" width="50"/>
                                    <span class="flex-grow text-black text-xs">
                                        Name of the author or admin
                                     </span>
                                </div>
                                <input class="w-full bg-gray-100 text-black placeholder-gray-500 rounded-lg px-4 py-2 text-xs border-none" placeholder="Title of the announcement" type="text"/>
                                <textarea class="w-full bg-gray-100 text-black placeholder-gray-500 rounded-lg px-4 py-2 text-xs focus:outline-none border-none" placeholder="Content of the announcement" rows="4"></textarea>
                            </div>
                            <div class="bg-white p-4 rounded-lg flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                                <div class="flex flex-wrap justify-center md:justify-start space-x-4">
                                    <button class="flex items-center space-x-2 text-black text-[11px]">
                                        <i class="fas fa-image"></i>
                                        <span>Images</span>
                                    </button>
                                    <button class="flex items-center space-x-2 text-black text-[11px]">
                                        <i class="fas fa-video"></i>
                                        <span>Video</span>
                                    </button>
                                    <button class="flex items-center space-x-2 text-black text-[11px]">
                                        <i class="fas fa-poll"></i>
                                        <span>Poll</span>
                                    </button>
                                    <button class="flex items-center space-x-2 text-black text-[11px]">
                                        <i class="fas fa-paperclip"></i>
                                        <span>Attachment</span>
                                    </button>
                                </div>
                                <button class="bg-black text-white px-4 py-2 rounded-full text-[12px]">
                                    Post
                                </button>
                            </div>
                        </div>


                        <div class="mt-5 py-4 px-4 md:px-0   mb-10">
                            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                                <h1 class="text-lg sm:text-[20px] font-bold text-black">
                                    Announcement and Updates
                                </h1>
                            </div>

                            <div class="relative carousel-container">
                                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10">
                                    <button id="prevBtn" class="bg-black text-white p-2 rounded-full">
                                        <i class="fas fa-arrow-left"></i>
                                    </button>
                                </div>
                                <div class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10">
                                    <button id="nextBtn" class="bg-black text-white p-2 rounded-full">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>

                                <div class="carousel-track ">
                                    <div class="carousel-item bg-white p-6 rounded-lg shadow-lg max-w-md w-full sm:mx-3">
                                        <div class="relative">
                                            <img alt="Placeholder image for announcement" class="w-full h-32 object-cover rounded-lg" height="200" src="https://storage.googleapis.com/a1aa/image/t5Ven0DNGed3hZXhMLu0NxdFZ8j0gA4pSNriMwZRIK4.jpg" width="600"/>
                                            <div class="absolute bottom-0 left-0 bg-white px-2 py-1 rounded-tr-lg">
                                                <span class="text-[11px] text-gray-500">Announcement</span>
                                            </div>
                                        </div>
                                        <h1 class="mt-4 text-[14px] font-semibold text-gray-800 hover:text-red-800">
                                            Tagum Student Council and Local Council Election 2025 Requirements
                                        </h1>
                                        <div class="flex justify-between items-center mt-4 text-gray-500 text-sm" style="font-size: 11px;">
                                            <span> Campus </span>
                                            <span>3 Days Ago</span>
                                        </div>
                                    </div>

                                    <div class="carousel-item bg-white p-6 rounded-lg shadow-lg max-w-md w-full sm:mx-3">
                                        <div class="relative">
                                            <img alt="Placeholder image for announcement" class="w-full h-32 object-cover rounded-lg" height="200" src="https://storage.googleapis.com/a1aa/image/t5Ven0DNGed3hZXhMLu0NxdFZ8j0gA4pSNriMwZRIK4.jpg" width="600"/>
                                            <div class="absolute bottom-0 left-0 bg-white px-2 py-1 rounded-tr-lg">
                                                <span class="text-[11px] text-gray-500">Announcement</span>
                                            </div>
                                        </div>
                                        <h1 class="mt-4 text-[14px] font-semibold text-gray-800 hover:text-red-800">
                                            Tagum Student Council and Local Council Election 2025 Requirements
                                        </h1>
                                        <div class="flex justify-between items-center mt-4 text-gray-500 text-sm" style="font-size: 11px;">
                                            <span> Campus </span>
                                            <span>3 Days Ago</span>
                                        </div>
                                    </div>

                                    <div class="carousel-item bg-white p-6 rounded-lg shadow-lg max-w-md w-full sm:mx-3">
                                        <div class="relative">
                                            <img alt="Placeholder image for announcement" class="w-full h-32 object-cover rounded-lg" height="200" src="https://storage.googleapis.com/a1aa/image/t5Ven0DNGed3hZXhMLu0NxdFZ8j0gA4pSNriMwZRIK4.jpg" width="600"/>
                                            <div class="absolute bottom-0 left-0 bg-white px-2 py-1 rounded-tr-lg">
                                                <span class="text-[11px] text-gray-500">Announcement</span>
                                            </div>
                                        </div>
                                        <h1 class="mt-4 text-[14px] font-semibold text-gray-800 hover:text-red-800">
                                            Tagum Student Council and Local Council Election 2025 Requirements
                                        </h1>
                                        <div class="flex justify-between items-center mt-4 text-gray-500 text-sm" style="font-size: 11px;">
                                            <span> Campus </span>
                                            <span>3 Days Ago</span>
                                        </div>
                                    </div>

                                    <div class="carousel-item bg-white p-6 rounded-lg shadow-lg max-w-md w-full sm:mx-3">
                                        <div class="relative">
                                            <img alt="Placeholder image for announcement" class="w-full h-32 object-cover rounded-lg" height="200" src="https://storage.googleapis.com/a1aa/image/t5Ven0DNGed3hZXhMLu0NxdFZ8j0gA4pSNriMwZRIK4.jpg" width="600"/>
                                            <div class="absolute bottom-0 left-0 bg-white px-2 py-1 rounded-tr-lg">
                                                <span class="text-[11px] text-gray-500">Announcement</span>
                                            </div>
                                        </div>
                                        <h1 class="mt-4 text-[14px] font-semibold text-gray-800 hover:text-red-800">
                                            Tagum Student Council and Local Council Election 2025 Requirements
                                        </h1>
                                        <div class="flex justify-between items-center mt-4 text-gray-500 text-sm" style="font-size: 11px;">
                                            <span> Campus </span>
                                            <span>3 Days Ago</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            const track = document.querySelector('.carousel-track');
                            const prevBtn = document.getElementById('prevBtn');
                            const nextBtn = document.getElementById('nextBtn');
                            let currentIndex = 0;

                            prevBtn.addEventListener('click', () => {
                                if (currentIndex > 0) {
                                    currentIndex--;
                                    track.style.transform = `translateX(-${currentIndex * 100}%)`;
                                }
                            });

                            nextBtn.addEventListener('click', () => {
                                if (currentIndex < track.children.length - 1) {
                                    currentIndex++;
                                    track.style.transform = `translateX(-${currentIndex * 100}%)`;
                                }
                            });
                        </script>
                    </div>

                    <div class="w-full md:w-1/4 lg:w-1/5 xl:w-1/4 px-8 mb-10">
                        <div class="w-full mx-auto bg-white shadow-lg px-4 rounded-lg">
                            <h2 class="text-black text-lg font-semibold mb-4">
                                Preview
                            </h2>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-4">
                                    <img alt="User avatar" class="w-12 h-12 rounded-full" height="50" src="https://storage.googleapis.com/a1aa/image/LKkP4QwYdKM9wIU4-uxiSOqHqo6MKKDWbnTwSrfss7E.jpg" width="50"/>
                                    <span class="flex-grow text-black text-xs">
                                       Name of the author or admin
                                      </span>
                                </div>
                                <div class="bg-gray-100 text-black placeholder-gray-500 rounded-lg px-4 py-2 text-xs border-none">
                                    Title of the announcement
                                </div>
                                <div class="bg-gray-100 text-black placeholder-gray-500 rounded-lg px-4 py-2 text-xs border-none">
                                    Content of the announcement
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="py-4 px-4 md:px-0 container mx-auto">
                    <div class="flex flex-wrap justify-center">
                        <div class="w-full md:w-3/4 lg:w-4/5 xl:w-3/4 sm:mb-10">
                            <h1 class="text-center text-[20px] font-bold text-black mb-8">ELECTION TITLE - OFFICIAL CANDIDATES</h1>
                            <h2 class="text-center text-[16px] font-medium text-gray-700 mb-4">Select an organization to view the corresponding list of candidates.</h2>

                            <div class="flex flex-wrap">
                                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                    <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col justify-center items-center transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer bg-white">
                                        <div class="p-2 flex-grow flex flex-col justify-center items-center">
                                            <i class="fas fa-plus-circle text-4xl text-gray-400"></i>
                                            <h2 class="text-center text-[12px] font-bold mt-2">
                                                ADD NEW ORGANIZATION
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                    <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                        <img alt="Tagum Student Council (TSC) poster" class="w-full h-24 object-cover" src="https://storage.googleapis.com/a1aa/image/RlbdPVmEb_3KW4hMW0CVil5AiSFSm4rn5rDjUWyeXKw.jpg" />
                                        <div class="p-2 flex-grow">
                                            <h2 class="text-center text-[12px] font-bold">
                                                TAGUM STUDENT COUNCIL (TSC)
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                    <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                        <img alt="Society of Information Technology Students (SITS) poster" class="w-full h-24 object-cover" src="https://storage.googleapis.com/a1aa/image/C6U9OUZyJkg294sb6MJYjumXr2taJqeNCdf46WiNcOI.jpg" />
                                        <div class="p-2 flex-grow">
                                            <h2 class="text-center text-[12px] font-bold">
                                                SOCIETY OF INFORMATION TECHNOLOGY STUDENTS (SITS)
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                    <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                        <img alt="Society of Agricultural and Biosystems Engineering Students (SABES) poster" class="w-full h-24 object-cover" src="https://storage.googleapis.com/a1aa/image/_XvrxhY3uD3DG3RuaEgf4lsZaVpmhOsI96TkRPs4a-w.jpg" />
                                        <div class="p-2 flex-grow">
                                            <h2 class="text-center text-[12px] font-bold">
                                                SOCIETY OF AGRICULTURAL BIOSYSTEMS ENGINEERING STUDENTS (SABES)
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                    <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                        <img alt="Association of Future Secondary Education Teachers (AFSET) poster" class="w-full h-24 object-cover" src="https://storage.googleapis.com/a1aa/image/jhALoD1ZHZWoSmgfyImlRJGeOts2DQ3KcKfwK8svgHI.jpg" />
                                        <div class="p-2 flex-grow">
                                            <h2 class="text-center text-[12px] font-bold">
                                                ASSOCIATION OF FUTURE SECONDARY EDUCATION TEACHERS (AFSET)
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                    <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                        <img alt="Organization of Future Elementary Educators (OFEE) poster" class="w-full h-24 object-cover" src="https://storage.googleapis.com/a1aa/image/mwiWkSK34O2RWoORw_juiLBd-I-WjqzssRWvipk_8Yw.jpg" />
                                        <div class="p-2 flex-grow">
                                            <h2 class="text-center text-[12px] font-bold">
                                                ORGANIZATION OF FUTURE ELEMENTARY EDUCATORS (OFEE)
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                    <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                        <img alt="Bachelor of Early Childhood Education (BECEd) poster" class="w-full h-24 object-cover" src="https://storage.googleapis.com/a1aa/image/0mdmfPGeLZi10JQxVlxKwTo6rQy44DYnQJSObs465Wg.jpg" />
                                        <div class="p-2 flex-grow">
                                            <h2 class="text-center text-[12px] font-bold">
                                                BACHELOR OF EARLY CHILDHOOD EDUCATION (BECEd)
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                    <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                        <img alt="Bachelor of Special Needs Education (BSNEd) poster" class="w-full h-24 object-cover" src="https://storage.googleapis.com/a1aa/image/USf_tLRoQunSdKT93pDUCFI9sb7NPUNeObuwe1rOmI8.jpg" />
                                        <div class="p-2 flex-grow">
                                            <h2 class="text-center text-[12px] font-bold">
                                                BACHELOR OF SPECIAL NEEDS EDUCATION (BSNEd)
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                    <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                        <img alt="Bachelor of Technical Vocational Teacher Education (BTVTEd) poster" class="w-full h-24 object-cover" src="https://storage.googleapis.com/a1aa/image/7krt-7S6u4LCDEgOqNj5qceumU1JCr7ybGf_lP4utG0.jpg" />
                                        <div class="p-2 flex-grow">
                                            <h2 class="text-center text-[12px] font-bold">
                                                BACHELOR OF TECHNICAL VOCATIONAL TEACHER EDUCATION (BTVTEd)
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>









                            <div class="mt-14">
                                <h1 class="text-center text-[20px] font-bold text-black mb-8">PARTYLIST</h1>
                                <h2 class="text-center text-[16px] font-medium text-gray-700 mb-4">Select a partylist to view the corresponding members</h2>

                                <div class="flex flex-wrap">
                                    <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                        <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col justify-center items-center transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                            <div class="p-4 flex flex-col items-center">
                                                <i class="fas fa-plus-circle text-4xl text-gray-400 mb-2"></i>
                                                <h2 class="text-center text-[12px] font-bold text-gray-700">
                                                    Add New Partylist
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                        <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                            <img alt="Image of Yanong Agila, a majestic eagle with a sharp gaze and spread wings" class="w-full h-16 object-cover" height="400" src="https://storage.googleapis.com/a1aa/image/nCwM01gjm61HpHh9F04TN4hcO6f4V1D4KwLnjXxa3vM.jpg" width="600"/>
                                            <div class="p-2 flex-grow">
                                                <h2 class="text-center text-[12px] font-bold">
                                                    Yanong Agila
                                                </h2>
                                            </div>
                                            <div class="flex items-center space-x-2 px-2">
                                           <span class="text-gray-700 font-medium text-[9px]">
                                            Members
                                           </span>
                                                <span class="bg-gray-100 text-gray-700 text-[9px] font-medium px-2 py-0.5 rounded-full">
                                            1.2m
                                           </span>
                                            </div>
                                            <div class="flex items-center space-x-2 p-2">
                                                <div class="flex -space-x-2">
                                                    <img alt="User avatar 1" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/ZuTpJE6pJfJbppzY8Khmg-vOg6u2WXLzLMgz5_Uoc-0.jpg" width="24"/>
                                                    <img alt="User avatar 2" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/2pXhDPPK7gfhc2BafGJ_EAzRgUL9U11eKHP90gamIBo.jpg" width="24"/>
                                                    <img alt="User avatar 3" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/JiBdvOYQiJDmouspoR7oGEmdSCAvmDX0byxIpKTpbik.jpg" width="24"/>
                                                    <img alt="User avatar 4" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/-M0cg3Rd111OQRFnFY0nwtlNhSBGQiLq6cAOyZpeW5M.jpg" width="24"/>
                                                    <img alt="User avatar 5" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/gfEX5XQdkQ7irgoTAk4LgYP83FAwCT6UcvkAVb-AG8E.jpg" width="24"/>
                                                    <img alt="User avatar 6" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/bnKnpUdroN4U_87nsHuEijIHOY0ugMer4RvXvgjQuVg.jpg" width="24"/>
                                                    <img alt="User avatar 7" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/8y98ymkaXo-zARhuMtYOpHC7dVQksFPl3flWReilCps.jpg" width="24"/>
                                                </div>
                                                <span class="text-black font-medium text-[10px]">
                                            + 1,164,821
                                           </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                                        <div class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                            <img alt="Image of Yanong Agila, a majestic eagle with a sharp gaze and spread wings" class="w-full h-16 object-cover" height="400" src="https://storage.googleapis.com/a1aa/image/nCwM01gjm61HpHh9F04TN4hcO6f4V1D4KwLnjXxa3vM.jpg" width="600"/>
                                            <div class="p-2 flex-grow">
                                                <h2 class="text-center text-[12px] font-bold">
                                                    Paragon
                                                </h2>
                                            </div>
                                            <div class="flex items-center space-x-2 px-2">
                                           <span class="text-gray-700 font-medium text-[9px]">
                                            Members
                                           </span>
                                                <span class="bg-gray-100 text-gray-700 text-[9px] font-medium px-2 py-0.5 rounded-full">
                                            1.2m
                                           </span>
                                            </div>
                                            <div class="flex items-center space-x-2 p-2">
                                                <div class="flex -space-x-2">
                                                    <img alt="User avatar 1" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/ZuTpJE6pJfJbppzY8Khmg-vOg6u2WXLzLMgz5_Uoc-0.jpg" width="24"/>
                                                    <img alt="User avatar 2" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/2pXhDPPK7gfhc2BafGJ_EAzRgUL9U11eKHP90gamIBo.jpg" width="24"/>
                                                    <img alt="User avatar 3" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/JiBdvOYQiJDmouspoR7oGEmdSCAvmDX0byxIpKTpbik.jpg" width="24"/>
                                                    <img alt="User avatar 4" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/-M0cg3Rd111OQRFnFY0nwtlNhSBGQiLq6cAOyZpeW5M.jpg" width="24"/>
                                                    <img alt="User avatar 5" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/gfEX5XQdkQ7irgoTAk4LgYP83FAwCT6UcvkAVb-AG8E.jpg" width="24"/>
                                                    <img alt="User avatar 6" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/bnKnpUdroN4U_87nsHuEijIHOY0ugMer4RvXvgjQuVg.jpg" width="24"/>
                                                    <img alt="User avatar 7" class="w-6 h-6 rounded-full border-2 border-white" height="24" src="https://storage.googleapis.com/a1aa/image/8y98ymkaXo-zARhuMtYOpHC7dVQksFPl3flWReilCps.jpg" width="24"/>
                                                </div>
                                                <span class="text-black font-medium text-[10px]">
                                            + 1,164,821
                                           </span>
                                            </div>
                                        </div>
                                    </div>




                                </div>
                            </div>







                        </div>







                        <div class="w-full md:w-1/4 lg:w-1/5 xl:w-1/4 p-2 mb-10">
                            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
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
                                <button class="mt-6 w-full bg-black hover:bg-gray-800 text-white py-2 rounded flex items-center justify-center">
                        <span class="text-[11px]">
                            View More
                        </span>
                                    <i class="fas fa-chevron-right ml-2 text-[11px]"></i>
                                </button>
                            </div>


                        </div>
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
