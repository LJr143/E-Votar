<?php

namespace App\Livewire\ManageCandidate;

use Livewire\Component;

class EditCandidate extends Component
{
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-candidate.edit-candidate');
    }
}
