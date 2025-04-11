<?php

namespace App\Livewire\ManageCandidate;

use App\Models\Candidate;
use Livewire\Component;

class DeleteCandidate extends Component
{
    public $candidate;

    public function mount($candidateId): void
    {
        $this->candidate = Candidate::findOrFail($candidateId);
    }

    public function deleteCandidate(): void
    {
        if($this->candidate->exists){
            $this->candidate->delete();
            $this->dispatch('candidate-deleted');
        };
    }

    public function render()
    {
        return view('evotar.livewire.manage-candidate.delete-candidate');
    }
}
