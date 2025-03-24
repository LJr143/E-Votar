<?php

namespace App\Livewire\ManageCouncil;

use App\Models\Council;
use Livewire\Component;

class EditCouncil extends Component
{
    public $council;
    public $name;

    public function mount($councilId): void
    {
        $this->council = Council::find($councilId);

        if (!$this->council) {
            abort(404, 'Council not found');
        }

        $this->name = $this->council->name;
    }

    public function editCouncil(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the party list name
        $this->council->name = $this->name;
        $this->council->save();

        $this->dispatch('council-updated');
    }
    public function render()
    {
        return view('evotar.livewire.manage-council.edit-council');
    }
}
