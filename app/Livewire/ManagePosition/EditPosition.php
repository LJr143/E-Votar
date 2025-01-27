<?php

namespace App\Livewire\ManagePosition;

use App\Models\election_type;
use App\Models\Position;
use Livewire\Component;

class EditPosition extends Component
{
    public $name, $election_type_id, $election_types, $position;

    public function mount($positionId): void
    {
        $this->position = Position::find($positionId);
        $this->name = $this->position->name;
        $this->election_type_id = $this->position->election_type_id;

    }

    public function editPosition(): void
    {
        // Validate input fields
        $this->validate([
            'name' => 'required|string|max:255',
            'election_type_id' => 'required|exists:election_types,id',
        ]);

        // Find the Position model instance you want to update
        $position = Position::findOrFail($this->position->id);

        // Update the Position
        $position->update([
            'name' => $this->name,
            'election_type_id' => $this->election_type_id,
        ]);

        // Dispatch an event or notification
        $this->dispatch('position-edited');
    }


    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        // Fetch all election types for the dropdown
        $this->election_types = election_type::where('name', '!=', 'Student and Local Council Election')->get();

        return view('evotar.livewire.manage-position.edit-position', [
            'election_types' => $this->election_types
        ]);
    }
}
