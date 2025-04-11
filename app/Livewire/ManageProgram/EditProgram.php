<?php

namespace App\Livewire\ManageProgram;

use App\Models\College;
use App\Models\Program;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditProgram extends Component
{
    public $name;
    public $program;
    public $college;

    public function mount($programId)
    {
        $this->program = Program::find($programId);
        $this->college = College::find($this->program->college_id);
        if (!$this->program) {
            abort(404);
        }
        $this->name = $this->program->name;
    }

    public function update(): void
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('programs')->where(function ($query) {
                    return $query->where('college_id', $this->college->id);
                }),
            ],
        ]);

        $this->program->name = $this->name;
        $this->program->save(); // Save to database

        session()->flash('success', 'Program updated successfully!');
        $this->dispatch('program-updated'); // Emit event for UI updates
    }

    public function render()
    {
        return view('evotar.livewire.manage-program.edit-program');
    }
}
