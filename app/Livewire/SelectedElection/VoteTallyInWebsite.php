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

        // Total voters who voted in this election (for current council)
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
                    'voted' => $council->voted_count
                ];
            });

        // Calculate position votes using your specified method
        $this->positionVotes = [];
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
        }

        // Calculate abstentions by position (total voters who voted minus votes for position)
        $this->positionAbstentions = [];
        foreach ($positions as $position) {
            $votesForPosition = $this->positionVotes[$position->position_id] ?? 0;
            $this->positionAbstentions[$position->position_id] = max(0, $this->totalVoterVoted - $votesForPosition);
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
