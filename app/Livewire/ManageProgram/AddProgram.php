<?php

namespace App\Livewire\ManageProgram;

use App\Models\College;
use App\Models\Program;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AddProgram extends Component
{
    public $college;
    public $name;
    public function mount($collegeId): void
    {
        $this->college = College::find($collegeId);
        if (!$this->college) {
            abort(404, 'College not found');
        }
    }

    public function submit(): void
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('programs')->where(function ($query) {
                    return $query->where('college_id', $this->college->id);
                }),
            ]

        ]);

        Program::create([
            'name' => $this->name,
            'college_id' => $this->college->id,
        ]);

        $this->dispatch('program-created');

        $this->reset('name');

        session()->flash('message', 'Program added successfully!');
    }
    public function render()
    {
        return view('evotar.livewire.manage-program.add-program', [
            'college' => $this->college,
        ]);
    }
}
