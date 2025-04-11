<?php

namespace App\Livewire\ManageCouncil;

use App\Models\Council;
use App\Models\CouncilPositionSetting;
use Livewire\Component;

class DeleteCouncil extends Component
{
    public $council;

    public function mount(int $councilId): void
    {
        $this->council = Council::findOrFail($councilId);
    }

    public function deleteCouncil(): void
    {
        if ($this->council->exists) {
            // First delete all related position settings
            CouncilPositionSetting::where('council_id', $this->council->id)->delete();

            // Then delete the council itself
            $this->council->delete();

            $this->dispatch('council-deleted', message: 'Council and its position settings deleted successfully');
        }
    }

    public function render()
    {
        return view('evotar.livewire.manage-council.delete-council');
    }
}
