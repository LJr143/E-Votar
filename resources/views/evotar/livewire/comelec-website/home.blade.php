<div>
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
    <div class="relative">
        <div class="relative w-full h-64">
            <img alt="Eagle" class="w-full h-full object-cover" src="{{ asset('storage/assets/image/eaglee.png') }}"/>
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>

        <div class="absolute top-0 left-10 bg-gradient-to-b from-red-600 to-black text-white p-4 text-center">
            <div class="text-xs sm:text-base">{{ $date->format('D M') }}</div>
            <div class="text-3xl sm:text-4xl md:text-5xl font-bold">{{ $date->format('d') }}</div>
        </div>

        <div class="absolute inset-0 flex flex-col justify-center items-center text-white text-left">
            <div class="text-center py-6">
                <h1 class="text-white text-xs sm:text-sm md:text-lg lg:text-xl font-light tracking-widest">
                    UNIVERSITY OF SOUTHEASTERN PHILIPPINES
                </h1>
                <h2 class="text-white text-xl sm:text-2xl md:text-3xl lg:text-5xl font-bold tracking-widest"
                    style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                    COMMISSION ON ELECTIONS
                </h2>
                <p class="text-white text-xs md:text-sm lg:text-base font-light tracking-widest">
                    IMPARTIALITY, TRANSPARENCY, INTEGRITY
                </p>
            </div>
        </div>
        @if($selectedElection)
            <livewire:election-dropdown/>
            <div class="absolute bottom-0 left-0 right-0 p-2 flex justify-center" style="transform: translateY(50%);">
                <div class="rounded-lg shadow-lg p-4 flex flex-col items-center w-full max-w-2xl"
                     style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);">
                    <h2 class="text-center text-gray-800 font-semibold text-lg uppercase">{{ $latestElection ? $latestElection->campus->name . ' ' . $latestElection->name : '' }}</h2>

                    <livewire:timer.website-dashboard-timer :selectedElection="$selectedElection"
                                                            wire:key="timer-election-{{$selectedElection}}"/>

                </div>
            </div>
        @endif
    </div>


    <div class="mt-20 py-4 px-8 mx-auto mb-0 sm:mb-10">
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
                    <a href="{{ route('comelec-website.selected-announcement') }}">
                        <div class="relative">
                            <img alt="Placeholder image for announcement" class="w-full h-32 object-cover rounded-lg"
                                 height="200"
                                 src="https://storage.googleapis.com/a1aa/image/t5Ven0DNGed3hZXhMLu0NxdFZ8j0gA4pSNriMwZRIK4.jpg"
                                 width="600"/>
                            <div class="absolute bottom-0 left-0 bg-white px-2 py-1 rounded-tr-lg">
                                <span class="text-[11px] text-gray-500">Announcement</span>
                            </div>
                        </div>
                        <h1 class="mt-4 text-[14px] font-semibold text-gray-800 hover:text-red-800">
                            Tagum Student Council and Local Council Election 2025 Requirements
                        </h1>
                        <div class="flex justify-between items-center mt-4 text-gray-500 text-sm"
                             style="font-size: 11px;">
                            <span> Campus </span>
                            <span>3 Days Ago</span>
                        </div>
                    </a>
                </div>

                <div class="carousel-item bg-white p-6 rounded-lg shadow-lg max-w-md w-full sm:mx-3">
                    <div class="relative">
                        <img alt="Placeholder image for announcement" class="w-full h-32 object-cover rounded-lg"
                             height="200"
                             src="https://storage.googleapis.com/a1aa/image/t5Ven0DNGed3hZXhMLu0NxdFZ8j0gA4pSNriMwZRIK4.jpg"
                             width="600"/>
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
                        <img alt="Placeholder image for announcement" class="w-full h-32 object-cover rounded-lg"
                             height="200"
                             src="https://storage.googleapis.com/a1aa/image/t5Ven0DNGed3hZXhMLu0NxdFZ8j0gA4pSNriMwZRIK4.jpg"
                             width="600"/>
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
                        <img alt="Placeholder image for announcement" class="w-full h-32 object-cover rounded-lg"
                             height="200"
                             src="https://storage.googleapis.com/a1aa/image/t5Ven0DNGed3hZXhMLu0NxdFZ8j0gA4pSNriMwZRIK4.jpg"
                             width="600"/>
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

    <div class="px-8">
        <div class="flex flex-wrap justify-center">
            <div class="w-full  sm:mb-10">
                @if($latestElection)
                    <h1 class="text-center text-[20px] font-bold text-black mb-8 uppercase">{{$latestElection->name}} -
                        OFFICIAL CANDIDATES</h1>
                    @else
                    <h1 class="text-center text-[20px] font-bold text-black mb-8 uppercase">NO ELECTION ADDED YET</h1>
                @endif
                <h2 class="text-center text-[16px] font-medium text-gray-700 mb-4">Select an organization to view the
                    corresponding list of candidates.</h2>

                <div class="flex flex-wrap">
                    @foreach($councilOrgs as $org)
                        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                            <a href="{{ route('comelec-website.selected-election', $org->id) }}"
                               class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                <img alt="Tagum Student Council (TSC) poster" class="w-full h-24 object-cover"
                                     src="{{asset('storage/' . $org->logo_path)}}"/>
                                <div class="p-2 flex-grow">
                                    <h2 class="text-center text-[12px] font-bold uppercase">
                                        {{ $org->name }}
                                    </h2>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-14 mb-10">
                    <h1 class="text-center text-[20px] font-bold text-black mb-8">PARTYLIST</h1>
                    <h2 class="text-center text-[16px] font-medium text-gray-700 mb-4">Select a partylist to view the
                        corresponding members</h2>

                    <div class="flex flex-wrap">
                        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                            <a href="{{ route('comelec-website.selected-partylist') }}"
                               class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                <img alt="Image of Yanong Agila, a majestic eagle with a sharp gaze and spread wings"
                                     class="w-full h-16 object-cover" height="400"
                                     src="https://storage.googleapis.com/a1aa/image/nCwM01gjm61HpHh9F04TN4hcO6f4V1D4KwLnjXxa3vM.jpg"
                                     width="600"/>
                                <div class="p-2 flex-grow">
                                    <h2 class="text-center text-[12px] font-bold">
                                        Yanong Agila
                                    </h2>
                                </div>
                                <div class="flex items-center space-x-2 px-2">
                                            <span class="text-gray-700 font-medium text-[9px]">
                                                Members
                                            </span>
                                    <span
                                        class="bg-gray-100 text-gray-700 text-[9px] font-medium px-2 py-0.5 rounded-full">
                                                1.2m
                                            </span>
                                </div>
                                <div class="flex items-center space-x-2 p-2">
                                    <div class="flex -space-x-2">
                                        <img alt="User  avatar 1" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/ZuTpJE6pJfJbppzY8Khmg-vOg6u2WXLzLMgz5_Uoc-0.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 2" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/2pXhDPPK7gfhc2BafGJ_EAzRgUL9U11eKHP90gamIBo.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 3" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/JiBdvOYQiJDmouspoR7oGEmdSCAvmDX0byxIpKTpbik.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 4" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/-M0cg3Rd111OQRFnFY0nwtlNhSBGQiLq6cAOyZpeW5M.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 5" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/gfEX5XQdkQ7irgoTAk4LgYP83FAwCT6UcvkAVb-AG8E.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 6" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/bnKnpUdroN4U_87nsHuEijIHOY0ugMer4RvXvgjQuVg.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 7" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/8y98ymkaXo-zARhuMtYOpHC7dVQksFPl3flWReilCps.jpg"
                                             width="24"/>
                                    </div>
                                    <span class="text-black font-medium text-[10px]">
                                            + 1,164,821
                                        </span>
                                </div>
                            </a>
                        </div>
                        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                            <a href="{{ route('comelec-website.selected-partylist') }}"
                               class="border rounded-lg overflow-hidden shadow-lg h-full flex flex-col transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
                                <img alt="Image of Yanong Agila, a majestic eagle with a sharp gaze and spread wings"
                                     class="w-full h-16 object-cover" height="400"
                                     src="https://storage.googleapis.com/a1aa/image/nCwM01gjm61HpHh9F04TN4hcO6f4V1D4KwLnjXxa3vM.jpg"
                                     width="600"/>
                                <div class="p-2 flex-grow">
                                    <h2 class="text-center text-[12px] font-bold">
                                        Paragon
                                    </h2>
                                </div>
                                <div class="flex items-center space-x-2 px-2">
                                            <span class="text-gray-700 font-medium text-[9px]">
                                                Members
                                            </span>
                                    <span
                                        class="bg-gray-100 text-gray-700 text-[9px] font-medium px-2 py-0.5 rounded-full">
                                                1.2m
                                            </span>
                                </div>
                                <div class="flex items-center space-x-2 p-2">
                                    <div class="flex -space-x-2">
                                        <img alt="User  avatar 1" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/ZuTpJE6pJfJbppzY8Khmg-vOg6u2WXLzLMgz5_Uoc-0.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 2" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/2pXhDPPK7gfhc2BafGJ_EAzRgUL9U11eKHP90gamIBo.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 3" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/JiBdvOYQiJDmouspoR7oGEmdSCAvmDX0byxIpKTpbik.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 4" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/-M0cg3Rd111OQRFnFY0nwtlNhSBGQiLq6cAOyZpeW5M.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 5" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/gfEX5XQdkQ7irgoTAk4LgYP83FAwCT6UcvkAVb-AG8E.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 6" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/bnKnpUdroN4U_87nsHuEijIHOY0ugMer4RvXvgjQuVg.jpg"
                                             width="24"/>
                                        <img alt="User  avatar 7" class="w-6 h-6 rounded-full border-2 border-white"
                                             height="24"
                                             src="https://storage.googleapis.com/a1aa/image/8y98ymkaXo-zARhuMtYOpHC7dVQksFPl3flWReilCps.jpg"
                                             width="24"/>
                                    </div>
                                    <span class="text-black font-medium text-[10px]">+ 1,164,821</span>
                                </div>
                            </a>
                        </div>
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
