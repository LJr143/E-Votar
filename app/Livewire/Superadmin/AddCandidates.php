<?php

namespace App\Livewire\Superadmin;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\election_type;
use App\Models\ElectionPosition;
use App\Models\PartyList;
use App\Models\Position;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Validation\Rules\Can;
use Livewire\Component;

class AddCandidates extends Component
{

    protected $listeners = ['candidate-created' => '$refresh'];
    public $search = '';
    public $users = [];
    public $elections = [];
    public $positions = [];
    public $partyLists = [];
    public $selectedUser = null;
    public $selectedElection = null;
    public $candidate_position = null;
    public $candidate_party_list = null;
    public $candidate_description = '';

    public function mount(): void
    {
        $this->fetchElection();
        $this->fetchPartyList();
    }
    public function updatedSearch(): void
    {
        $this->users = User::where('first_name', 'like', '%' . $this->search . '%')
            ->orWhere('last_name', 'like', '%' . $this->search . '%')
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
            $this->search = $user->first_name . ' ' . $user->middle_initial . '. ' . $user->last_name;
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
        Candidate::create([
            'user_id' => $this->selectedUser,
            'election_id' => $this->selectedElection,
            'election_position_id' => $this->candidate_position,
            'party_list_id' => $this->candidate_party_list,
            'description' => $this->candidate_description,
        ]);

        $this->dispatch('candidate-created');
        $this->reset();

    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.superadmin.add-candidates', ['elections' => $this->elections, 'positions' => $this->positions, 'partyLists' => $this->partyLists]);
    }
}
