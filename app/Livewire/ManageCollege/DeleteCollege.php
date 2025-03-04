<?php

namespace App\Livewire\ManageCollege;

use App\Models\College;
use Livewire\Component;

class DeleteCollege extends Component
{
    public $college;

    public function mount($collegeId)
    {
        $this->college = College::find($collegeId);

    }
    public function delete()
    {
       if ($this->college) {
           $this->college->delete();
           $this->dispatch('college-deleted');
       }
    }

    public function render()
    {
        return view('evotar.livewire.manage-college.delete-college');
    }
}
