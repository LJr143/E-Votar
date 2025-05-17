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
                        @if($election->hasEnded())
                            <h2 class="text-center text-2xl sm:text-3xl md:text-4xl font-bold mb-2" style="background-size: 200% auto; -webkit-background-clip: text; background-clip: text; color: transparent; text-shadow: 0px 2px 4px rgba(0,0,0,0.1); background-image: linear-gradient(to right, #D4AF37, #8B0000, #D4AF37); animation: shine 2s linear infinite;">
                                CONGRATULATIONS
                            </h2>
                            <p class="text-gray-700 text-sm sm:text-base">
                                To the newly elected {{ $council->name }} officers
                            </p>
                        @elseif($election->status == 'ongoing')
                            <h2 class="text-center text-2xl sm:text-3xl md:text-4xl font-bold mb-2" style="background-size: 200% auto; -webkit-background-clip: text; background-clip: text; color: transparent; text-shadow: 0px 2px 4px rgba(0,0,0,0.1); background-image: linear-gradient(to right, #D4AF37, #8B0000, #D4AF37); animation: shine 2s linear infinite;">
                                ELECTION IS ONGOING
                            </h2>
                            <p class="text-gray-700 text-sm sm:text-base">
                                The Results are only available right after the election ends.
                            </p>
                        @else
                            <h2 class="text-center text-2xl sm:text-3xl md:text-4xl font-bold mb-2" style="background-size: 200% auto; -webkit-background-clip: text; background-clip: text; color: transparent; text-shadow: 0px 2px 4px rgba(0,0,0,0.1); background-image: linear-gradient(to right, #D4AF37, #8B0000, #D4AF37); animation: shine 2s linear infinite;">
                                ELECTION HAS NOT YET STARTED
                            </h2>
                            <p class="text-gray-700 text-sm sm:text-base">
                                The Results are only available right after the election ends.
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Title + Subtitle -->
                <div class="h-0.5 w-36 sm:w-48 mx-auto mb-3 bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent"></div>
                <h1 class="text-center text-gray-800 text-[14px] sm:text-[16px] md:text-[18px] font-medium mb-2">
                    {{ strtoupper($council->name) }}
                </h1>
                <div class="h-px w-24 sm:w-32 mx-auto mb-6 sm:mb-8 bg-gradient-to-r from-transparent via-[#8B0000] to-transparent"></div>

                <!-- Winners Display -->
                @if(empty($winners))
                    <p class="text-center">No winners data available.</p>
                @else
                    @php
                        $positions = array_keys($winners);
                        $chunks = array_chunk($positions, 3); // display 3 positions per row
                    @endphp

                    @foreach($chunks as $chunk)
                        <div class="flex justify-center gap-8 flex-wrap mb-10">
                            @foreach($chunk as $position)
                                @foreach($winners[$position] as $winner)
                                    <div class="flex flex-col items-center w-[160px]">
                                        <div class="relative rounded-full p-[3px] bg-gradient-to-r from-[#D4AF37] to-[#8B0000] mb-3">
                                            <div class="relative rounded-full overflow-hidden w-[120px] h-[120px]">
                                                <div class="absolute top-1 left-1 right-1 bottom-1 rounded-full bg-white"></div>
                                                <img src="{{ asset($winner->users->profile_photo_path ? 'storage/' . $winner->users->profile_photo_path : 'storage/assets/profile/default.jpg') }}"
                                                     alt="candidate profile"
                                                     class="w-full h-full object-cover relative">
                                            </div>
                                        </div>
                                        <p class="text-[13px] font-bold text-center text-black leading-tight">
                                            {{ strtoupper(($winner->users->first_name ?? '') . ' ' . ($winner->users->middle_initial ?? '') . ' ' . ($winner->users->last_name ?? '') . ' ' . ($winner->users->extension ?? '')) }}
                                        </p>
                                        <p class="text-[12px] text-gray-500 text-center">
                                            {{ strtoupper($position) }}
                                            @if($winner->users->programMajor)
                                                - {{ strtoupper($winner->users->programMajor->name) }}
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
