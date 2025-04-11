<div class="w-full px-10 min-h-screen"
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
        <h2 class="text-center uppercase text-[18px] font-bold">{{ $election->name }}</h2>
        <p class="text-center text-[16px] font-semibold text-gray-700">
            {{ $currentStage === 'student' ? 'STUDENT COUNCIL CANDIDATES' : 'LOCAL COUNCIL CANDIDATES' }}
        </p>
        <p class="text-center text-[12px] font-bold text-black tracking-wide uppercase">
            @if ($currentStage === 'student')
                {{ auth()->user()->campus->name . " student council" }}
            @endif
        </p>
        <p class="text-center text-[12px] font-bold text-black tracking-wide uppercase">
            @if ($currentStage === 'local')
                @php
                    $council = DB::table('councils')
                                 ->where('id', auth()->user()->program->council_id)
                                 ->first();
                @endphp
                {{ $council ? $council->name : 'No council available' }}
            @endif
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
        @foreach ($positions as $position)
            @for ($i = 1; $i <= $position->num_winners; $i++)
                <div class="border px-2 py-2 rounded-lg w-[310px]">
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
                         class="relative flex flex-col items-center justify-center p-4 min-h-[250px] overflow-hidden">

                        <!-- Navigation Buttons -->
                        <button @click="prev"
                                class="absolute left-0 p-2 rounded bg-gray-800 hover:bg-gray-800 text-black hover:text-white z-10">
                            ❮
                        </button>
                        <button @click="next"
                                class="absolute right-0 p-2 bg-gray-800 rounded hover:bg-gray-800 text-black hover:text-white z-10">
                            ❯
                        </button>

                        <!-- Candidate Display with Smooth Slide Effect -->
                        <div class="relative w-[250px] h-[290px] overflow-hidden">
                            <template x-for="(candidate, index) in candidates" :key="candidate.id">
                                <div class="absolute inset-0 transition-transform ease-in-out duration-500"
                                     :style="'transform: translateX(' + ((index - activeIndex) * 100) + '%);'">

                                    <div
                                        class="relative bg-white px-6 py-4 min-h-[150px] w-[250px] text-center rounded-lg">
                                        <div class="flex justify-end mt-2 mr-[15px]">
                                            <img class="w-[85px]"
                                                 src="{{ asset('storage/assets/icon/usep_logo_svg.png') }}" alt="">
                                        </div>

                                        <div class="mt-[-38px] flex justify-center">
                                            <div class="border-2 border-black">
                                                <img class="w-[110px]"
                                                     src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="">
                                            </div>
                                        </div>

                                        <div class="mt-2 text-center">
                                            <p class="text-black uppercase font-black text-[11px]"
                                               x-text="candidate.users?.first_name + ' ' +
                                                  (candidate.users?.middle_initial ?? '') + ' ' +
                                                  candidate.users?.last_name">
                                            </p>

                                            <p class="text-black capitalize font-semibold text-[10px]"
                                               x-text="candidate.users?.year_level + ' year'">
                                            </p>

                                            <p class="text-black capitalize font-semibold text-[12px] leading-none">
                                            <span class="program-name !text-[12px]"
                                                  x-text="candidate.users?.program?.name">
                                            </span>
                                            </p>

                                            <p class="text-black capitalize font-semibold text-[11px] leading-none"
                                               x-text="candidate.users?.program_major?.name ?? ''">
                                            </p>

                                            <p class="text-black mt-2 capitalize italic font-semibold text-[11px]"
                                               x-text="candidate.party_lists?.name ?? ''">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </template>
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
    <div class="text-center mt-4 mb-4 w-full flex justify-end items-end">
        @if ($showProceedButton && $currentStage === 'local')
            <div x-data="{ loading: false }">
                <button
                    @click="loading = true; collectVotes();
            $wire.addSelections(selectedCandidates)
            .then(() => $wire.goBackToStudentCouncilElection())
            .catch(() => { /* Handle error here */ })
            .finally(() => loading = false);"
                    x-bind:disabled="loading"
                    class="text-white text-[12px] px-4 py-2 mb-4 rounded w-[220px] bg-gray-500 flex items-center justify-center">

                    <span x-show="!loading">Back to Student Council Election</span>
                    <span x-show="loading"
                          class="animate-spin border-2 border-white border-t-transparent rounded-full w-5 h-5 ml-2"></span>
                </button>
            </div>

        @endif

        <div x-data="{ loading: false }" class=" w-full flex justify-end items-end">
            @if ($showProceedButton && $currentStage === 'student')
                <button
                    @click="loading = true; collectVotes();
            $wire.addSelections(selectedCandidates)
            .then(() => $wire.proceedToLocalCouncilElection())
            .catch(() => { /* Handle error here */ })
            .finally(() => loading = false);"
                    x-bind:disabled="loading"
                    class="text-white px-4 py-2 text-[12px] mb-4 rounded w-[280px] bg-black flex items-center justify-center">

                    <span x-show="!loading">Proceed to Local Council Election</span>
                    <span x-show="loading"
                          class="animate-spin border-2 border-white border-t-transparent rounded-full hover:bg-gray-700 w-5 h-5 ml-2"></span>
                </button>
            @else
                <button
                    @click="loading = true; collectVotes();
            $wire.addSelections(selectedCandidates)
            .then(() => $wire.showSummary())
            .catch(() => { /* Handle error here */ })
            .finally(() => loading = false);"
                    x-bind:disabled="loading"
                    class="text-white px-4 py-2 text-[12px] mb-4 rounded w-[280px] bg-green-600 flex items-center justify-center">

                    <span x-show="!loading">Submit Vote</span>
                    <span x-show="loading"
                          class="animate-spin border-2 border-white border-t-transparent rounded-full w-5 h-5 ml-2"></span>
                </button>
            @endif
        </div>


    </div>

    <!-- Duplicate Error Modal -->
    <div x-show="$wire.showDuplicateErrorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Duplicate Votes Detected</h2>
            <p class="text-red-600 mb-4" x-text="$wire.duplicateError"></p>
            <div class="flex justify-end">
                <button @click="$wire.showDuplicateErrorModal = false" class="px-4 py-2 bg-gray-500 text-white rounded">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Modal -->
    <div x-show="$wire.showSummaryModal"
         class="fixed inset-0 bg-black flex items-center justify-center z-50"
         x-cloak
         style="background-image: url('{{ asset('storage/assets/image/bg-image-voted.png') }}'); background-size: contain"
    >
        <div class="bg-white p-6 rounded w-[630px] flex flex-col justify-center items-center">
            <h2 class="text-[18px] font-bold mb-2 text-center uppercase">University of Southeastern Philippines
                Tagum-Unit</h2>
            <div class="flex justify-between items-center mb-1 w-1/2">
                <img src="{{ asset('storage/assets/logo/usep_logo.jpg') }}" class="w-[45px]" alt="usep-logo">
                <h2 class="text-[16px] font-black text-center uppercase">Summary of Votes</h2>
                <img src="{{ asset('storage/assets/logo/usg_logo.png') }}" class="w-[45px]" alt="usg-logo">
            </div>

            <div>
                <h2 class="text-[14px] font-normal mb-2 text-center uppercase">COMMISSION ON ELECTIONS</h2>
            </div>

            @php
                use App\Models\Candidate;
                use App\Models\ElectionPosition;
                use App\Models\Position;

                // Fetch all election positions along with position details
                $allPositions = ElectionPosition::with('position')->where('election_id', $election->id)->get();

                // Separate positions by election type
                $studentCouncilPositions = $allPositions->filter(function ($ep) {
                    return optional($ep->position->electionType)->name === 'Student Council Election';
                });

                $localCouncilPositions = $allPositions->filter(function ($ep) {
                    return optional($ep->position->electionType)->name === 'Local Council Election';
                });

                $studentCouncilVotes = [];
                $localCouncilVotes = [];

                foreach ($selectedCandidates as $key => $candidateId) {
                    // Extract position ID from the key
                    $positionId = explode('_', str_replace('selected_candidate_', '', $key))[0];

                    $candidate = Candidate::with('users', 'election_positions.position')->find($candidateId);
                    if ($candidate) {
                        $type = optional($candidate->election_positions->position->electionType)->name;

                        if ($type === 'Student Council Election') {
                            $studentCouncilVotes[$positionId][] = $candidate; // Store array of candidates per position
                        } else {
                            $localCouncilVotes[$positionId][] = $candidate;
                        }
                    }
                }
            @endphp

                <!-- Student Council Candidates -->
            <div class="w-full">
                @if(!empty($studentCouncilVotes))
                    <h3 class="text-[14px] font-bold text-center mt-2 mb-4">TAGUM STUDENT COUNCIL</h3>
                @endif
                <div class="text-left w-full px-12">
                    <ul class="mb-4">
                        @foreach ($studentCouncilPositions as $electionPosition)
                            @php
                                $positionId = $electionPosition->position_id;
                                $votes = $studentCouncilVotes[$positionId] ?? [];
                            @endphp
                            <li class="mb-2">
                                <div class="flex justify-between">
                                    <p class="font-semibold">{{ optional($electionPosition->position)->name ?? 'Unknown Position' }}:</p>
                                    @forelse ($votes as $vote)
                                        <div class="ml-4 flex">
                                            {{ $vote->users->first_name }} {{ $vote->users->last_name }}
                                        </div>
                                    @empty
                                        <span class="text-gray-500 ml-4">No candidates selected</span>
                                    @endforelse
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- Local Council Candidates -->
            <div class="w-full">
                @if(!empty($localCouncilVotes))
                    <h3 class="text-[14px] font-bold text-center mt-2 mb-4 uppercase">
                        {{ $council->name ?? 'No council available' }}
                    </h3>
                @endif
                <div class="text-left w-full px-12">
                    <ul class="mb-4">
                        @foreach ($localCouncilPositions as $electionPosition)
                            @php
                                $positionId = $electionPosition->position_id;
                                $votes = $localCouncilVotes[$positionId] ?? [];
                            @endphp
                            <li class="mb-2">
                                <div class="flex justify-between">
                                    <p class="font-semibold w-1/3">
                                        {{ optional($electionPosition->position)->name ?? 'Unknown Position' }}:
                                    </p>
                                    <div class="flex flex-col items-end w-2/3 space-y-1">
                                        @forelse ($votes as $vote)
                                            <div class="text-right">
                                                {{ $vote->users->first_name }} {{ $vote->users->last_name }}
                                            </div>
                                        @empty
                                            <span class="text-gray-500">No candidates selected</span>
                                        @endforelse
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div>
                <div class="mt-4 flex justify-end">
                    <button @click="$wire.submitVotes()" class="px-4 py-2 text-[12px] bg-green-600 text-white rounded">
                        Confirm
                    </button>
                    <button @click="$wire.showSummaryModal = false"
                            class="ml-2 px-4 py-2 text-[12px] bg-gray-500 text-white rounded">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>
