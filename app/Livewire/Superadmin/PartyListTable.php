<?php

namespace App\Livewire\Superadmin;

use App\Models\PartyList;
use Livewire\Component;

class PartyListTable extends Component
{
    public $search = '';
    public $selectedElection;

    protected $listeners = [
        'party-list-created' => '$refresh',
        'party-list-updated' => '$refresh',
        'party-list-deleted' => '$refresh',
    ];

    public function mount(): void
    {
        $this->selectedElection = session('selectedElection');
    }


    public function getPartyListsProperty(): \Illuminate\Database\Eloquent\Collection
    {
        $query = PartyList::with('candidates');

        // Apply search filter
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Return the results
        return $query->get();
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('evotar.livewire.superadmin.party-list-table', [
            'party_lists' => $this->partyLists, // Access the computed property
        ]);
    }
}
