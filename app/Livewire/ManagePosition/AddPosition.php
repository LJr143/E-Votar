<?php

namespace App\Livewire\ManagePosition;

use App\Models\election_type;
use App\Models\Position;
use Livewire\Component;

class AddPosition extends Component
{
    public $name, $election_type_id, $election_types;

    public function addPosition(): void
    {
        // Validate input fields
        $this->validate([
            'name' => 'required|string|max:255',
            'election_type_id' => 'required|exists:election_types,id', // Ensures election_type_id exists in the election_types table
        ]);

        // Create a new Position
        Position::create([
            'name' => $this->name,
            'election_type_id' => $this->election_type_id,
        ]);

        // Dispatch an event or notification
        $this->dispatch('position-created');

        // Optionally reset fields after creation
        $this->reset(['name', 'election_type_id']);
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        // Fetch all election types for the dropdown
        $this->election_types = election_type::where('name', '!=', 'Student and Local Council Election')->get();

        // Pass the data to the view
        return view('evotar.livewire.manage-position.add-position', [
            'election_types' => $this->election_types
        ]);
    }
}
