<div class="w-full px-10">
    <div class="mb-4">
        <h2 class="text-center uppercase text-2xl font-bold">{{ $election->election_type->name }}</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
        @foreach ($positionsWithCandidates as $position)
            <div class="border px-0 py-2 rounded-lg w-[310px]">
                <h3 class="uppercase font-semibold text-center text-[12px]">{{ $position->name }}</h3>

                <div x-data="{
                        activeIndex: 0,
                        candidates: {{ $position->electionPositions->flatMap->candidates->toJson() }},
                        total() { return this.candidates.length; },
                        next() { this.activeIndex = (this.activeIndex + 1) % this.total(); },
                        prev() { this.activeIndex = (this.activeIndex - 1 + this.total()) % this.total(); },
                        getCurrentCandidate() { return this.candidates[this.activeIndex] ?? null; }
                    }"
                     class="relative flex flex-col items-center justify-center p-4">

                    <!-- Previous Button -->
                    <button @click="prev" class="absolute left-0 p-2 rounded-full">
                        ❮
                    </button>

                    <!-- Candidate Display -->
                    <div x-show="getCurrentCandidate()"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform translate-x-4"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform translate-x-0"
                         x-transition:leave-end="opacity-0 transform -translate-x-4"
                         class="relative bg-white px-6 py-4 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] min-h-full w-[250px] text-center">

                        <!-- Logo Positioning -->
                        <div class="flex justify-end mt-2 mr-[15px]">
                            <img class="w-[85px]" src="{{ asset('storage/assets/icon/usep_logo_svg.png') }}" alt="">
                        </div>

                        <!-- Candidate Image -->
                        <div class="mt-[-38px] flex justify-center">
                            <div class="border-2 border-black">
                                <img class="w-[110px]"
                                     src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="">
                            </div>
                        </div>

                        <!-- Candidate Details -->
                        <div class="mt-2 text-center">
                            <div class="flex justify-center">
                                <p class="text-black uppercase font-black text-[11px]"
                                   x-text="getCurrentCandidate()?.users?.first_name + ' ' +
                       (getCurrentCandidate()?.users?.middle_initial ?? '') + ' ' +
                       getCurrentCandidate()?.users?.last_name">
                                </p>
                            </div>

                            <p class="text-black capitalize font-semibold text-[10px]"
                               x-text="getCurrentCandidate()?.users?.year_level + ' year'">
                            </p>

                            <p class="text-black capitalize font-semibold text-[12px] leading-none">
                                <span class="program-name !text-[12px]"
                                      x-text="getCurrentCandidate()?.users?.program?.name">
                                </span>
                            </p>

                            <p class="text-black capitalize font-semibold text-[11px] leading-none"
                               x-text="getCurrentCandidate()?.users?.program_major?.name ?? ''">
                            </p>

                            <p class="text-black mt-2 capitalize italic font-semibold text-[11px]"
                               x-text="getCurrentCandidate()?.party_lists?.name ?? 'Independent'">
                            </p>
                        </div>
                    </div>

                    <!-- Next Button -->
                    <button @click="next" class="absolute right-0 p-2 rounded-full">
                        ❯
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Vote Button (Outside the Loop) -->
    <div class="text-center mt-4">
        <button @click="$wire.vote(getCurrentCandidate()?.id)"
                class="bg-blue-500 text-white px-4 py-2 rounded w-full">
            Vote
        </button>
    </div>
</div>
