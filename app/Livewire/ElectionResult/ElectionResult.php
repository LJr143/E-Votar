<?php

namespace App\Livewire\ElectionResult;

use App\Exports\CandidateExport;
use App\Exports\ElectionResultExport;
use App\Models\AbstainVote;
use App\Models\Candidate;
use App\Models\Council;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ElectionResult extends Component
{
    protected $listeners = ['candidate-created' => '$refresh'];
    public $candidates = [];
    public $filter;
    public $search = '';
    public $selectedElection;
    public $selectedFilter;
    public $elections;
    public $latestElection;
    public $hasStudentCouncilPositions;
    public $hasLocalCouncilPositions;
    public $selectedElectionName;
    public $selectedElectionCampus;

    public $totalVoters;
    public $totalVoterVoted;
    public $councils;

    public $studentCouncilWinners;
    public $localCouncilWinners;
    public $abstainCounts;


    public function mount(): void
    {
        $this->selectedElection = session('selectedElection');
        if ($this->selectedElection){
            $this->filter = Election::with('election_type')
                ->find(($this->selectedElection))
                ->election_type
                ->name;
            $this->fetchElection($this->filter);
            $this->councils = Council::all();
            $this->selectedFilter = $this->filter;
            $this->fetchCandidates();
            $this->fetchWinners();
        }
    }

    public function updatedSearch(): void
    {
        $this->fetchElection($this->filter);
        $this->fetchCandidates();
        $this->fetchWinners();
    }

    public function updatedFilter(): void
    {
        $this->fetchElection($this->filter);
        $this->fetchCandidates();
        $this->fetchWinners();
        $this->dispatch('updateChartData', $this->selectedElection);
    }

    public function updatedSelectedElection(): void
    {
        $election = Election::find($this->selectedElection);
        $this->selectedElectionName = $election?->name;
        $this->selectedElectionCampus = $election?->campus->name;

        $this->fetchElection($this->filter);
        $this->fetchCandidates();
        $this->fetchWinners();
        $this->fetchVoterTally($election->id);
        $this->dispatch('updateChartData', $this->selectedElection);
    }



    public function fetchVoterTally($electionId): void
    {
        if (!$this->selectedElection) {
            $this->totalVoters = 0;
            $this->totalVoterVoted = 0;
            return;
        }

        $election = Election::find($electionId);
        if (!$election) {
            $this->totalVoters = 0;
            $this->totalVoterVoted = 0;
            return;
        }

        try {
            $this->totalVoters = User::where('campus_id', $election->campus_id)
//                ->whereHas('roles', fn($q) => $q->where('name', 'voter'))
                ->whereDoesntHave('electionExcludedVoters', fn($q) => $q->where('election_id', $election->id))
                ->count();

            $this->totalVoterVoted = User::where('campus_id', $election->campus_id)
//                ->whereHas('roles', fn($q) => $q->where('name', 'voter'))
                ->whereDoesntHave('electionExcludedVoters', fn($q) => $q->where('election_id', $election->id))
                ->whereHas('votes', fn($q) => $q->where('election_id', $election->id))
                ->count();

        } catch (\Exception $e) {
            $this->totalVoters = 0;
            $this->totalVoterVoted = 0;
        }
    }

    public function fetchCandidates(): void
    {
        $query = Candidate::with(['users','users.program.council', 'elections', 'election_positions.position.electionType'])
            ->withCount(['votes as votes_count' => function($q) {
                $q->select(DB::raw('COUNT(DISTINCT votes.user_id)'));
            }]);

        if ($this->search) {
            $query->whereHas('users', function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedElection) {
            $query->whereHas('elections', function ($q) {
                $q->where('id', $this->selectedElection);
            });
        }

        if ($this->filter) {
            $query->whereHas('elections.election_type', function ($q) {
                $q->where('name', $this->filter);
            });
        }

        $this->candidates = $query->get();
    }

    public function getVoteTally()
    {
        if (!$this->latestElection) {
            return collect();
        }

        // Get total voters per council
        $councilVoters = User::select('programs.council_id', DB::raw('COUNT(DISTINCT users.id) as voter_count'))
            ->join('programs', 'users.program_id', '=', 'programs.id')
            ->where('users.campus_id', $this->latestElection->campus_id)
            ->whereDoesntHave('electionExcludedVoters', fn($q) => $q->where('election_id', $this->latestElection->id))
            ->groupBy('programs.council_id')
            ->pluck('voter_count', 'council_id');

        $positions = ElectionPosition::with(['position', 'position.electionType'])
            ->where('election_id', $this->latestElection->id)
            ->get();

        $tally = [];

        foreach ($positions as $position) {
            $positionId = $position->position->id;
            $positionName = $position->position->name;
            $electionType = $position->position->electionType->name;

            if ($electionType === 'Student Council Election') {
                // Student Council counts
                $totalVoters = $this->totalVoters;
                $abstainCount = DB::table('abstain_votes')
                    ->where('position_id', $positionId)
                    ->where('election_id', $this->latestElection->id)
                    ->distinct('user_id')
                    ->count('user_id');

                $voteCount = DB::table('votes')
                    ->where('position_id', $positionId)
                    ->where('election_id', $this->latestElection->id)
                    ->distinct('user_id')
                    ->count('user_id');

                $tally[] = [
                    'position_id' => $positionId,
                    'position' => $positionName,
                    'council' => 'All',
                    'total_voters' => $totalVoters,
                    'abstain_count' => $abstainCount,
                    'vote_tally' => $voteCount,
                    'participation_rate' => $totalVoters > 0 ? round(($voteCount / $totalVoters) * 100, 2) : 0
                ];
            } else {
                // Local Council counts
                $councils = Council::where('name', '!=', 'Student Council')->get();

                foreach ($councils as $council) {
                    $totalVoters = $councilVoters[$council->id] ?? 0;

                    $abstainCount = DB::table('abstain_votes')
                        ->join('users', 'abstain_votes.user_id', '=', 'users.id')
                        ->join('programs', 'users.program_id', '=', 'programs.id')
                        ->where('abstain_votes.position_id', $positionId)
                        ->where('abstain_votes.election_id', $this->latestElection->id)
                        ->where('programs.council_id', $council->id)
                        ->distinct('abstain_votes.user_id')
                        ->count('abstain_votes.user_id');

                    $voteCount = DB::table('votes')
                        ->join('users', 'votes.user_id', '=', 'users.id')
                        ->join('programs', 'users.program_id', '=', 'programs.id')
                        ->where('votes.position_id', $positionId)
                        ->where('votes.election_id', $this->latestElection->id)
                        ->where('programs.council_id', $council->id)
                        ->distinct('votes.user_id')
                        ->count('votes.user_id');

                    $tally[] = [
                        'position_id' => $positionId,
                        'position' => $positionName,
                        'council' => $council->name,
                        'total_voters' => $totalVoters,
                        'abstain_count' => $abstainCount,
                        'vote_tally' => $voteCount,
                        'participation_rate' => $totalVoters > 0 ? round(($voteCount / $totalVoters) * 100, 2) : 0
                    ];
                }
            }
        }

        return collect($tally);
    }


    public function fetchElection($filter): void
    {
//        $this->latestElection = Election::with('election_type')
//            ->whereHas('election_type', function ($q) use ($filter) {
//                $q->where('name', $filter);
//            })
//            ->orderBy('created_at', 'desc')
//            ->first();

        $this->latestElection = Election::with('election_type')->find($this->selectedElection);

        $this->selectedElectionName = $this->latestElection ? $this->latestElection->name : null;
        $this->selectedElectionCampus = $this->latestElection ? $this->latestElection->campus : null;

        $this->hasStudentCouncilPositions = false;
        $this->hasLocalCouncilPositions = false;

        if ($this->latestElection) {
            $this->hasStudentCouncilPositions = ElectionPosition::where('election_id', $this->latestElection->id)
                ->whereHas('position.electionType', function ($q) {
                    $q->where('name', 'Student Council Election');
                })
                ->exists();

            $this->hasLocalCouncilPositions = ElectionPosition::where('election_id', $this->latestElection->id)
                ->whereHas('position.electionType', function ($q) {
                    $q->where('name', 'Local Council Election');
                })
                ->exists();

            $this->fetchVoterTally($this->latestElection->id);
        }

        $this->elections = Election::with('election_type')
            ->whereHas('election_type', function ($q) use ($filter) {
                $q->where('name', $filter);
            })
            ->get();
    }

    public function fetchWinners(): void
    {
        if ($this->latestElection) {
            // Fetch winning candidates for Student Council
            $this->studentCouncilWinners = $this->getWinnersByElectionType('Student Council Election');

            // Fetch winning candidates for Local Council, grouped by program
            $this->localCouncilWinners = $this->getWinnersByProgram();
            // Get abstain counts for each position
            $this->abstainCounts = \App\Models\AbstainVote::where('election_id', $this->latestElection->id)
                ->selectRaw('position_id, COUNT(DISTINCT user_id) as count')
                ->groupBy('position_id')
                ->pluck('count', 'position_id');
        } else {
            $this->studentCouncilWinners = collect();
            $this->localCouncilWinners = collect();
            $this->abstainCounts = collect();
        }
    }

    public function getWinnersByElectionType($electionType): array
    {
        $winners = [];

        // Fetch positions for the election type
        $positions = ElectionPosition::where('election_id', $this->latestElection->id)
            ->whereHas('position.electionType', function ($q) use ($electionType) {
                $q->where('name', $electionType);
            })
            ->with('position')
            ->get();

        foreach ($positions as $position) {
            $positionId = $position->position->id;
            $positionName = $position->position->name;
            // Fetch council-specific settings for this position
            $councilPositionSettings = DB::table('council_position_settings')
                ->where('position_id', $position->position->id)
                ->get();

            // Group candidates by council and major (if required)
            $candidatesByCouncil = Candidate::where('election_position_id', $position->id)
                ->with('users.program.council')
                ->withCount('votes')
                ->having('votes_count', '>', 0)
                ->get()
                ->groupBy(function ($candidate) use ($councilPositionSettings) {
                    $councilId = $candidate->users->program->council->id ?? '';
                    if($councilId){
                        $separateByMajor = $councilPositionSettings->where('council_id', $councilId)->first()->separate_by_major ?? false;

                        if ($separateByMajor) {
                            return $councilId . '-' . $candidate->users->major; // Group by council and major
                        } else {
                            return $councilId;
                        }
                    }
                });

            foreach ($candidatesByCouncil as $groupKey => $candidates) {
                // Sort candidates by vote count and take the top N
                $sortedCandidates = $candidates->sortByDesc('votes_count')->take($position->position->num_winners);

                foreach ($sortedCandidates as $candidate) {
                    $winners[] = [
                        'position' => $position->position->name,
                        'position_id' => $positionId,
                        'candidate' => $candidate,
                        'council' => $candidate->users->program->council->name,
                        'major' => $candidate->users->major ?? 'N/A',
                    ];
                }
            }
        }

        return $winners;
    }

    public function getWinnersByProgram(): array
    {
        $winnersByProgram = [];

        // Fetch all programs (councils)
        $programs = Council::all();

        foreach ($programs as $program) {
            // Fetch positions for Local Council Election
            $positions = ElectionPosition::where('election_id', $this->latestElection->id)
                ->whereHas('position.electionType', function ($q) {
                    $q->where('name', 'Local Council Election');
                })
                ->with('position')
                ->get();

            $winners = [];

            foreach ($positions as $position) {
                $positionId = $position->position->id;
                $positionName = $position->position->name;
                // Fetch council-specific settings for this position
                $councilPositionSettings = DB::table('council_position_settings')
                    ->where('position_id', $position->position->id)
                    ->where('council_id', $program->id)
                    ->first();

                // Determine if winners should be separated by major
                $separateByMajor = $councilPositionSettings ? $councilPositionSettings->separate_by_major : false;

                // Fetch the top N candidates for this position within the program
                $query = Candidate::where('election_position_id', $position->id)
                    ->whereHas('users.program.council', function ($q) use ($program) {
                        $q->where('id', $program->id);
                    })
                    ->with('users')
                    ->withCount('votes')
                    ->having('votes_count', '>', 0)
                    ->orderByDesc('votes_count');

                if ($separateByMajor) {
                    // Group candidates by major and select winners for each major
                    $candidatesByMajor = $query->get()->groupBy(function ($candidate) {
                        return $candidate->users->programMajor->name ?? 'No Major'; // Ensure programMajor exists
                    });

                    foreach ($candidatesByMajor as $major => $candidates) {
                        $sortedCandidates = $candidates->sortByDesc('votes_count')->take($position->position->num_winners);

                        foreach ($sortedCandidates as $candidate) {
                            $winners[] = [
                                'position' => $position->position->name,
                                'position_id' => $positionId,
                                'candidate' => $candidate,
                                'major' => $major,
                            ];
                        }
                    }
                } else {
                    // Select winners globally for the council (no separation by major)
                    $candidates = $query->take($position->position->num_winners)->get();

                    foreach ($candidates as $candidate) {
                        $winners[] = [
                            'position' => $position->position->name,
                            'position_id' => $positionId,
                            'candidate' => $candidate,
                            'major' => 'N/A',
                        ];
                    }
                }
            }

            if (!empty($winners)) {
                $winnersByProgram[$program->name] = $winners;
            }
        }

        return $winnersByProgram;
    }

    public function exportElectionResult()
    {
        return Excel::download(new ElectionResultExport($this->search, $this->filter, $this->selectedElection), 'ELECTION_RESULT_' . strtoupper($this->latestElection->name) .'.xlsx');

    }

    public function render()
    {
        $voteTally = $this->getVoteTally();
        return view('evotar.livewire.election-result.election-result', [
            'candidates' => $this->candidates,
            'elections' => $this->elections,
            'selectedElectionName' => $this->selectedElectionName,
            'selectedElectionCampus' => $this->selectedElectionCampus,
            'totalVoters' => $this->totalVoters,
            'totalVoterVoted' => $this->totalVoterVoted,
            'councils' => $this->councils,
            'latestElection' => $this->latestElection,
            'hasStudentCouncilPositions' => $this->hasStudentCouncilPositions,
            'hasLocalCouncilPositions' => $this->hasLocalCouncilPositions,
            'studentCouncilWinners' => $this->studentCouncilWinners,
            'localCouncilWinners' => $this->localCouncilWinners,
            'abstainCounts' => $this->abstainCounts ?? collect(),
            'voteTally' => $voteTally,
        ]);
    }
}
