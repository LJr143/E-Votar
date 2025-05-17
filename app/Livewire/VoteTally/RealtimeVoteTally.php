<?php

namespace App\Livewire\VoteTally;

use App\Exports\ElectionsExport;
use App\Exports\VoteTallyExport;
use App\Models\Candidate;
use App\Models\Council;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RealtimeVoteTally extends Component
{
    protected $listeners = ['updateChartData' => '$refresh', 'echo:vote-tally,VoteTallyUpdated' => '$refresh'];
    public $council;
    public $councilId;
    public $positionsWithCandidates = [];
    public $studentCouncilPositions = [];
    public $localCouncilPositions = [];
    public $filter;
    public $selectedElection;
    public $councils;
    public $search = '';

    // Statistics properties
    public $totalVoters;
    public $totalVoterVoted;
    public $totalAbstentions;
    public $collegeTurnout = [];
    public $positionVotes = [];
    public $positionAbstentions = [];

    public function mount($councilId)
    {
        $this->councilId = $councilId;
        $this->council = Council::find($councilId);
        $selectedElectionId = session('selectedElectionWeb');

        if ($selectedElectionId) {
            $election = Election::with('election_type')->find($selectedElectionId);

            if ($election) {
                $this->filter = $election->election_type->name;
                $this->selectedElection = $selectedElectionId;
                $this->loadStatisticsData($election);
            }
        }

        $this->councils = Council::all();

        if ($this->selectedElection) {
            $this->loadPositionData();
        }
    }

    protected function loadStatisticsData(Election $election)
    {
        // Base query for eligible voters
        $baseVoterQuery = User::whereHas('roles', function($q) {
            $q->where('name', '!=', 'faculty');
        })
            ->when(!str($this->council->name)->contains('Student Council'), function($query) {
                $query->whereHas('program', function($q) {
                    $q->where('council_id', $this->council->id);
                });
            })
            ->whereDoesntHave('electionExcludedVoters', function($q) {
                $q->where('election_id', $this->selectedElection);
            });

        // Total voters count
        $this->totalVoters = $baseVoterQuery->count();

        // Total voters who voted (distinct count)
        $this->totalVoterVoted = DB::table('votes')
            ->join('users', 'votes.user_id', '=', 'users.id')
            ->when(!str($this->council->name)->contains('Student Council'), function($query) {
                $query->join('programs', 'users.program_id', '=', 'programs.id')
                    ->where('programs.council_id', $this->council->id);
            })
            ->where('votes.election_id', $this->selectedElection)
            ->distinct('votes.user_id')
            ->count('votes.user_id');

        // College-wise turnout
        $this->collegeTurnout = Council::withCount([
            'program as voters_count' => function($query) {
                $query->select(DB::raw('count(distinct users.id)'))
                    ->join('users', 'programs.id', '=', 'users.program_id')
                    ->whereHas('users.roles', function($q) {
                        $q->where('name', '!=', 'faculty');
                    })
                    ->whereDoesntHave('users.electionExcludedVoters', function($q) {
                        $q->where('election_id', $this->selectedElection);
                    });
            },
            'program as voted_count' => function($query) {
                $query->select(DB::raw('count(distinct votes.user_id)'))
                    ->join('users', 'programs.id', '=', 'users.program_id')
                    ->join('votes', 'users.id', '=', 'votes.user_id')
                    ->where('votes.election_id', $this->selectedElection);
            }
        ])
            ->when(str($this->council->name)->contains('Student Council'), function($query) {
                // Show all councils for Student Council view
            }, function($query) {
                // Only show current council for other views
                $query->where('id', $this->council->id);
            })
            ->get()
            ->map(function($council) {
                return [
                    'name' => $council->name,
                    'voters' => $council->voters_count,
                    'voted' => $council->voted_count,
                    'turnout' => $council->voters_count > 0
                        ? round(($council->voted_count / $council->voters_count) * 100, 1)
                        : 0
                ];
            });

        // Calculate position votes using exact specified method
        $positions = ElectionPosition::where('election_id', $this->selectedElection)
            ->with('position')
            ->get();

        foreach ($positions as $position) {
            $this->positionVotes[$position->position_id] = DB::table('votes')
                ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
                ->join('users', 'candidates.user_id', '=', 'users.id')
                ->join('programs', 'users.program_id', '=', 'programs.id')
                ->where('candidates.election_position_id', $position->id)
                ->where('votes.election_id', $this->selectedElection)
                ->when(!str($this->council->name)->contains('Student Council'), function($query) {
                    $query->where('programs.council_id', $this->council->id);
                })
                ->distinct('votes.user_id')
                ->count('votes.user_id');

            // Calculate abstentions for this position
            $this->positionAbstentions[$position->position_id] = max(
                0,
                $this->totalVoterVoted - ($this->positionVotes[$position->position_id] ?? 0)
            );
        }

        // Total abstentions is sum of all position abstentions
        $this->totalAbstentions = array_sum($this->positionAbstentions);
    }

    protected function loadPositionData(): void
    {
        $this->positionsWithCandidates = Election::find($this->selectedElection)
            ->positions()
            ->with([
                'electionPositions.candidates' => function ($q) {
                    $q->where('election_id', $this->selectedElection)
                        ->when(!str($this->council->name)->contains('Student Council'), function($query) {
                            $query->whereHas('users.program', function ($q) {
                                $q->where('council_id', $this->council->id);
                            });
                        })
                        ->with(['users.program', 'users.programMajor'])
                        ->withCount([
                            'votes as votes_count' => function($query) {
                                $query->select(DB::raw('COUNT(DISTINCT votes.user_id)'))
                                    ->where('votes.election_id', $this->selectedElection);
                            }
                        ]);
                }
            ])
            ->get();

        $this->studentCouncilPositions = $this->positionsWithCandidates->filter(function ($position) {
            return $position->electionType->name === 'Student Council Election';
        });

        $this->localCouncilPositions = $this->positionsWithCandidates->filter(function ($position) {
            return $position->electionType->name === 'Local Council Election';
        });
    }

    public function render()
    {
        $candidatesByPosition = [];

        if ($this->selectedElection) {
            $positions = str($this->council->name)->contains('Student Council')
                ? $this->studentCouncilPositions
                : $this->localCouncilPositions;

            foreach ($positions as $position) {
                $candidates = Candidate::where('election_id', $this->selectedElection)
                    ->whereHas('election_positions.position', function ($query) use ($position) {
                        $query->where('id', $position->id);
                    })
                    ->when(!str($this->council->name)->contains('Student Council'), function ($query) {
                        $query->whereHas('users.program', function ($q) {
                            $q->where('council_id', $this->council->id);
                        });
                    })
                    ->where(function (Builder $query) {
                        $query->whereHas('users', function ($q) {
                            $q->where('first_name', 'like', '%' . $this->search . '%');
                        })
                            ->orWhereHas('partyLists', function ($q) {
                                $q->where('name', 'like', '%' . $this->search . '%');
                            });
                    })
                    ->with(['users.program', 'users.programMajor', 'partyLists'])
                    ->withCount([
                        'votes as votes_count' => function($query) {
                            $query->select(DB::raw('COUNT(DISTINCT votes.user_id)'))
                                ->where('votes.election_id', $this->selectedElection);
                        }
                    ])
                    ->orderByDesc('votes_count')
                    ->get();

                $candidatesByPosition[$position->name] = $candidates;
            }
        }

        return view('evotar.livewire.vote-tally.realtime-vote-tally', [
            'council' => $this->council,
            'candidates' => $candidatesByPosition,
            'election' => $this->selectedElection ? Election::find($this->selectedElection) : null,
            'positions' => $this->positionsWithCandidates,
            'totalVoters' => $this->totalVoters ?? 0,
            'totalVoterVoted' => $this->totalVoterVoted ?? 0,
            'totalAbstentions' => $this->totalAbstentions ?? 0,
            'collegeTurnout' => $this->collegeTurnout ?? [],
            'positionVotes' => $this->positionVotes ?? [],
            'positionAbstentions' => $this->positionAbstentions ?? [],
        ]);
    }
}
