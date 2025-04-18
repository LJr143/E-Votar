<div class="mx-auto  px-4 md:px-12">
    <div class="flex flex-col lg:flex-row">
        <!-- Main Content -->
        <div class="w-full lg:w-3/4 p-4 md:px-0 pt-16 mr-6">
            <div class="mb-10">
                <h1 class="text-[16px] font-semibold mb-4 text-left uppercase">
                    {{ $council->name }}
                </h1>
                <div class="flex flex-col sm:flex-row mb-4">
                    <input wire:model.live="search"
                           class="text-[12px] border border-gray-300 p-2 rounded mb-2 sm:mb-0 sm:mr-2 w-full sm:w-1/3 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Search candidate name"
                           type="text"/>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @if(!empty($candidates) && count($candidates) > 0)
                        @foreach($candidates as $position => $positionCandidates)
                            @if($positionCandidates->isNotEmpty())
                                <div class="slideshow-container">
                                    <p class="text-[11px] text-gray-500 h-8">
                                        Running for <span
                                            class="font-semibold text-red-500">{{ strtoupper($position) }}</span>
                                    </p>
                                    <div class="slideshow"
                                         data-position="{{ str_replace(' ', '-', strtolower($position)) }}">
                                        @foreach($positionCandidates as $index => $candidate)
                                            @php
                                                $user = $candidate->users instanceof \Illuminate\Database\Eloquent\Collection
                                                    ? $candidate->users->first()
                                                    : $candidate->users;
                                            @endphp
                                            <div class=" flip-card-container slide {{ $index === 0 ? 'active' : '' }}">
                                                <div class="flip-card" onclick="this.classList.toggle('flipped')">
                                                    <div class="border relative rounded-lg  shadow-sm flip-card-front ">
                                                        <div class="min-h-[65%] max-h-[65%] w-full bg-red-600 overflow-hidden">
                                                            <img
                                                                alt="{{ $user ? $user->first_name . ' ' . $user->last_name : 'Unknown' }}"
                                                                class="w-full h-full object-contain rounded-t-lg"
                                                                src="{{ asset('storage/' . ($user->profile_photo_path ?? 'assets/logo/tsc-comelec-logo.png')) }}" />
                                                        </div>

                                                        <div class="p-2">
                                                            <p class="mt-2 font-semibold text-[14px]">
                                                                @if ($user)
                                                                    {{ strtoupper(trim(
                                                                        $user->first_name . ' ' .
                                                                        ($user->middle_initial ? $user->middle_initial . '. ' : '') .
                                                                        $user->last_name .
                                                                        ($user->extension ? ' ' . $user->extension : '')
                                                                    )) }}
                                                                @else
                                                                    UNKNOWN
                                                                @endif
                                                            </p>
                                                            <p>
                                                             <span class="font-normal text-[10px] italic">
                                                        {{ $user && $user->program ? $user->program->name : 'N/A' }}
                                                    </span>
                                                            </p>
                                                            <p>
                                                             <span class="font-normal text-[10px] italic">
                                                        {{ $user && $user->programMajor ? $user->programMajor->name : '' }}
                                                    </span>
                                                            </p>
                                                            <p class="text-[11px] text-black italic font-semibold">
                                                                {{ $candidate->partyLists->name . ' Party List' ?? 'Independent' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="flip-card-back bg-white p-6 shadow-md min-h-[320px] flex items-center justify-center">
                                                        <div class="text-center p-4">
                                                            <h3 class="font-bold text-lg mb-2">ADVOCACY</h3>
                                                            <p class="italic text-sm">
                                                                {{ trim($candidate->description ?? '') !== '' ? $candidate->description : 'No motto provided' }}
                                                            </p>
                                                            <p class="italic text-xs">
                                                                -{{ $candidate->users->first_name . ' ' . substr($candidate->users->last_name, 0, 1) . '.'}}</p>
                                                            <p class="italic text-[10px]">
                                                                {{
                                                                    Str::endsWith($candidate->election_positions->position->name, 'ent')
                                                                        ? Str::replaceLast('ent', 'ential', $candidate->election_positions->position->name)
                                                                        : ($candidate->election_positions->position->name === 'Legislator'
                                                                            ? 'Legislative'
                                                                            : $candidate->election_positions->position->name)
                                                                }} Aspirant.
                                                            </p>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($positionCandidates->count() > 1)
                                        <button
                                            class="prev-slide absolute left-0 top-1/2 transform -translate-y-1/2  rounded-full p-2 shadow-lg">
                                            ❮
                                        </button>
                                        <button
                                            class="next-slide absolute right-0 top-1/2 transform -translate-y-1/2  rounded-full p-2 shadow-lg">
                                            ❯
                                        </button>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="col-span-full text-center text-gray-500">
                            No candidates found for this election.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <style>
            .flip-card-container {
                perspective: 1000px;
                min-height: 320px;
            }

            .flip-card {
                position: relative;
                width: 100%;
                height: 100%;
                transition: transform 0.6s;
                transform-style: preserve-3d;
            }

            .flip-card-front, .flip-card-back {
                position: absolute;
                width: 100%;
                height: 100%;
                backface-visibility: hidden;
                -webkit-backface-visibility: hidden;
            }

            .flip-card-back {
                border: 1px solid gray;
                border-radius: 15px;
                transform: rotateY(180deg);
            }

            .flip-card.flipped {
                transform: rotateY(180deg);
            }

            .slideshow-container {
                position: relative;
                width: 100%;
                overflow: hidden;
                border-radius: 12px;
            }

            .slideshow {
                position: relative;
                width: 100%;
                height: 350px;
            }

            .slide {
                position: absolute;
                top: 0;
                left: 50%;
                width: 100%;
                height: 100%;
                opacity: 0;
                transform: translateX(-50%) scale(0.95);
                transition: opacity 1.2s ease-in-out,
                transform 1.2s cubic-bezier(0.4, 0, 0.2, 1);
                pointer-events: none;
                will-change: opacity, transform;
            }

            .slide.active {
                opacity: 1;
                transform: translateX(-50%) scale(1);
                pointer-events: auto;
                z-index: 2;
            }

            .prev-slide,
            .next-slide {
                position: absolute;
                top: 40%;
                transform: translateY(-50%);
                width: 40px;
                height: 40px;
                font-size: 18px;
                color: #ffffff;
                text-align: center;
                line-height: 40px;
                z-index: 3;
                transition: background-color 0.3s ease;
            }

            .prev-slide:hover,
            .next-slide:hover {
                color: black;
            }

            .prev-slide {
                left: 10px;
            }

            .next-slide {
                right: 10px;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const slideshows = document.querySelectorAll('.slideshow');

                slideshows.forEach(slideshow => {
                    const slides = slideshow.querySelectorAll('.slide');
                    const totalSlides = slides.length;
                    let currentIndex = Math.floor(Math.random() * totalSlides); // Random start

                    // Show initial slide
                    slides.forEach(slide => slide.classList.remove('active'));
                    slides[currentIndex].classList.add('active');

                    // Only set up navigation and autoplay if more than one slide
                    if (totalSlides > 1) {
                        const prevButton = slideshow.parentElement.querySelector('.prev-slide');
                        const nextButton = slideshow.parentElement.querySelector('.next-slide');

                        const showSlide = (index) => {
                            slides.forEach(slide => slide.classList.remove('active'));
                            slides[index].classList.add('active');
                        };

                        const nextSlide = () => {
                            currentIndex = (currentIndex + 1) % totalSlides;
                            showSlide(currentIndex);
                        };

                        const prevSlide = () => {
                            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                            showSlide(currentIndex);
                        };

                        // Button event listeners
                        nextButton.addEventListener('click', nextSlide);
                        prevButton.addEventListener('click', prevSlide);

                        // Autoplay
                        setInterval(nextSlide, 5000);
                    }
                });
            });
        </script>
        <!-- Sidebar -->
        <div class="w-full md:w-1/3 lg:w-1/4 p-2 mb-10 md:py-20">
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mb-4">
                <div class="text-black">
                    <livewire:timer.website-selected-organization-timer :selectedElection="$selectedElection"
                                                                        wire:key="timer-election-{{ $selectedElection}}"/>
                    <a href="{{ route('voter.election.redirect') }}">
                        <button class="bg-black hover:bg-gray-600 text-white py-2 mt-2 px-6 rounded text-[12px] w-full">
                            Vote now
                        </button>
                    </a>
                </div>
            </div>
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md text-left">
                <img src="{{ asset('storage/' . $election->image_path) }}" alt="election-image">
            </div>


        </div>
    </div>
</div>

