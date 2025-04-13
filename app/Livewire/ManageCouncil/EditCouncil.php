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
    public $tempLogoUrl = null;
    public $removeLogo = false;

    public function mount($councilId): void
    {
        $this->council = Council::with('councilPositionSetting')->find($councilId);

        if (!$this->council) {
            abort(404, 'Council not found');
        }

        $this->loadElectionTypesWithPositions();
        $this->name = $this->council->name;

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
            'logo' => 'nullable|image|max:1024',
        ]);

        if ($this->logo) {
            $this->tempLogoUrl = $this->logo->temporaryUrl();
            $this->removeLogo = false;
        }
    }

    public function removeLogo()
    {
        $this->reset(['logo', 'tempLogoUrl']);
        $this->removeLogo = true;
        $this->dispatch('logo-removed');
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
        ]);

        // Only validate settings if any position is filled
        $hasValidSettings = collect($this->councilSettings)
            ->filter(fn ($setting) => !empty($setting['position_id']))
            ->isNotEmpty();

        if ($hasValidSettings) {
            $this->validate([
                'councilSettings.*.position_id' => 'nullable|exists:positions,id',
                'councilSettings.*.separated_by_major' => 'nullable|boolean',
            ]);
        }

        // Check if logo_path exists and assign it to $logoPath
        $logoPath = $this->council->logo_path ?? null;

        // Handle logo removal
        if ($this->removeLogo) {
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = null;
        } elseif ($this->logo) {
            // Handle new logo upload
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

        // Only process valid settings
        $existingSettings = CouncilPositionSetting::where('council_id', $this->council->id)
            ->get()
            ->keyBy('position_id');

        if ($hasValidSettings) {
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
        } else {
            // If no settings at all, delete all existing for the council
            CouncilPositionSetting::where('council_id', $this->council->id)->delete();
        }

        $this->dispatch('council-edited', message: 'Council updated successfully');
    }

    public function render()
    {
        return view('evotar.livewire.manage-council.edit-council');
    }
}
