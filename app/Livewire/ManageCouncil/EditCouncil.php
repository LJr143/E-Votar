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
    public $logo; // For new uploads
    public $tempLogoUrl; // For preview
    public $removeLogo = false; // Flag for logo removal

    public function mount($councilId): void
    {
        $this->council = Council::with('councilPositionSetting')->find($councilId);

        if (!$this->council) {
            abort(404, 'Council not found');
        }

        $this->loadElectionTypesWithPositions();
        $this->name = $this->council->name;

        // Load existing position settings
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
        $this->validate([
            'logo' => 'nullable|image|max:1024',
        ]);
        $this->tempLogoUrl = $this->logo->temporaryUrl();
        $this->removeLogo = false; // Reset removal flag if new image is uploaded
    }

    public function removeLogo()
    {
        $this->logo = null;
        $this->tempLogoUrl = null;
        $this->removeLogo = true;
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
            'logo' => 'nullable|image|max:1024',
            'councilSettings.*.position_id' => 'required|exists:positions,id',
            'councilSettings.*.separated_by_major' => 'required|boolean',
        ]);

        $logoPath = $this->council->logo_path;

        // Handle logo updates
        if ($this->removeLogo) {
            // Delete existing logo
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = null;
        } elseif ($this->logo) {
            // Store new logo and delete old one
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $this->logo->store('council-logos', 'public');
        }

        // Update council
        $this->council->update([
            'name' => $this->name,
            'logo_path' => $logoPath
        ]);

        // Process position settings
        $existingSettings = CouncilPositionSetting::where('council_id', $this->council->id)
            ->get()
            ->keyBy('position_id');

        foreach ($this->councilSettings as $setting) {
            if ($existingSettings->has($setting['position_id'])) {
                CouncilPositionSetting::where([
                    'council_id' => $this->council->id,
                    'position_id' => $setting['position_id']
                ])->update([
                    'separate_by_major' => $setting['separated_by_major']
                ]);
            } else {
                CouncilPositionSetting::create([
                    'council_id' => $this->council->id,
                    'position_id' => $setting['position_id'],
                    'separate_by_major' => $setting['separated_by_major']
                ]);
            }
        }

        // Delete removed settings
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
