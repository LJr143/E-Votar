<?php

namespace App\Livewire\ManageProgram;

use App\Models\College;
use App\Models\Council;
use App\Models\Program;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AddProgram extends Component
{
    public $college;
    public $name;
    public $councils;
    public $councilId;
    public function mount($collegeId): void
    {
        $this->college = College::find($collegeId);
        if (!$this->college) {
            abort(404, 'College not found');
        }
        $this->councils = Council::all();

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
            ],
            'councilId' => ['required', 'exists:councils,id'],

        ]);

        Program::create([
            'name' => $this->name,
            'college_id' => $this->college->id,
            'council_id' => $this->councilId,
        ]);

        $this->dispatch('program-created');

        $this->reset('name');

        session()->flash('message', 'Program added successfully!');
    }
    public function render()
    {
        return view('evotar.livewire.manage-program.add-program', [
            'college' => $this->college,
            'councils' => $this->councils,
        ]);
    }
}
