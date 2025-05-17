<?php

namespace App\Livewire\VoteTally;

use App\Exports\ElectionsExport;
use App\Exports\VoteTallyExport;
use App\Models\Candidate;
use App\Models\Council;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RealtimeVoteTally extends Component
{
    protected $listeners = ['candidate-created' => '$refresh'];
    public $candidates = [];
    public $filter;
    public $search = '';
    public $selectedElection;
    public $selectedFilter = 'tsc';
    public $elections;
    public $latestElection;
    public $hasStudentCouncilPositions;
    public $hasLocalCouncilPositions;
    public $selectedElectionName;
    public $selectedElectionCampus;

    public $totalVoters;
    public $totalVoterVoted;
    public $totalAbstentions;
    public $councils;
    public $positionVotes = [];
    public $positionAbstentions = [];

    public $hasLocalCouncilCandidate = false;
    public $hasStudentCouncilCandidate = false;

    public function mount(): void
    {
        $this->selectedElection = session('selectedElection');
        if ($this->selectedElection) {
            $this->filter = Election::with('election_type')
                ->find(session('selectedElection'))
                ->election_type
                ->name;
            $this->fetchElection($this->filter);
            $this->selectedFilter = $this->filter;
            $this->councils = Council::all();
            $this->fetchCandidates();
            $this->fetchVoterTally();
            $this->calculatePositionStats();
        }
    }

    public function updatedSearch(): void
    {
        $this->fetchElection($this->filter);
        $this->fetchCandidates();
        $this->fetchVoterTally();
        $this->calculatePositionStats();
    }

    public function updatedFilter(): void
    {
        $this->fetchElection($this->filter);
        $this->fetchCandidates();
        $this->fetchVoterTally();
        $this->calculatePositionStats();
        $this->dispatch('updateChartData', $this->selectedElection);
    }

    public function updatedSelectedElection(): void
    {
        $election = Election::find($this->selectedElection);
        $this->selectedElectionName = $election?->name;
        $this->selectedElectionCampus = $election?->campus;

        $this->fetchElection($this->filter);
        $this->fetchCandidates();
        $this->fetchVoterTally();
        $this->calculatePositionStats();
        $this->dispatch('updateChartData', $this->selectedElection);
    }

    public function fetchVoterTally(): void
    {
        $election = Election::find($this->selectedElection);
        if (!$election) {
            $this->totalVoters = 0;
            $this->totalVoterVoted = 0;
            return;
        }

        // Total eligible voters
        $this->totalVoters = User::where('campus_id', $election->campus_id)
            ->whereHas('roles', fn($q) => $q->where('name', 'voter'))
            ->whereDoesntHave('electionExcludedVoters', fn($q) => $q->where('election_id', $election->id))
            ->count();

        // Total voters who voted (distinct count)
        $this->totalVoterVoted = DB::table('votes')
            ->join('users', 'votes.user_id', '=', 'users.id')
            ->where('votes.election_id', $election->id)
            ->where('users.campus_id', $election->campus_id)
            ->whereHas('roles', fn($q) => $q->where('name', 'voter'))
            ->whereDoesntHave('electionExcludedVoters', fn($q) => $q->where('election_id', $election->id))
            ->distinct('votes.user_id')
            ->count('votes.user_id');
    }

    public function calculatePositionStats(): void
    {
        $election = Election::find($this->selectedElection);
        if (!$election) {
            $this->positionVotes = [];
            $this->positionAbstentions = [];
            $this->totalAbstentions = 0;
            return;
        }

        $positions = ElectionPosition::where('election_id', $election->id)
            ->with('position')
            ->get();

        foreach ($positions as $position) {
            // Count votes for this position using the exact specified method
            $this->positionVotes[$position->position_id] = DB::table('votes')
                ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
                ->join('users', 'candidates.user_id', '=', 'users.id')
                ->where('candidates.election_position_id', $position->id)
                ->where('votes.election_id', $election->id)
                ->where('users.campus_id', $election->campus_id)
                ->whereHas('roles', fn($q) => $q->where('name', 'voter'))
                ->whereDoesntHave('electionExcludedVoters', fn($q) => $q->where('election_id', $election->id))
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

    public function fetchCandidates(): void
    {
        $query = Candidate::with([
            'users',
            'users.program.council',
            'elections',
            'election_positions.position.electionType'
        ])
            ->withCount([
                'votes as votes_count' => function($query) {
                    $query->select(DB::raw('COUNT(DISTINCT votes.user_id)'))
                        ->where('votes.election_id', $this->selectedElection);
                }
            ])
            ->whereHas('elections', function($q) {
                $q->where('elections.id', $this->selectedElection);
            });

        // Check if the logged-in user has the 'local-council-watcher' role
        $user = auth()->user();
        if ($user && $user->hasRole('local-council-watcher')) {
            $query->whereHas('election_positions.position.electionType', function ($q) {
                $q->where('name', 'Local Council Election');
            })
                ->whereHas('users', function ($q) use ($user) {
                    $q->where('program_id', $user->program_id);
                });
        }

        // Apply search filter
        if ($this->search) {
            $query->whereHas('users', function ($q) {
                $q->where('first_name', 'like', '%'.$this->search.'%')
                    ->orWhere('last_name', 'like', '%'.$this->search.'%');
            });
        }

        // Apply election type filter
        if ($this->filter) {
            $query->whereHas('elections.election_type', function ($q) {
                $q->where('name', $this->filter);
            });
        }

        // Get results with proper ordering
        $this->candidates = $query
            ->orderBy('election_position_id')
            ->get();

        $this->hasStudentCouncilCandidate = Candidate::whereHas('election_positions.position.electionType', function ($q) {
            $q->where('name', 'Student Council Election');
        })->whereHas('elections', function ($q) {
            $q->where('id', $this->selectedElection);
        })->exists();

        $this->hasLocalCouncilCandidate = Candidate::whereHas('election_positions.position.electionType', function ($q) {
            $q->where('name', 'Local Council Election');
        })->whereHas('elections', function ($q) {
            $q->where('id', $this->selectedElection);
        })->exists();
    }

    public function fetchElection($filter): void
    {
        $this->latestElection = Election::with('election_type')
            ->whereHas('election_type', function ($q) use ($filter) {
                $q->where('name', $filter);
            })
            ->orderBy('created_at', 'desc')
            ->first();

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
        }

        $this->elections = Election::with('election_type')
            ->whereHas('election_type', function ($q) use ($filter) {
                $q->where('name', $filter);
            })
            ->get();
    }

    public function exportVoteTally()
    {
        return Excel::download(new VoteTallyExport($this->search, $this->filter, $this->selectedElection),
            'VOTE_TALLY_' . strtoupper($this->latestElection->name) . '.xlsx');
    }

    public function render()
    {
        return view('evotar.livewire.vote-tally.realtime-vote-tally', [
            'candidates' => $this->candidates,
            'elections' => $this->elections,
            'selectedElectionName' => $this->selectedElectionName,
            'selectedElectionCampus' => $this->selectedElectionCampus,
            'totalVoters' => $this->totalVoters ?? 0,
            'totalVoterVoted' => $this->totalVoterVoted ?? 0,
            'totalAbstentions' => $this->totalAbstentions ?? 0,
            'councils' => $this->councils,
            'hasStudentCouncilPositions' => $this->hasStudentCouncilPositions,
            'hasLocalCouncilPositions' => $this->hasLocalCouncilPositions,
            'positionVotes' => $this->positionVotes,
            'positionAbstentions' => $this->positionAbstentions,
        ]);
    }
}
