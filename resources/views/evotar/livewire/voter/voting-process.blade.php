<div class="w-full px-10 h-full"
     x-data="{
        selectedCandidates: {},
        collectVotes() {
            let inputs = document.querySelectorAll('input[name^=selected_candidate]');
            inputs.forEach(input => {
                if (input.value) {
                    this.selectedCandidates[input.name] = input.value;
                }
            });
            return this.selectedCandidates;
        }
     }">

    <div class="mb-4">
        <h2 class="text-center uppercase text-2xl font-bold">{{ $election->election_type->name }}</h2>
        <p class="text-center text-lg font-semibold text-gray-700">
            {{ $currentStage === 'student' ? 'Student Council Candidates' : 'Local Council Candidates' }}
        </p>
        <p class="text-center text-[12px] font-bold text-black tracking-wide">
            @if ($currentStage === 'local')
                @php
                    $council = DB::table('councils')
                                 ->where('program_id', auth()->user()->program->id)
                                 ->first();
                @endphp
                {{ $council ? $council->name : 'No council available' }}
            @endif
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
        @foreach ($positions as $position)
            <!-- Loop for the number of winners (cards) -->
            @for ($i = 1; $i <= $position->num_winners; $i++)
                <div class="border px-0 py-2 rounded-lg w-[310px]">
                    <h3 class="uppercase font-semibold text-center text-[12px]">
                        {{ $position->name }} (Vote {{ $i }})
                    </h3>

                    <div x-data="{
                        activeIndex: 0,
                        candidates: [],
                        total() { return this.candidates.length; },
                        next() { this.activeIndex = (this.activeIndex + 1) % this.total(); },
                        prev() { this.activeIndex = (this.activeIndex - 1 + this.total()) % this.total(); },
                        getCurrentCandidate() { return this.candidates[this.activeIndex] ?? null; },
                        updateCandidates(newCandidates) { this.candidates = newCandidates; },
                        getActiveCandidateId() { return this.getCurrentCandidate()?.id; }
                    }"
                         x-init="updateCandidates({{ $position->candidates->toJson() }})"
                         class="relative flex flex-col items-center justify-center p-4 min-h-[250px]">

                        <!-- Navigation Buttons -->
                        <button @click="prev" class="absolute left-0 p-2 rounded-full">❮</button>
                        <button @click="next" class="absolute right-0 p-2 rounded-full">❯</button>

                        <!-- Candidate Display -->
                        <div x-show="getCurrentCandidate()"
                             class="relative bg-white px-6 py-4 shadow-md min-h-[150px] w-[250px] text-center">

                            <div class="flex justify-end mt-2 mr-[15px]">
                                <img class="w-[85px]" src="{{ asset('storage/assets/icon/usep_logo_svg.png') }}" alt="">
                            </div>

                            <div class="mt-[-38px] flex justify-center">
                                <div class="border-2 border-black">
                                    <img class="w-[110px]"
                                         src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="">
                                </div>
                            </div>

                            <div class="mt-2 text-center">
                                <p class="text-black uppercase font-black text-[11px]"
                                   x-text="getCurrentCandidate()?.users?.first_name + ' ' +
                                      (getCurrentCandidate()?.users?.middle_initial ?? '') + ' ' +
                                      getCurrentCandidate()?.users?.last_name">
                                </p>

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
                                   x-text="getCurrentCandidate()?.party_lists?.name ?? ''">
                                </p>
                            </div>
                        </div>

                        <!-- Hidden Input to Store Active Candidate ID -->
                        <input type="hidden"
                               name="selected_candidate_{{ $position->id }}_{{ $i }}"
                               x-model="getActiveCandidateId()">
                    </div>
                </div>
            @endfor
        @endforeach
    </div>

    <!-- Navigation Buttons -->
    <div class="text-center mt-4 w-full flex justify-between">
        @if ($showProceedButton && $currentStage === 'local')
            <button @click="collectVotes(); $wire.addSelections(selectedCandidates).then(() => { $wire.goBackToStudentCouncilElection(); })"
                    class="text-white px-4 py-2 rounded w-[180px] bg-gray-500">
                Back to Student Council Election
            </button>
        @endif

        @if ($showProceedButton && $currentStage === 'student')
            <button @click="collectVotes(); $wire.addSelections(selectedCandidates).then(() => { $wire.proceedToLocalCouncilElection(); })"
                    class="text-white px-4 py-2 rounded w-[280px] bg-black">
                Proceed to Local Council Election
            </button>
        @else
            <button @click="collectVotes(); $wire.addSelections(selectedCandidates).then(() => { $wire.showSummary(); })"
                    class="text-white px-4 py-2 rounded w-[280px] bg-green-600">
                Submit Vote
            </button>
        @endif
    </div>

    <!-- Summary Modal -->
    <div x-show="$wire.showSummaryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center" x-cloak>
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Vote Summary</h2>
            <ul>
                @foreach ($selectedCandidates as $candidateId)
                    @php
                        $candidate = \App\Models\Candidate::find($candidateId);
                    @endphp
                    @if ($candidate)
                        <li class="mb-2">
                            <strong>{{ optional($candidate->election_positions->position)->name ?? 'Unknown Position' }}:</strong>
                            {{ optional($candidate->users)->first_name ?? 'Unknown' }} {{ optional($candidate->users)->last_name ?? '' }}
                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="mt-4 flex justify-end">
                <button @click="$wire.submitVotes()" class="px-4 py-2 bg-green-600 text-white rounded">
                    Confirm
                </button>
                <button @click="$wire.showSummaryModal = false" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
