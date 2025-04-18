<?php

namespace App\Livewire;

use App\Models\Council;
use App\Models\Partylist;
use App\Models\Candidate;
use App\Models\Election;
use Livewire\Component;

class PartylistMembers extends Component
{
    public $partylist;
    public $currentElectionCandidates = [];
    public $otherMembers = [];
    public $search = '';
    public $organizationFilter = '';
    public $allPartylists = [];
    public $councils;

    public function mount($partylistId)
    {
        $this->councils = Council::all();
        $this->partylist = Partylist::withCount('candidates')
            ->with(['candidates.users.program.council', 'candidates.election_positions.position'])
            ->findOrFail($partylistId);

        $this->allPartylists = Partylist::withCount('candidates')
            ->orderBy('name')
            ->get();

        $this->filterMembers();
    }

    public function filterMembers(): void
    {
        $selectedElection = session('selectedElectionWeb');

        $query = $this->partylist->candidates()
            ->with([
                'users.program.council',
                'election_positions.position'
            ])
            ->when($this->search, function($query) {
                $query->whereHas('users', function($q) {
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                        ->orWhere('last_name', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->organizationFilter, function($query) {
                $query->whereHas('users.program.council', function($q) {
                    $q->where('name', $this->organizationFilter);
                });
            });

        // Current election candidates
        $this->currentElectionCandidates = $query->clone()
            ->where('election_id', $selectedElection)
            ->get()
            ->sortBy('election_positions.position.order');

        // Other members (not in current election)
        $this->otherMembers = $query->clone()
            ->where('election_id', '!=', $selectedElection)
            ->get();
    }

    public function updatedSearch(): void
    {
        $this->filterMembers();
    }

    public function updatedOrganizationFilter(): void
    {
        $this->filterMembers();
    }

    public function render()
    {
        return view('evotar.livewire.partylist-members');
    }
}
