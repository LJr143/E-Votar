<div>
    <style>
        @keyframes shine {
            to { background-position: 200% center; }
        }
        .pyramid-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        .pyramid-level {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
            width: 100%;
        }
        .candidate-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 140px;
        }
        .photo-frame {
            position: relative;
            border-radius: 50%;
            padding: 3px;
            background: linear-gradient(to right, #D4AF37, #8B0000);
            margin-bottom: 0.75rem;
        }
        .photo-container {
            position: relative;
            border-radius: 50%;
            overflow: hidden;
            width: 120px;
            height: 120px;
        }
        .photo-container.large {
            width: 160px;
            height: 160px;
        }
        .photo-bg {
            position: absolute;
            top: 4px;
            left: 4px;
            right: 4px;
            bottom: 4px;
            border-radius: 50%;
            background: white;
        }
        .candidate-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: relative;
        }
        .position-title {
            text-align: center;
            font-size: 1.25rem;
            font-weight: bold;
            color: #8B0000;
            margin-bottom: 1.5rem;
        }
    </style>

    <div class="min-h-screen font-poppins text-black p-2 sm:p-4 bg-white">
        <div class="container mx-auto max-w-6xl">
            <div class="p-4">
                <!-- Header Section -->
                <div class="mb-6 sm:mb-8 text-center">
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

                <!-- Council Title -->
                <div class="h-0.5 w-36 sm:w-48 mx-auto mb-3 bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent"></div>
                <h1 class="text-center text-gray-800 text-[14px] sm:text-[16px] md:text-[18px] font-medium mb-2">
                    {{ strtoupper($council->name) }}
                </h1>
                <div class="h-px w-24 sm:w-32 mx-auto mb-6 sm:mb-8 bg-gradient-to-r from-transparent via-[#8B0000] to-transparent"></div>

                @if(empty($winners))
                    <p class="text-center">No winners data available.</p>
                @else
                    <!-- Pyramid Layout for Winners -->
                    @foreach($winners as $position => $candidates)
                        @php
                            $isPresident = strtolower($position) === 'president';
                            $isGovernor = strtolower($position) === 'governor';

                            // Create specific pyramid levels
                            $levels = [];
                            $total = count($candidates);

                            // Level 1: 1 candidate
                            if ($total >= 1) {
                                $levels[] = array_slice($candidates, 0, 1);
                            }

                            // Level 2: 3 candidates
                            if ($total >= 2) {
                                $levels[] = array_slice($candidates, 1, 3);
                            }

                            // Level 3: 4 candidates
                            if ($total >= 5) {
                                $levels[] = array_slice($candidates, 4, 4);
                            }

                            // Add remaining candidates if any
                            if ($total > 8) {
                                $levels[] = array_slice($candidates, 8);
                            }
                        @endphp

                        <div class="mb-12">
                            <h2 class="position-title">
                                {{ strtoupper($position) }}
                            </h2>

                            <div class="pyramid-container">
                                @foreach($levels as $levelIndex => $levelCandidates)
                                    <div class="pyramid-level" style="
                                        @if($levelIndex == 0) justify-content: center;
                                        @elseif($levelIndex == 1) justify-content: space-between; padding: 0 10%;
                                        @else justify-content: space-evenly; @endif">
                                        @foreach($levelCandidates as $winner)
                                            <div class="candidate-card">
                                                <div class="photo-frame">
                                                    <div class="photo-container {{ $isPresident || $isGovernor ? 'large' : '' }}">
                                                        <div class="photo-bg"></div>
                                                        <img src="{{ asset($winner->users->profile_photo_path ? 'storage/' . $winner->users->profile_photo_path : 'storage/assets/profile/default.jpg') }}"
                                                             alt="candidate profile"
                                                             class="candidate-photo">
                                                    </div>
                                                </div>
                                                <p class="text-sm sm:text-base font-bold text-center text-black mb-1">
                                                    {{ strtoupper(($winner->users->first_name ?? '') . ' ' . ($winner->users->middle_initial ?? '') . ' ' . ($winner->users->last_name ?? '') . ' ' . ($winner->users->extension ?? '') ?? 'Unknown Candidate') }}
                                                </p>
                                                @if(!$isPresident && !$isGovernor && $winner->users->programMajor)
                                                    <p class="text-xs sm:text-sm text-center text-gray-600">
                                                        {{ strtoupper($winner->users->programMajor->name ?? '') }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
