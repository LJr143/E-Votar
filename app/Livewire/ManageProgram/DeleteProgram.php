<?php

namespace App\Livewire\ManageProgram;

use App\Models\Program;
use Livewire\Component;

class DeleteProgram extends Component
{
    public $program;

    public function mount($programId)
    {
        $this->program = Program::find($programId);

    }
    public function delete()
    {
        if ($this->program) {
            $this->program->delete();
            $this->dispatch('program-deleted');
        }
    }
    public function render()
    {
        return view('evotar.livewire.manage-program.delete-program');
    }
}
