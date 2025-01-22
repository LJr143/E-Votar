<?php

namespace App\Livewire\ManagePartyList;

use App\Models\PartyList;
use Livewire\Component;

class EditPartyList extends Component
{
    public $partyList;
    public $name;

    public function mount($partyListId): void
    {
        $this->partyList = PartyList::find($partyListId);

        if (!$this->partyList) {
            abort(404, 'Party List not found');
        }

        $this->name = $this->partyList->name;
    }

    public function editPartyList(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the party list name
        $this->partyList->name = $this->name;
        $this->partyList->save();

        // Optionally emit an event or redirect
        session()->flash('message', 'Party List updated successfully.');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-party-list.edit-party-list');
    }
}
