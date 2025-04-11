<?php

namespace App\Livewire\ManageProgramMajor;

use App\Models\Program;
use App\Models\program_major;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AddProgramMajor extends Component
{
    public $program;
    public $name;
    public function mount($programId): void
    {
        $this->program = Program::find($programId);
        if (!$this->program) {
            abort(404, 'Program not found');
        }
    }

    public function submit(): void
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('program_majors')->where(function ($query) {
                    return $query->where('program_id', $this->program->id);
                }),
            ]

        ]);

        program_major::create([
            'name' => $this->name,
            'program_id' => $this->program->id,
        ]);

        $this->dispatch('program-major-created');

        $this->reset('name');

        session()->flash('message', 'Program Major added successfully!');
    }

    public function render()
    {
        return view('evotar.livewire.manage-program-major.add-program-major', [
            'program' => $this->program,
        ]);
    }
}
