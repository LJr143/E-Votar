<?php

namespace App\Livewire\ManageCouncil;

use App\Models\Council;
use App\Models\CouncilPositionSetting;
use App\Models\election_type;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditCouncil extends Component
{
    use WithFileUploads;

    public $council;
    public $name;
    public $councilSettings = [];
    public $electionTypesWithPositions = [];
    public $logo;
    public $temporaryLogoUrl = null;
    public $currentLogoPath;
    public $currentLogoUrl;
    public $councilId;

    public function mount($councilId): void
    {
        $this->councilId = $councilId;
        $this->loadCouncilData();
    }

    public function loadCouncilData(): void
    {
        $this->council = Council::with('councilPositionSetting')->findOrFail($this->councilId);
        $this->name = $this->council->name;
        $this->currentLogoPath = $this->council->logo_path;
        $this->temporaryLogoUrl = $this->getCurrentLogoUrl();
        $this->currentLogoUrl = $this->currentLogoPath;
        $this->loadElectionTypesWithPositions();

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

    public function updatedLogo()
    {
        $this->validateOnly('logo', [
            'logo' => 'nullable|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:1024',
        ]);

        if ($this->logo) {
            $this->temporaryLogoUrl = $this->logo->temporaryUrl();
            $this->currentLogoUrl = null;
        }
    }

    public function removeLogo()
    {
        $this->reset(['logo', 'temporaryLogoUrl']);
        $this->currentLogoPath = null;
        $this->currentLogoUrl = null;
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

    public function editCouncil(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024',
        ]);

        // Handle logo update
        if ($this->logo) {
            // Delete old logo if exists
            if ($this->currentLogoPath && Storage::disk('public')->exists($this->currentLogoPath)) {
                Storage::disk('public')->delete($this->currentLogoPath);
            }
            $this->currentLogoPath = $this->logo->store('council-logos', 'public');
        }

        // Update council
        $this->council->update([
            'name' => $this->name,
            'logo_path' => $this->currentLogoPath
        ]);

        // Update council settings
        $existingSettings = CouncilPositionSetting::where('council_id', $this->council->id)
            ->get()
            ->keyBy('position_id');

        foreach ($this->councilSettings as $setting) {
            if (empty($setting['position_id'])) continue;

            if ($existingSettings->has($setting['position_id'])) {
                CouncilPositionSetting::where([
                    'council_id' => $this->council->id,
                    'position_id' => $setting['position_id']
                ])->update([
                    'separate_by_major' => $setting['separated_by_major'] ?? false
                ]);
            } else {
                CouncilPositionSetting::create([
                    'council_id' => $this->council->id,
                    'position_id' => $setting['position_id'],
                    'separate_by_major' => $setting['separated_by_major'] ?? false
                ]);
            }
        }

        // Delete removed settings
        $currentPositionIds = collect($this->councilSettings)
            ->pluck('position_id')
            ->filter();

        CouncilPositionSetting::where('council_id', $this->council->id)
            ->whereNotIn('position_id', $currentPositionIds)
            ->delete();

        $this->dispatch('council-edited', message: 'Council updated successfully');
    }

    protected function getCurrentLogoUrl(): ?string
    {
        return $this->currentLogoPath
            ? Storage::disk('public')->url($this->currentLogoPath)
            : null;
    }

    public function render()
    {
        return view('evotar.livewire.manage-council.edit-council');
    }
}
