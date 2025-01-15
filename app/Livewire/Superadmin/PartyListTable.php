<?php

namespace App\Livewire\Superadmin;

use App\Models\PartyList;
use Livewire\Component;

class PartyListTable extends Component
{
    public $search = '';

    protected $listeners = ['party-list-created' => '$refresh'];


    public function getPartyListsProperty(): \Illuminate\Database\Eloquent\Collection
    {
        $query = PartyList::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query->get();
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.superadmin.party-list-table', [
            'party_lists' => $this->partyLists,
        ]);
    }
}
