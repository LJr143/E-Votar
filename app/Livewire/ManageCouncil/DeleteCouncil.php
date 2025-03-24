<?php

namespace App\Livewire\ManageCouncil;

use App\Models\Council;
use Livewire\Component;

class DeleteCouncil extends Component
{
    public  $council;

    public function mount(int $councilId): void
    {
        $this->council = Council::findOrFail($councilId);
    }

    public function deleteCouncil(): void
    {
        if ($this->council->exists) {
            $this->council->delete();
            $this->dispatch('council-deleted');

        }
    }
    public function render()
    {
        return view('evotar.livewire.manage-council.delete-council');
    }
}
