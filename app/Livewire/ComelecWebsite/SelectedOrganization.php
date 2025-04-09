<?php

namespace App\Livewire\ComelecWebsite;

use App\Models\Council;
use App\Models\Election;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SelectedOrganization extends Component
{
    public $council;
    public $selectedElection;
    public $election;

    public function mount(Council $council)
    {
        $this->council = $council;
        $this->selectedElection = session('selectedElectionWeb');
        $this->election = Election::find($this->selectedElection);
    }
    public function render()
    {
        return view('evotar.livewire.comelec-website.selected-organization', [
            'election' => $this->election,
            'council' => $this->council,
        ]);
    }
}
