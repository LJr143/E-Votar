<?php

namespace App\Livewire\ManageElection;

use Livewire\Component;

class EditElection extends Component
{
    public $election_id;
    public function mount($election_id)
    {
        $this->election_id = $election_id;
    }


    public function render()
    {
        return view('evotar.livewire.manage-election.edit-election');
    }
}
