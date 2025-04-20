<?php

namespace App\Livewire\ManageCouncil;

use App\Models\Council;
use App\Models\CouncilPositionSetting;
use App\Models\election_type;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class AddCouncil extends Component
{
    use WithFileUploads;

    public $name;
    public $logo;
    public $logoPath;
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
        unset($this->councilSettings[$index]);
        $this->councilSettings = array_values($this->councilSettings);
    }

    public function submit(): void
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:councils,name',
            'logo' => 'nullable|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:1024',
        ]);

        // Store the logo and get the path
        $logoPath = $this->logo
            ? $this->logo->store('assets/logo/', 'public') // Stores in storage/app/public/council-logos
            : null;

        // Create the council with logo path
        $council = Council::create([
            'name' => $this->name,
            'logo_path' => $logoPath // Store the full path including filename
        ]);

        // Validate and create position settings if positions are selected
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
