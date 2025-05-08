<?php

namespace App\Livewire\ManageCandidate;

use AllowDynamicProperties;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\PartyList;
use App\Models\User;
use Livewire\Component;

 class EditCandidate extends Component
{
    protected $listeners = ['candidate-created' => '$refresh', ];
    public $search = '';
    public $users = [];
    public $elections = [];
    public $positions = [];
    public $partyLists = [];
    public $selectedUser = null;
    public $selectedElection = null;
    public $candidate_position = null;
    public $candidate_party_list = null;
    public $election;
    public $candidate_description = '';
    public $candidateId;
    public $candidate;

    public function mount($candidateId): void
    {
        $this->candidateId = $candidateId;
        $this->candidate = Candidate::find($candidateId);
        $this->selectUser($this->candidate->users->id);
        $this->selectedUser = $this->candidate->users->id;
        $this->selectedElection = $this->candidate->election_id;

        $this->candidate_position = $this->candidate->election_position_id;
        $this->updatedSelectedElection($this->candidate->election_id);
        $this->candidate_party_list = $this->candidate->party_list_id;
        $this->candidate_description = $this->candidate->description;

        $this->election = Election::find($this->candidate->election_id);

        $this->fetchElection();
        $this->fetchPartyList();
    }
    public function updatedSearch(): void
    {
        $this->users = User::role('voter')
            ->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            })
            ->take(5)
            ->get();

    }

    public function fetchElection(): void
    {
        $this->elections = Election::query()->get();
    }

    public function fetchPositions(): void
    {
        if ($this->selectedElection) {
            $this->positions = ElectionPosition::where('election_id', $this->selectedElection)->get();
        } else {
            $this->positions = [];
        }
    }
    public function updatedSelectedElection($value): void
    {
        $this->selectedElection = $value;
        $this->fetchPositions();
    }

    public function fetchPartyList(): void
    {
        $this->partyLists = PartyList::query()->get();
    }

    public function selectUser($userId): void
    {
        $user = User::find($userId);

        if ($user) {
            $this->selectedUser = $user->id;
            $this->search = $user->first_name . ' ' . $user->middle_initial . '. ' . $user->last_name . ' - ' . $user->year_level . ' - ' . $user->program->name;
            $this->users = [];
        }
    }

    public function submit(): void
    {
        $this->validate([
            'selectedUser' => 'required|exists:users,id',
            'selectedElection' => 'required|exists:elections,id',
            'candidate_position' => 'required',
            'candidate_party_list' => 'required|exists:party_lists,id',

        ]);

        $this->candidate->update([
            'user_id' => $this->selectedUser,
            'election_id' => $this->selectedElection,
            'election_position_id' => $this->candidate_position,
            'party_list_id' => $this->candidate_party_list,
            'description' => $this->candidate_description,
        ]);

        $this->dispatch('candidate-edited');

    }
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-candidate.edit-candidate', ['election' => $this->election]);
    }
}
