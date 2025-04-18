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

               <livewire:announcement.announcement-carousel/>
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

                    <div class="container mx-auto px-4 py-8">
                        <!-- Partylist Grid -->
                        @if(!$partyLists)
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900">No partylists found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your  filter to find what you're looking for.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                @foreach($partyLists as $partylist)
                                    <div wire:key="partylist-{{ $partylist->id }}" class="group">
                                        <a href="{{ route('comelec-website.selected-partylist', $partylist->id) }}"
                                           class="block h-full border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 bg-white group-hover:border-blue-500">
                                            <!-- Partylist Logo -->
                                            <div class="h-32 bg-gray-100 flex items-center justify-center overflow-hidden">
                                                @if($partylist->logo_path)
                                                    <img src="{{ asset('storage/'. $partylist->logo_path) }}"
                                                         alt="{{ $partylist->name }} logo"
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="text-gray-400">
                                                        <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Partylist Info -->
                                            <div class="p-4">
                                                <h3 class="text-[14px] font-semibold text-gray-900 text-center mb-2">{{ $partylist->name }}</h3>

                                                <!-- Member Count -->
                                                <div class="flex items-center justify-between mb-3">
                                                    <span class="text-[12px] text-gray-600">Members</span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[12px] font-medium bg-blue-100 text-blue-800">
                                    {{ $partylist->candidates->count() }} members
                                </span>
                                                </div>

                                                <!-- Member Avatars -->
                                                @if($partylist->candidates->isNotEmpty())
                                                    <div class="flex items-center">
                                                        <div class="flex -space-x-2 overflow-hidden">
                                                            @foreach($partylist->candidates->take(5) as $candidate)
                                                                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
                                                                     src="{{ $candidate->users->profile_photo_url ?? asset('images/default-avatar.jpg') }}"
                                                                     alt="{{ $candidate->users->name ?? 'Candidate' }}">
                                                            @endforeach
                                                        </div>
                                                        @if($partylist->candidates->count() > 5)
                                                            <span class="ml-2 text-xs text-gray-500">
                                            +{{ $partylist->candidates->count() - 5 }} more
                                        </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <p class="text-sm text-gray-500 italic">No members yet</p>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
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
