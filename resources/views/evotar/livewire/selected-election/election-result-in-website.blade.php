<div>
    <style>
        @keyframes shine {
            to { background-position: 200% center; }
        }
        .org-chart {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin-bottom: 2rem;
        }
        .org-level {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 1.5rem;
        }
        .org-node {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            margin: 0 1.5rem;
        }
        .org-node.leader {
            margin-bottom: 2.5rem;
        }
        .org-node::after {
            content: '';
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 25px;
            background: #8B0000;
        }
        .org-node.leader::after {
            display: none;
        }
        .org-children {
            display: flex;
            justify-content: center;
            position: relative;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        .org-children::before {
            content: '';
            position: absolute;
            top: -25px;
            left: 50%;
            right: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 2px;
            background: #8B0000;
        }
        .photo-frame {
            position: relative;
            border-radius: 50%;
            padding: 3px;
            background: linear-gradient(to right, #D4AF37, #8B0000);
            margin-bottom: 0.75rem;
            z-index: 1;
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
        .position-title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #8B0000;
            margin-bottom: 2rem;
            text-transform: uppercase;
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
                    <!-- Organizational Chart Layout -->
                    @foreach($winners as $position => $candidates)
                        @php
                            $isPresident = strtolower($position) === 'president';
                            $isGovernor = strtolower($position) === 'governor';

                            // Get the leader (first candidate)
                            $leader = $candidates[0] ?? null;
                            // Get next 3 as executives
                            $executives = array_slice($candidates, 1, 3);
                            // Get remaining as members
                            $members = array_slice($candidates, 4);
                        @endphp

                        <div class="mb-16">
                            <h2 class="position-title">
                                {{ strtoupper($position) }}
                            </h2>

                            <div class="org-chart">
                                @if($leader)
                                    <!-- Leader Level -->
                                    <div class="org-level">
                                        <div class="org-node leader">
                                            <div class="photo-frame">
                                                <div class="photo-container {{ $isPresident || $isGovernor ? 'large' : '' }}">
                                                    <div class="photo-bg"></div>
                                                    <img src="{{ asset($leader->users->profile_photo_path ? 'storage/' . $leader->users->profile_photo_path : 'storage/assets/profile/default.jpg') }}"
                                                         alt="leader profile"
                                                         class="w-full h-full object-cover relative">
                                                </div>
                                            </div>
                                            <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">
                                                {{ strtoupper(($leader->users->first_name ?? '') . ' ' . ($leader->users->middle_initial ?? '') . ' ' . ($leader->users->last_name ?? '') . ' ' . ($leader->users->extension ?? '') ?? 'Unknown Candidate') }}
                                            </p>
                                            <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">
                                                LEADER
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if(count($executives) > 0)
                                    <!-- Executives Level -->
                                    <div class="org-level">
                                        <div class="org-children">
                                            @foreach($executives as $executive)
                                                <div class="org-node">
                                                    <div class="photo-frame">
                                                        <div class="photo-container">
                                                            <div class="photo-bg"></div>
                                                            <img src="{{ asset($executive->users->profile_photo_path ? 'storage/' . $executive->users->profile_photo_path : 'storage/assets/profile/default.jpg') }}"
                                                                 alt="executive profile"
                                                                 class="w-full h-full object-cover relative">
                                                        </div>
                                                    </div>
                                                    <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">
                                                        {{ strtoupper(($executive->users->first_name ?? '') . ' ' . ($executive->users->middle_initial ?? '') . ' ' . ($executive->users->last_name ?? '') . ' ' . ($executive->users->extension ?? '') ?? 'Unknown Candidate') }}
                                                    </p>
                                                    <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">
                                                        EXECUTIVE
                                                        @if(!$isPresident && !$isGovernor && $executive->users->programMajor)
                                                            - {{ strtoupper($executive->users->programMajor->name ?? '') }}
                                                        @endif
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if(count($members) > 0)
                                    <!-- Members Level -->
                                    <div class="org-level">
                                        <div class="org-children">
                                            @foreach($members as $member)
                                                <div class="org-node">
                                                    <div class="photo-frame">
                                                        <div class="photo-container">
                                                            <div class="photo-bg"></div>
                                                            <img src="{{ asset($member->users->profile_photo_path ? 'storage/' . $member->users->profile_photo_path : 'storage/assets/profile/default.jpg') }}"
                                                                 alt="member profile"
                                                                 class="w-full h-full object-cover relative">
                                                        </div>
                                                    </div>
                                                    <p class="text-[12px] sm:text-[14px] font-bold text-center text-black">
                                                        {{ strtoupper(($member->users->first_name ?? '') . ' ' . ($member->users->middle_initial ?? '') . ' ' . ($member->users->last_name ?? '') . ' ' . ($member->users->extension ?? '') ?? 'Unknown Candidate') }}
                                                    </p>
                                                    <p class="text-[#8B0000] text-[11px] sm:text-[12px] font-semibold text-center tracking-wider">
                                                        MEMBER
                                                        @if(!$isPresident && !$isGovernor && $member->users->programMajor)
                                                            - {{ strtoupper($member->users->programMajor->name ?? '') }}
                                                        @endif
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
