<?php

namespace App\Livewire\ManageCouncil;

use App\Models\Council;
use Livewire\Component;

class AddCouncil extends Component
{
    public $name;

    public function submit(): void
    {
        $this->validate([
            'name' => 'required|string'
        ]);

        Council::create(['name' => $this->name]);

        $this->dispatch('council-created');
    }

    public function render()
    {
        return view('evotar.livewire.manage-council.add-council');
    }
}
