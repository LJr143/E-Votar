<?php

namespace App\Livewire\Superadmin;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\election_type;
use Livewire\Component;

class Candidates extends Component
{
    protected $listeners = ['candidate-created' => '$refresh'];
    public $candidates = [];
    public $filter = 'Student and Local Council Election';
    public $search = '';
    public $selectedElection;
    public $elections;
    public $latestElection;

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
        // Fetch the latest election based on the new filter
        $this->fetchElection($this->filter);

        // Fetch candidates based on the new filter and selected election
        $this->fetchCandidates();
    }

    public function updatedSelectedElection(): void
    {
        $this->fetchCandidates();
    }

    public function fetchCandidates(): void
    {
        $query = Candidate::with(['users', 'elections', 'election_positions.position.electionType']);

        // Apply search filter
        if ($this->search) {
            $query->whereHas('users', function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        }

        // Apply election filter
        if ($this->selectedElection) {
            $query->whereHas('elections', function ($q) {
                $q->where('id', $this->selectedElection);
            });
        }

        // Apply election type filter
        if ($this->filter) {
            $query->whereHas('elections.election_type', function ($q) {
                $q->where('name', $this->filter);
            });


        }

        // Fetch candidates
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


        $this->elections = Election::with('election_type')
            ->whereHas('election_type', function ($q) use ($filter) {
                $q->where('name', $filter);
            })
            ->get();
    }

    public function render()
    {
        return view('evotar.livewire.superadmin.candidates', [
            'candidates' => $this->candidates,
            'elections' => $this->elections,
        ]);
    }
}
