<?php

namespace App\Livewire\ManageCouncil;

use App\Models\Council;
use App\Models\CouncilPositionSetting;
use App\Models\election_type;
use Livewire\Component;

class AddCouncil extends Component
{
    public $name;
    public $councilSettings = [];
    public $electionTypesWithPositions = [];

    public function mount(): void
    {
        $this->loadElectionTypesWithPositions();
        $this->councilSettings = [
            ['position_id' => null, 'separated_by_major' => null]
        ];
    }

    public function loadElectionTypesWithPositions(): void
    {
        $this->electionTypesWithPositions = election_type::with(['positions' => function($query) {
            $query->orderBy('created_at'); // Typically you'd order by name, not created_at
        }])->orderBy('created_at')->get(); // Order election types by name as well
    }

    public function addCouncilSettings(): void
    {
        $this->councilSettings[] = [
            'position_id' => null,
            'separated_by_major' => false
        ];
    }

    public function removeCouncilSettings($index): void
    {
        unset($this->councilSettings[$index]);
        $this->councilSettings = array_values($this->councilSettings);
    }

    public function submit(): void
    {
        // Validate only the council name first
        $this->validate([
            'name' => 'required|string|max:255|unique:councils,name',
        ]);

        // Create the council
        $council = Council::create(['name' => $this->name]);

        // Only validate and create position settings if at least one position is selected
        if (!empty(array_filter($this->councilSettings, fn($setting) => !empty($setting['position_id'])))) {
            $this->validate([
                'councilSettings.*.position_id' => 'required|exists:positions,id',
                'councilSettings.*.separated_by_major' => 'required|boolean',
            ]);

            foreach ($this->councilSettings as $setting) {
                if (!empty($setting['position_id'])) {
                    CouncilPositionSetting::create([
                        'council_id' => $council->id,
                        'position_id' => $setting['position_id'],
                        'separate_by_major' => (bool) $setting['separated_by_major'],
                    ]);
                }
            }
        }

        $this->dispatch('council-created');
        $this->reset();
    }


    public function render()
    {
        return view('evotar.livewire.manage-council.add-council');
    }
}
