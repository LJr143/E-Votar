<?php

namespace App\Livewire\SelectedElection;

use AllowDynamicProperties;
use App\Models\AbstainVote;
use App\Models\Candidate;
use App\Models\Council;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

#[AllowDynamicProperties] class VoteTallyInWebsite extends Component
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

    // New properties for statistics
    public $totalVoters;
    public $totalVoterVoted;
    public $totalAbstentions;
    public $collegeTurnout = [];
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

                // Load statistics data
                $this->loadStatisticsData($election);
            } else {
                $this->filter = null;
                $this->selectedElection = null;
            }
        } else {
            $this->filter = null;
            $this->selectedElection = null;
        }

        $this->councils = Council::all();

        if ($this->selectedElection) {
            $this->loadPositionData();
        }
    }

    protected function loadStatisticsData(Election $election)
    {
        // Base query for eligible voters (current council only)
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

        // College-wise turnout - show all councils for Student Council
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
                    'voted' => $council->voted_count
                ];
            });

        // Rest of your statistics loading...
        $this->totalVoterVoted = \App\Models\Vote::where('election_id', $this->selectedElection)
            ->when(!str($this->council->name)->contains('Student Council'), function($query) {
                $query->whereHas('users.program', function($q) {
                    $q->where('council_id', $this->council->id);
                });
            })
            ->distinct('user_id')
            ->count('user_id');

        $this->positionVotes = \App\Models\Vote::where('election_id', $this->selectedElection)
            ->whereHas('users.program', function($q) {
                $q->where('council_id', $this->council->id);
            })
            ->selectRaw('position_id, count(distinct user_id) as vote_count')
            ->groupBy('position_id')
            ->pluck('vote_count', 'position_id')
            ->toArray();

        $this->positionAbstentions = ElectionPosition::where('election_id', $this->selectedElection)
            ->with(['position' => function($query) {
                $query->withCount(['abstains as abstain_count' => function($q) {
                    $q->where('election_id', $this->selectedElection)
                        ->whereHas('user.program', function($q) {
                            $q->where('council_id', $this->council->id);
                        });
                }]);
            }])
            ->get()
            ->pluck('position.abstain_count', 'position.id')
            ->toArray();
    }

    protected function loadPositionData(): void
    {
        $this->positionsWithCandidates = Election::find($this->selectedElection)
            ->positions()
            ->with([
                'electionPositions.candidates' => function ($q) {
                    $q->where('election_id', $this->selectedElection);

                    if (!str($this->council->name)->contains('Student Council')) {
                        $q->whereHas('users.program', function ($query) {
                            $query->where('council_id', $this->council->id);
                        });
                    }

                    $q->with(['users.program', 'users.programMajor'])
                        ->withCount('votes');
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

            $positions->map(function ($position) use (&$candidatesByPosition) {
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
                    ->withCount('votes')
                    ->orderByDesc('votes_count')
                    ->get();

                $candidatesByPosition[$position->name] = $candidates;
                return $position;
            });
        }

        return view('evotar.livewire.selected-election.vote-tally-in-website', [
            'council' => $this->council,
            'candidates' => $candidatesByPosition,
            'election' => $this->selectedElection ? Election::find($this->selectedElection) : null,
            'positions' => $this->positionsWithCandidates,
            'totalVoters' => $this->totalVoters ?? 0,
            'totalVoterVoted' => $this->totalVoterVoted ?? 0,
            'totalAbstentions' => $this->totalAbstentions ?? 0,
            'collegeTurnout' => $this->collegeTurnout ?? [],
            'positionAbstentions' => $this->positionAbstentions ?? [],
        ]);
    }
}
