<?php

namespace App\Livewire\ManagePartyList;

use App\Models\PartyList;
use Livewire\Component;

class ViewPartyListMembers extends Component
{
    public $partyListId;
    public $search = ''; // Search term

    public function render()
    {
        // Fetch party list with filtered candidates and their users
        $partyList = PartyList::with(['candidates.users.program'])
            ->find($this->partyListId);

        $candidates = $partyList
            ? $partyList->candidates->filter(function ($candidate) {
                return stripos($candidate->users->first_name, $this->search) !== false ||
                    stripos($candidate->users->last_name, $this->search) !== false;
            })
            : collect();

        return view('evotar.livewire.manage-party-list.view-party-list-members', [
            'partyList' => $partyList,
            'candidates' => $candidates, // Pass the filtered candidates
        ]);
    }
}
