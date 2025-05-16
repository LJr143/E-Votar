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
        \Log::debug('fetchVoterTally triggered', [
            'selectedElection' => $this->selectedElection,
            'previousVoters' => $this->totalVoters,
            'previousVoted' => $this->totalVoterVoted
        ]);

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

            \Log::debug('Voter tally updated', [
                'totalVoters' => $this->totalVoters,
                'totalVoterVoted' => $this->totalVoterVoted
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to fetch voter tally', ['error' => $e->getMessage()]);
            $this->totalVoters = 0;
            $this->totalVoterVoted = 0;
        }
    }

    public function fetchCandidates(): void
    {
        $query = Candidate::with(['users','users.program.council', 'elections', 'election_positions.position.electionType'])
            ->withCount(['votes as votes_count' => function($q) {
                $q->select(DB::raw('COUNT(DISTINCT user_id)'));
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

        // Get all voters who participated
        $votedUsers = DB::table('votes')
            ->where('election_id', $this->latestElection->id)
            ->distinct('user_id')
            ->pluck('user_id');

        $positions = ElectionPosition::with('position')
            ->where('election_id', $this->latestElection->id)
            ->get();

        $tally = [];

        foreach ($positions as $position) {
            $positionId = $position->position->id;

            // Count UNIQUE voters per position
            $totalVotes = DB::table('votes')
                ->where('position_id', $positionId)
                ->where('election_id', $this->latestElection->id)
                ->distinct('user_id')
                ->count('user_id');

            // Count UNIQUE abstentions per position
            $abstainCount = DB::table('abstain_votes')
                ->where('position_id', $positionId)
                ->where('election_id', $this->latestElection->id)
                ->distinct('user_id')
                ->count('user_id');

            $tally[] = [
                'position_id' => $positionId,
                'position' => $position->position->name,
                'total_votes' => $totalVotes,
                'abstain_count' => $abstainCount,
                'total_participation' => $totalVotes + $abstainCount
            ];
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
