<?php

namespace App\Livewire\Superadmin;

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
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.superadmin.add-party-list');
    }
}
