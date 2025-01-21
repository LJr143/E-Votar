<?php

namespace App\Livewire\ManageElection;

use AllowDynamicProperties;
use App\Models\Election;
use Livewire\Component;

 class ViewElection extends Component
{
    public $election;
    public $election_name;
    public $election_type;
    public $election_campus;
    public $election_start;
    public $election_end;

    public function mount($electionId): void
    {
        $this->election = Election::findOrFail($electionId);

        // Populate fields
        $this->election_name = $this->election->name;
        $this->election_type = $this->election->election_type->name;
        $this->election_campus = $this->election->campus->name;
        $this->election_start = $this->election->date_started;
        $this->election_end = $this->election->date_ended;
    }
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-election.view-election');
    }
}
