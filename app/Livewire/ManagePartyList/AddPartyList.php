<?php

namespace App\Livewire\ManagePartyList;

use App\Models\PartyList;
use Livewire\Component;

class AddPartyList extends Component
{

    public $name;


    public function submit(): void
    {
        $this->validate([
            'name' => 'required|string'
        ]);

        PartyList::create(['name' => $this->name]);

        $this->dispatch('party-list-created');
        $this->reset();
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-party-list.add-party-list');
    }
}
