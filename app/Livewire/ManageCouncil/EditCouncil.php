<?php


namespace App\Livewire\ManageCouncil;

use App\Models\Council;
use App\Models\CouncilPositionSetting;
use App\Models\election_type;
use Livewire\Component;

class EditCouncil extends Component
{
    public $council;
    public $name;
    public $councilSettings = [];
    public $electionTypesWithPositions = [];

    public function mount($councilId): void
    {
        $this->council = Council::with('councilPositionSetting')->find($councilId);

        if (!$this->council) {
            abort(404, 'Council not found');
        }

        $this->loadElectionTypesWithPositions();
        $this->name = $this->council->name;

        // Load existing position settings or initialize with one empty row
        $this->councilSettings = $this->council->councilPositionSetting->isEmpty()
            ? [['position_id' => null, 'separated_by_major' => false]]
            : $this->council->councilPositionSetting->map(function ($setting) {
                return [
                    'position_id' => $setting->position_id,
                    'separated_by_major' => $setting->separate_by_major
                ];
            })->toArray();
    }

    public function loadElectionTypesWithPositions(): void
    {
        $this->electionTypesWithPositions = election_type::with(['positions' => function ($query) {
            $query->orderBy('created_at');
        }])->orderBy('created_at')->get();
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
        $setting = $this->councilSettings[$index];

        // Only try to delete if position_id exists (not a new empty row)
        if (!empty($setting['position_id'])) {
            CouncilPositionSetting::where([
                'council_id' => $this->council->id,
                'position_id' => $setting['position_id']
            ])->delete();
        }

        unset($this->councilSettings[$index]);
        $this->councilSettings = array_values($this->councilSettings);
    }

    public function editCouncil(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'councilSettings.*.position_id' => 'required|exists:positions,id',
            'councilSettings.*.separated_by_major' => 'required|boolean',
        ]);

        // Update council name
        $this->council->update(['name' => $this->name]);

        // Get current settings from database
        $existingSettings = CouncilPositionSetting::where('council_id', $this->council->id)
            ->get()
            ->keyBy('position_id');

        // Process each setting
        foreach ($this->councilSettings as $setting) {
            if ($existingSettings->has($setting['position_id'])) {
                // Update existing setting
                CouncilPositionSetting::where([
                    'council_id' => $this->council->id,
                    'position_id' => $setting['position_id']
                ])->update([
                    'separate_by_major' => $setting['separated_by_major']
                ]);
            } else {
                // Create new setting
                CouncilPositionSetting::create([
                    'council_id' => $this->council->id,
                    'position_id' => $setting['position_id'],
                    'separated_by_major' => $setting['separated_by_major']
                ]);
            }
        }

        // Delete any settings that were removed from the form
        $currentPositionIds = collect($this->councilSettings)->pluck('position_id');
        CouncilPositionSetting::where('council_id', $this->council->id)
            ->whereNotIn('position_id', $currentPositionIds)
            ->delete();

        $this->dispatch('council-edited', message: 'Council updated successfully');
    }

    public function render()
    {
        return view('evotar.livewire.manage-council.edit-council');
    }
}
