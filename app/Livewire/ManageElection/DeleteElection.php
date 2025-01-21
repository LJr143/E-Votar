<?php

namespace App\Livewire\ManageElection;

use App\Models\Election;
use Livewire\Component;

class DeleteElection extends Component
{
    public Election $election;

    public function mount(int $electionId): void
    {
        $this->election = Election::findOrFail($electionId);
    }

    public function deleteElection(): void
    {
        if ($this->election->exists) {
            $this->election->delete();

        }
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-election.delete-election');
    }
}
