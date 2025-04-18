<?php

namespace App\Livewire\ManagePartyList;

use App\Models\PartyList;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddPartyList extends Component
{
    use WithFileUploads;

    public $name;
    public $logo;
    public $logoPath;


    public function submit(): void
    {
        $this->validate([
            'name' => 'required|string',
            'logo' => 'nullable|image|max:1024',
        ]);

        $logoPath = $this->logo
            ? $this->logo->store('assets/party-list-logos/', 'public')
            : null;

        PartyList::create([
            'name' => $this->name,
            'logo_path' => $logoPath,
        ]);


        $this->dispatch('party-list-created');
        $this->reset();
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-party-list.add-party-list');
    }
}
