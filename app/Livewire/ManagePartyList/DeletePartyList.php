<?php

namespace App\Livewire\ManagePartyList;

use App\Models\PartyList;
use Livewire\Component;

class DeletePartyList extends Component
{
    public PartyList $partyList;

    public function mount(int $partyListId): void
    {
        $this->partyList = PartyList::findOrFail($partyListId);
    }

    public function deletePartyList(): void
    {
        if ($this->partyList->exists) {
            $this->partyList->delete();

        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-party-list.delete-party-list');
    }
}
