<?php

namespace App\Livewire\ManageProgramMajor;

use App\Models\Program;
use App\Models\program_major;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditProgramMajor extends Component
{
    public $name;
    public $programMajor;
    public $program;

    public function mount($programMajorId)
    {
        $this->programMajor = program_major::find($programMajorId);
        $this->program = Program::find($this->programMajor->program_id);
        if (!$this->programMajor) {
            abort(404);
        }
        $this->name = $this->programMajor->name;
    }

    public function update(): void
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('program_majors')->where(function ($query) {
                    return $query->where('program_id', $this->program->id);
                }),
            ],
        ]);

        $this->programMajor->name = $this->name;
        $this->programMajor->save(); // Save to database

        session()->flash('success', 'Program  Major updated successfully!');
        $this->dispatch('program-major-updated'); // Emit event for UI updates
    }
    public function render()
    {
        return view('evotar.livewire.manage-program-major.edit-program-major');
    }
}
