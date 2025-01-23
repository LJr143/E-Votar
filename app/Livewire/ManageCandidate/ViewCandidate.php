<?php
namespace App\Livewire\ManageCandidate;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionPosition;
use Livewire\Component;

class ViewCandidate extends Component
{
    protected $listeners = ['candidate-created' => '$refresh'];
    public $candidates = [];
    public $filter = 'Student and Local Council Election';
    public $search = '';
    public $selectedElection;
    public $elections;
    public $latestElection;
    public $hasStudentCouncilPositions;
    public $hasLocalCouncilPositions;

    public function mount(): void
    {
        $this->fetchElection($this->filter);
        $this->fetchCandidates();
    }

    public function updatedSearch(): void
    {
        $this->fetchCandidates();
    }

    public function updatedFilter(): void
    {
        $this->fetchElection($this->filter);
        $this->fetchCandidates();
    }

    public function updatedSelectedElection(): void
    {
        $this->fetchCandidates();
    }

    public function fetchCandidates(): void
    {
        $query = Candidate::with(['users', 'elections', 'election_positions.position.electionType']);

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

        $this->selectedElection = $this->latestElection ? $this->latestElection->id : null;

        $this->hasStudentCouncilPositions = false;
        $this->hasLocalCouncilPositions = false;

        if ($this->latestElection) {
            $this->hasStudentCouncilPositions = ElectionPosition::where('election_id', $this->latestElection->id)
                ->whereHas('position.electionType', function ($q) {
                    $q->where('name', 'Student Council');
                })
                ->exists();

            $this->hasLocalCouncilPositions = ElectionPosition::where('election_id', $this->latestElection->id)
                ->whereHas('position.electionType', function ($q) {
                    $q->where('name', 'Local Council');
                })
                ->exists();
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
        ]);
    }
}
