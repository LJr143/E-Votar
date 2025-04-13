<?php

namespace App\Livewire\ManagePartyList;

use App\Models\PartyList;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DeletePartyList extends Component
{
    public PartyList $partyList;
    public $password;

    public function mount(int $partyListId): void
    {
        $this->partyList = PartyList::findOrFail($partyListId);
    }

    public function deletePartyList(): void
    {
        $this->validate([
            'password' => 'required|string',
        ]);


        // Verify the provided password matches the user's password
        if (!Hash::check($this->password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'password' => 'The password does not match our records.',
            ]);
        }

        if (!$this->password) {
            throw ValidationException::withMessages([
                'password' => 'The password cannot be empty.',
            ]);
        }


        if ($this->partyList->exists) {
            $this->partyList->delete();
            $this->dispatch('party-list-deleted');

        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-party-list.delete-party-list');
    }
}
