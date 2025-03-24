<?php
namespace App\Livewire\ManageCandidate;

use App\Models\Candidate;
use App\Models\Council;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\User;
use Livewire\Component;

class ViewCandidate extends Component
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
    public $councils;


    public function mount(): void
    {
        $selectedElectionId = session('selectedElection');

        if ($selectedElectionId) {
            $election = Election::with('election_type')->find($selectedElectionId);

            if ($election) {
                $this->filter = $election->election_type->name;
                $this->selectedElection = $selectedElectionId;
            } else {
                // If the election is not found, set default values
                $this->filter = null;
                $this->selectedElection = null;
            }
        } else {
            // No election in session, set default values
            $this->filter = null;
            $this->selectedElection = null;
        }

        // Fetch data only if an election exists
        if ($this->filter) {
            $this->fetchElection($this->filter);
        }

        $this->selectedFilter = $this->filter;
        $this->councils = Council::all();
        $this->fetchCandidates();
        $this->fetchVoterTally();
    }


    public function updatedSearch(): void
    {
        $this->fetchElection($this->filter);
        $this->fetchCandidates();
        $this->fetchVoterTally();
    }

    public function updatedFilter(): void
    {
        $this->fetchElection($this->filter);
        $this->fetchCandidates();
        $this->fetchVoterTally();
    }

    public function updatedSelectedElection(): void
    {
        $election = Election::find($this->selectedElection);
        $this->selectedElectionName = $election?->name;
        $this->selectedElectionCampus = $election?->campus;

        $this->fetchElection($this->filter);
        $this->fetchCandidates();
        $this->fetchVoterTally();

    }


    public function fetchVoterTally(): void
    {
        if (!$this->selectedElection) {
            $this->totalVoters = 0;
            $this->totalVoterVoted = 0;
            return;
        }

        $election = Election::find($this->selectedElection);

        if (!$election) {
            $this->totalVoters = 0;
            $this->totalVoterVoted = 0;
            return;
        }

        $this->totalVoters = User::where('campus_id', $election->campus_id)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'voter');
            })
            ->whereDoesntHave('electionExcludedVoters', function ($query) use ($election) {
                $query->where('election_id', $election->id);
            })
            ->count();

        $this->totalVoterVoted = User::where('campus_id', $election->campus_id)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'voter');
            })
            ->whereDoesntHave('electionExcludedVoters', function ($query) use ($election) {
                $query->where('election_id', $election->id);
            })
            ->whereHas('votes', function ($query) use ($election) {
                $query->where('election_id', $election->id);
            })
            ->count();
    }


    public function fetchCandidates(): void
    {
        if (!$this->selectedElection) {
            $this->candidates = [];
            return;
        }

        $query = Candidate::with(['users', 'users.program.council', 'elections', 'election_positions.position.electionType'])
            ->withCount('votes')
            ->join('election_positions', 'candidates.election_position_id', '=', 'election_positions.id')
            ->orderBy('election_positions.position_id', 'asc')
            ->select('candidates.*'); // Ensure only candidate columns are selected

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



    public function fetchElection($filter): void
    {
        $this->latestElection = Election::with('election_type')
            ->whereHas('election_type', function ($q) use ($filter) {
                $q->where('name', $filter);
            })
            ->orderBy('created_at', 'desc')
            ->first();

        if ($this->latestElection) {
            $this->selectedElectionName = $this->latestElection->name;
            $this->selectedElectionCampus = $this->latestElection->campus;

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
        } else {
            // No election found
            $this->selectedElectionName = null;
            $this->selectedElectionCampus = null;
            $this->hasStudentCouncilPositions = false;
            $this->hasLocalCouncilPositions = false;
        }

        $this->elections = Election::with('election_type')
            ->whereHas('election_type', function ($q) use ($filter) {
                $q->where('name', $filter);
            })
            ->get();
    }



    public function render(): \Illuminate\Contracts\View\View
    {
        $this->fetchCandidates();

        return view('evotar.livewire.manage-candidate.view-candidate', [
            'candidates' => $this->candidates,
            'elections' => $this->elections,
            'selectedElectionName' => $this->selectedElectionName,
            'selectedElectionCampus' => $this->selectedElectionCampus,
            'totalVoters' => $this->totalVoters,
            'totalVoterVoted' => $this->totalVoterVoted,
            'councils' => $this->councils,
            'hasStudentCouncilPositions' => $this->hasStudentCouncilPositions,
            'hasLocalCouncilPositions' => $this->hasLocalCouncilPositions,
        ]);
    }
}
