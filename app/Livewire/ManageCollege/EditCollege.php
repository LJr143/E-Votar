<?php

namespace App\Livewire\ManageCollege;

use App\Models\College;
use Livewire\Component;

class EditCollege extends Component
{
    public $name;
    public $college;

    public function mount($collegeId)
    {
        $this->college = College::find($collegeId);
        if (!$this->college) {
            abort(404);
        }
        $this->name = $this->college->name;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255', // Add validation
        ]);

        $this->college->name = $this->name;
        $this->college->save(); // Save to database

        session()->flash('success', 'College updated successfully!');
        $this->dispatch('college-updated'); // Emit event for UI updates
    }

    public function render()
    {
        return view('evotar.livewire.manage-college.edit-college');
    }
}
