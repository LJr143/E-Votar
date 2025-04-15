<?php

namespace App\Livewire\ManageProgram;

use App\Models\College;
use App\Models\Council;
use App\Models\Program;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditProgram extends Component
{
    public $name;
    public $program;
    public $college;
    public $councilId;
    public $councils;

    public function mount($programId)
    {
        $this->program = Program::with('council')->find($programId);
        $this->college = College::find($this->program->college_id);
        $this->councils = Council::all();
        $this->councilId = $this->program->council ? $this->program->council->id : null;

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
                })->ignore($this->program->id),
            ],
        ]);

        Program::updateOrCreate(
            ['id' => $this->program->id],
            [
                'name' => $this->name,
                'council_id' => $this->councilId,
            ]
        );


        session()->flash('success', 'Program updated successfully!');
        $this->dispatch('program-updated'); // Emit event for UI updates
    }

    public function render()
    {
        return view('evotar.livewire.manage-program.edit-program', [
            'councils' => $this->councils
        ]);
    }
}
