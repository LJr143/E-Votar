<div class="container mx-auto px-4 py-8" x-data="tabsData()">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"  />
    <!-- TSC Content -->
    <div x-show="activeTab === 'tsc'" x-transition>
        <div class="px-4 md:px-12 pt-8">
            <h1 class="text-center text-gray-800 text-[14px] sm:text-[16px] md:text-[18px] font-bold mb-6 sm:mb-8 uppercase">
                {{ $council->name }} VOTE TALLY</h1>

            <div x-data="tscElectionData()">
                <div class="w-full">
                    <div class="container mx-auto px-4 py-4">
                        <div class="w-full overflow-hidden">
                            @foreach($candidates as $position => $positionCandidates)
                                @php
                                    $firstCandidate = $positionCandidates->first();
                                    $isStudentCouncil = $firstCandidate?->election_positions?->position?->electionType?->name === 'Student Council Election';
                                @endphp

                                @if($positionCandidates->isNotEmpty())

                                    <div class="swiper-container mb-6 overflow-hidden">
                                        <h3 class="text-[14px] font-bold uppercase text-center mb-4">{{ $position }}</h3>

                                        <div class="swiper-wrapper">
                                            @foreach($positionCandidates as $candidate)
                                                <div class="swiper-slide">
                                                    <div wire:key="candidate-{{ $candidate->id }}" class="relative mb-2">
                                                        <div class="flip-card-container mt-[0px]" wire:key="cards-{{ $candidate->id }}">
                                                            <div class="flip-card" onclick="this.classList.toggle('flipped')">
                                                                <!-- Front -->
                                                                <div class="flip-card-front bg-white p-6 shadow-md min-h-[320px]">
                                                                    <p class="text-black font-bold text-[10px] mt-2 uppercase">
                                                                        Votes: {{ $candidate->votes_count }}
                                                                    </p>
                                                                    <div class="flex justify-center items-center">
                                                                        <p class="text-[12px]">
                                                                            Running for:
                                                                            <span class="text-red-900 uppercase tracking-tighter font-semibold">
                                                        {{ $candidate->election_positions?->position?->name }}
                                                    </span>
                                                                        </p>
                                                                    </div>
                                                                    <div>
                                                                        <div class="flex justify-end mt-2 mr-[15px]">
                                                                            <img class="w-[85px]" src="{{ asset('storage/assets/icon/usep_logo_svg.png') }}" alt="">
                                                                        </div>
                                                                        <div class="mt-[-38px] flex justify-center">
                                                                            <div class="border-2 border-black">
                                                                                <img class="w-[110px]" src="{{ asset('storage/assets/profile/default.jpg') }}" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-2 text-center">
                                                                            <div class="flex justify-center">
                                                                                <p class="text-black uppercase font-black text-[11px]">
                                                                                    {{ $candidate->users?->first_name }} {{ $candidate->users?->middle_initial }}. {{ $candidate->users?->last_name }}
                                                                                </p>
                                                                            </div>
                                                                            <p class="text-black capitalize font-semibold text-[10px]">
                                                                                {{ $candidate->users?->year_level }} year
                                                                            </p>
                                                                            <p class="text-black capitalize font-semibold text-[12px] leading-none">
                                                                                @php
                                                                                    $programName = $candidate->users?->program?->name;
                                                                                    $programName = str_starts_with($programName, 'Bachelor of Science')
                                                                                        ? 'BS ' . substr($programName, strlen('Bachelor of Science'))
                                                                                        : $programName;
                                                                                @endphp
                                                                                <span class="program-name !text-[12px]" title="{{ $programName }}">
                                                            {{ $programName }}
                                                        </span>
                                                                            </p>
                                                                            <p class="text-black capitalize font-semibold text-[11px] leading-none">
                                                                                {{ optional($candidate->users?->programMajor)->name ?? '' }}
                                                                            </p>
                                                                            <p class="text-black mt-2 capitalize italic font-semibold text-[11px]">
                                                                                {{ $candidate->partyLists?->name ?? 'Independent' }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Back -->
                                                                <div class="flip-card-back bg-white p-6 shadow-md min-h-[320px] flex items-center justify-center">
                                                                    <div class="text-center p-4">
                                                                        <h3 class="font-bold text-lg mb-2">ADVOCACY</h3>
                                                                        <p class="italic text-sm">{{ $candidate->description ?? 'No motto provided' }}</p>
                                                                        <p class="italic text-xs">-{{ $candidate->users->first_name . ' ' . substr($candidate->users->last_name, 0, 1) . '.' }}</p>
                                                                        <p class="italic text-[10px]">
                                                                            {{ Str::endsWith($position, 'ent') ? Str::replaceLast('ent', 'ential', $position) : $position }} Aspirant.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Swiper Controls -->
                                        <div class="swiper-pagination"></div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function tabsData() {
        return {
            activeTab: 'tsc'
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    window.Swiper = Swiper;

    document.addEventListener('DOMContentLoaded', () => {
        new Swiper('#studentCouncil', {
            slidesPerView: 1,
            spaceBetween: 16,
            grabCursor: true,
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            breakpoints: {
                640: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
        });

        new Swiper('#localCouncil', {
            slidesPerView: 1,
            spaceBetween: 16,
            grabCursor: true,
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            breakpoints: {
                640: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
        });

    });

    document.addEventListener('DOMContentLoaded', function () {
        const swipers = document.querySelectorAll('.swiper-container');

        swipers.forEach(swiperContainer => {
            new Swiper(swiperContainer, {
                slidesPerView: 1,
                spaceBetween: 16,
                grabCursor: true,
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    768: { slidesPerView: 3 },
                    1024: { slidesPerView: 4 },
                },
            });
        });
    });
</script>
