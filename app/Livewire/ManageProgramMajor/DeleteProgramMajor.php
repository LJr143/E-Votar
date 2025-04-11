<?php

namespace App\Livewire\ManageProgramMajor;

use App\Models\program_major;
use Livewire\Component;

class DeleteProgramMajor extends Component
{
    public $programMajor;

    public function mount($programMajorId)
    {
        $this->programMajor = program_major::find($programMajorId);

    }
    public function delete()
    {
        if ($this->programMajor) {
            $this->programMajor->delete();
            $this->dispatch('program-major-deleted');
        }
    }
    public function render()
    {
        return view('evotar.livewire.manage-program-major.delete-program-major');
    }
}
