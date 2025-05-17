@php use App\Models\CouncilPositionSetting; @endphp
@php use App\Models\program_major; @endphp
@php use Illuminate\Support\Facades\DB; @endphp

<div class="container mx-auto px-4 py-8" x-data="{
    activeTab: 'results',
    showDetails: false,
    selectedCandidate: null,
    viewCandidateDetails(candidate) {
        this.selectedCandidate = candidate;
        this.showDetails = true;
    }
}">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border border-gray-200">
        <h1 class="text-center text-gray-800 text-2xl font-bold mb-4 uppercase">
            {{ $council->name }} ELECTION RESULTS
        </h1>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                <p class="text-xs font-medium text-indigo-600 uppercase tracking-wider">Total Voters</p>
                <p class="text-2xl font-bold text-indigo-800 mt-1">{{ number_format($totalVoters) }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                <p class="text-xs font-medium text-green-600 uppercase tracking-wider">Voter Turnout</p>
                <p class="text-2xl font-bold text-green-800 mt-1">
                    {{ $totalVoters > 0 ? number_format(($totalVoterVoted/$totalVoters)*100, 1) : 0 }}%
                </p>
                <p class="text-xs text-green-600 mt-1">
                    {{ number_format($totalVoterVoted) }} of {{ number_format($totalVoters) }} voted
                </p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg border border-amber-100">
                <p class="text-xs font-medium text-amber-600 uppercase tracking-wider">Abstention Rate</p>
                <p class="text-2xl font-bold text-amber-800 mt-1">
                    {{ $totalVoters > 0 ? number_format((($totalVoters - $totalVoterVoted)/$totalVoters)*100, 1) : 0 }}%
                </p>
            </div>
        </div>

        <!-- College Turnout -->
        <div class="mt-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">VOTER TURNOUT BY COUNCIL</h3>
            <div class="space-y-3">
                @foreach($collegeTurnout as $college)
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-medium">{{ $college['name'] }}</span>
                            <span>
                                {{ number_format($college['voted']) }} of {{ number_format($college['voters']) }}
                                ({{ $college['voters'] > 0 ? number_format(($college['voted']/$college['voters'])*100, 1) : 0 }}%)
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full"
                                 style="width: {{ $college['voters'] > 0 ? ($college['voted']/$college['voters'])*100 : 0 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Results by Position -->
    <div class="space-y-8">
        @foreach($candidates as $positionName => $positionCandidates)
            @php
                // Get position settings
                $positionId = null;
                $separateByMajor = false;
                $positionWinnersCount = 1;
                $positionAbstainCount = 0;
                $positionTotalVotes = 0;

                if ($positionCandidates->isNotEmpty()) {
                    $positionId = optional(optional($positionCandidates->first())->election_positions)->position->id ?? null;
                    if ($positionId) {
                        $positionSetting = CouncilPositionSetting::where('council_id', $council->id)
                            ->where('position_id', $positionId)
                            ->first();
                        $separateByMajor = $positionSetting && $positionSetting->separate_by_major;

                        // Get position details
                        $position = \App\Models\Position::find($positionId);
                        $positionWinnersCount = $position->num_winners ?? 1;

                        // Calculate total votes for this position
                         $positionTotalVotes = DB::table('votes')
                             ->join('users', 'votes.user_id', '=', 'users.id')
                                    ->join('programs', 'users.program_id', '=', 'programs.id')
                                    ->where('position_id', $positionId)
                                    ->where('votes.election_id', $this->selectedElection)
                                    ->where('programs.council_id', $council->id)
                                    ->distinct('votes.user_id')
                                    ->count('votes.user_id');

                        // Calculate abstain votes
                        $positionAbstainCount = $totalVoterVoted - $positionTotalVotes;
                        // For multiple winners, calculate partial abstentions
                        if ($positionWinnersCount > 1) {
                            $distinctVoters = DB::table('votes')
                              ->join('users', 'votes.user_id', '=', 'users.id')
                                    ->join('programs', 'users.program_id', '=', 'programs.id')
                                    ->where('position_id', $positionId)
                                    ->where('votes.election_id', $this->selectedElection)
                                    ->where('programs.council_id', $council->id)
                                    ->distinct('votes.user_id')
                                    ->count('votes.user_id');

                            $expectedVotes = $distinctVoters * $positionWinnersCount;
                            $partialAbstain = $expectedVotes - $positionTotalVotes;
                            $positionAbstainCount += $partialAbstain;
                        }
                    }
                }
            @endphp

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-black px-4 py-3">
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">
                        {{ $positionName }}
                        @if($separateByMajor)
                            <span class="text-xs text-gray-300">(Voting by Major)</span>
                        @endif
                    </h3>

                    <div class="text-center mb-3">
                    <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded">
                        @if($separateByMajor)
                            Total Abstentions: Calculated per major below
                        @elseif(!$positionWinnersCount > 1)
                            Total Abstentions: {{ number_format($positionAbstainCount) }}
                            ({{ $totalVoterVoted > 0 ? number_format(($positionAbstainCount/$totalVoterVoted)*100, 1) : 0 }}
                            %)
                        @endif
                    </span>
                    </div>
                </div>


                <div class="p-4">
                    @if($separateByMajor && $positionId)
                        <!-- Display results separated by major -->
                        @php
                            // Get all majors that have voters in programs belonging to this council
                            $majors = program_major::whereHas('program', function($query) use ($council) {
                                $query->where('council_id', $council->id);
                            })->get();

                            // Get total voters and votes per major
                            $majorStats = [];
                            foreach ($majors as $major) {
                                $totalMajorVoters = DB::table('users')
                                    ->join('programs', 'users.program_id', '=', 'programs.id')
                                    ->where('programs.council_id', $council->id)
                                    ->where('users.program_id', $major->program_id)
                                    ->where('users.program_major_id', $major->id)
                                    ->count();

                                $totalMajorVoted = DB::table('votes')
                                    ->join('users', 'votes.user_id', '=', 'users.id')
                                    ->join('programs', 'users.program_id', '=', 'programs.id')
                                    ->where('votes.election_id', $this->selectedElection)
                                    ->where('programs.council_id', $council->id)
                                    ->where('users.program_id', $major->program_id)
                                    ->where('users.program_major_id', $major->id)
                                    ->distinct('votes.user_id')
                                    ->count('votes.user_id');

                                // Filter candidates for this major
                                $majorCandidates = $positionCandidates->filter(function($candidate) use ($major) {
                                    return $candidate->users->program_major_id == $major->id;
                                });

                                $majorStats[$major->id] = [
                                    'name' => $major->name,
                                    'total_voters' => $totalMajorVoters,
                                    'total_voted' => $totalMajorVoted,
                                    'candidates' => []
                                ];

                                // Get votes per candidate for this major
                                foreach ($majorCandidates as $candidate) {
                                    $votes = DB::table('votes')
                                        ->join('users', 'votes.user_id', '=', 'users.id')
                                        ->join('programs', 'users.program_id', '=', 'programs.id')
                                        ->where('votes.election_id', $this->selectedElection)
                                        ->where('votes.candidate_id', $candidate->id)
                                        ->where('programs.council_id', $council->id)
                                        ->where('users.program_id', $major->program_id)
                                        ->where('users.program_major_id', $major->id)
                                        ->distinct('votes.user_id')
                                        ->count('votes.user_id');

                                    $majorStats[$major->id]['candidates'][$candidate->id] = [
                                        'votes' => $votes,
                                        'percentage' => $totalMajorVoted > 0 ? ($votes / $totalMajorVoted) * 100 : 0,
                                        'abstain' => $totalMajorVoted - $votes,
                                        'candidate' => $candidate
                                    ];
                                }
                            }
                        @endphp

                        @foreach($majors as $major)
                            @if(isset($majorStats[$major->id]))
                                <div class="mb-8 border-b border-gray-100 pb-6 last:border-0">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-4">
                                        {{ $major->name }} Results
                                        <span class="text-xs text-gray-500">
                        ({{ number_format($majorStats[$major->id]['total_voted']) }} of {{ number_format($majorStats[$major->id]['total_voters']) }} voted)
                    </span>
                                    </h4>

                                    @if(count($majorStats[$major->id]['candidates']) > 0)
                                        <div
                                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                            @foreach($majorStats[$major->id]['candidates'] as $candidateData)
                                                @php
                                                    $candidate = $candidateData['candidate'];
                                                @endphp
                                                <div
                                                    class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                                    <!-- Vote Percentage Bar -->
                                                    <div class="bg-gray-100 w-full h-2">
                                                        <div class="bg-green-500 h-2"
                                                             style="width: {{ $candidateData['percentage'] }}%"></div>
                                                    </div>

                                                    <!-- Candidate Info -->
                                                    <div class="p-4">
                                                        <div class="flex justify-center mb-3">
                                                            <img
                                                                class="w-20 h-20 rounded-full object-cover border-2 border-gray-300"
                                                                src="{{ $candidate->users->profile_photo_path ? asset('storage/'.$candidate->users->profile_photo_path) : asset('storage/assets/profile/default.jpg') }}"
                                                                alt="Candidate photo">
                                                        </div>

                                                        <h4 class="text-center font-bold text-gray-800">
                                                            {{ $candidate->users->first_name }} {{ $candidate->users->last_name }}
                                                        </h4>

                                                        <p class="text-center text-xs text-gray-600 mb-2">
                                                            {{ $candidate->partyLists->name ?? 'Independent' }}
                                                        </p>

                                                        <div class="text-center mb-2">
                                        <span
                                            class="inline-block bg-green-100 text-black font-semibold text-xs px-2 py-1 rounded">
                                            {{ number_format($candidateData['votes']) }} votes
                                            ({{ number_format($candidateData['percentage'], 1) }}%)
                                        </span>
                                                        </div>
                                                        <div class="text-center mb-3">
                                        <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded">
                                            {{ number_format($candidateData['abstain']) }} abstain
                                        </span>
                                                        </div>

                                                        <div class="text-xs mb-3 text-center text-gray-600 space-y-1">
                                                            <p>{{ $candidate->users->year_level }} Year</p>
                                                            <p>{{ $candidate->users->program->short_name ?? $candidate->users->program->name }}</p>
                                                            @if($candidate->users->programMajor)
                                                                <p>{{ $candidate->users->programMajor->name }}</p>
                                                            @endif
                                                        </div>

                                                        @if($candidate->description)
                                                            <div class="border-t border-gray-100 pt-3">
                                                                <p class="text-[11px] font-semibold text-gray-500 text-center mb-1">
                                                                    ADVOCACY</p>
                                                                <p class="text-[10px] text-gray-700 italic text-center">
                                                                    "{{ $candidate->description }}"
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 italic">No candidates from this major</p>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @else
                        <!-- Original display for non-major separated positions -->
                        @php
                            $totalVotes = $positionId ? ($positionVotes[$positionId] ?? 0) : 0;
                            $abstentions = $positionId ? ($positionAbstentions[$positionId] ?? 0) : 0;

                            // Calculate individual candidate votes (distinct counts)
                            $candidateVotes = [];
                            foreach ($positionCandidates as $candidate) {
                                $candidateVotes[$candidate->id] = DB::table('votes')
                                    ->where('candidate_id', $candidate->id)
                                    ->where('election_id', $this->selectedElection)
                                    ->distinct('user_id')
                                    ->count('user_id');
                            }
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach($positionCandidates as $candidate)
                                @php
                                    $candidateVoteCount = $candidateVotes[$candidate->id] ?? 0;
                                    $votePercentage = $totalVoterVoted > 0 ? ($candidateVoteCount/$totalVoterVoted)*100 : 0;
                                    $abstainCountPerCandidate = $totalVoterVoted - $candidateVoteCount;
                                @endphp
                                <div
                                    class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                    <!-- Vote Percentage Bar -->
                                    <div class="bg-gray-100 w-full h-2">
                                        <div class="bg-green-500 h-2" style="width: {{ $votePercentage }}%"></div>
                                    </div>

                                    <!-- Candidate Info -->
                                    <div class="p-4">
                                        <div class="flex justify-center mb-3">
                                            <img class="w-20 h-20 rounded-full object-cover border-2 border-gray-300"
                                                 src="{{ $candidate->users->profile_photo_path ? asset('storage/'.$candidate->users->profile_photo_path) : asset('storage/assets/profile/default.jpg') }}"
                                                 alt="Candidate photo">
                                        </div>

                                        <h4 class="text-center font-bold text-gray-800">
                                            {{ $candidate->users->first_name }} {{ $candidate->users->last_name }}
                                        </h4>

                                        <p class="text-center text-xs text-gray-600 mb-2">
                                            {{ $candidate->partyLists->name ?? 'Independent' }}
                                        </p>

                                        <div class="text-center mb-2">
                                            <span
                                                class="inline-block bg-green-100 text-black font-semibold text-xs px-2 py-1 rounded">
                                                {{ number_format($candidateVoteCount) }} votes
                                                ({{ number_format($votePercentage, 1) }}%)
                                            </span>
                                        </div>

                                        <div class="text-xs mb-3 text-center text-gray-600 space-y-1">
                                            <p>{{ $candidate->users->year_level }} Year</p>
                                            <p>{{ $candidate->users->program->short_name ?? $candidate->users->program->name }}</p>
                                            @if($candidate->users->programMajor)
                                                <p>{{ $candidate->users->programMajor->name }}</p>
                                            @endif
                                        </div>

                                        @if($candidate->description)
                                            <div class="border-t border-gray-100 pt-3">
                                                <p class="text-[11px] font-semibold text-gray-500 text-center mb-1">
                                                    ADVOCACY</p>
                                                <p class="text-[10px] text-gray-700 italic text-center">
                                                    "{{ $candidate->description }}"
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
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
            pagination: {el: '.swiper-pagination', clickable: true},
            navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev'},
            breakpoints: {
                640: {slidesPerView: 2},
                768: {slidesPerView: 3},
                1024: {slidesPerView: 4},
            },
        });

        new Swiper('#localCouncil', {
            slidesPerView: 1,
            spaceBetween: 16,
            grabCursor: true,
            pagination: {el: '.swiper-pagination', clickable: true},
            navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev'},
            breakpoints: {
                640: {slidesPerView: 2},
                768: {slidesPerView: 3},
                1024: {slidesPerView: 4},
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
                pagination: {el: '.swiper-pagination', clickable: true},
                navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev'},
                breakpoints: {
                    640: {slidesPerView: 2},
                    768: {slidesPerView: 3},
                    1024: {slidesPerView: 4},
                },
            });
        });
    });
</script>
