<?php

namespace App\Livewire\ManageElection;

use App\Models\Campus;
use App\Models\College;
use App\Models\Election;
use App\Models\election_type;
use App\Models\ElectionPosition;
use App\Models\Position;
use App\Models\Program;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditElection extends Component
{
    use WithFileUploads;
    public $election;
    public $election_name;
    public $election_type;
    public $election_campus;
    public $election_start;
    public $election_end;
    public $positions = [];
    public $studentCouncilPositions = [];
    public $localCouncilPositions = [];
    public $selectedPositions = [];
    public $voters = [];
    public $selectedVoters = [];
    public $selectedColleges = [];
    public $selectedPrograms = [];
    public $programsByCollege = [];
    public $colleges = [];
    public $search = '';
    public $status = '';

    public $allVoters = [];
    public $excludedVoterIds = [];
    public $electionId;

    public $electionImageEdit;
    public $temporaryImageEditUrl;
    public $currentImagePath;


    public function mount($electionId): void
    {
        // Load the election data
        $this->election = Election::findOrFail($electionId);

        // Populate fields
        $this->electionId = $this->election->id;
        $this->election_name = $this->election->name;
        $this->election_type = $this->election->type;
        $this->election_campus = $this->election->campus_id;
        $this->election_start = $this->election->date_started;
        $this->election_end = $this->election->date_ended;
        $this->status = $this->election->status;

        $this->currentImagePath = $this->election->image_path;
        $this->temporaryImageEditUrl = $this->getCurrentImageUrl();

        // Load associated positions through the ElectionPosition table
        $this->selectedPositions = ElectionPosition::where('election_id', $electionId)
            ->pluck('position_id')
            ->toArray();

        // Fetch related data
        $this->positions = Position::whereIn('id', $this->selectedPositions)->get()->pluck('name', 'id')->toArray();
        $this->fetchVoters();
        $this->fetchCollege($this->election_campus);

        $this->updatedElectionType($this->election_type);
    }

    public function updatedElectionCampus($value): void
    {
        $this->fetchVoters();
        $this->fetchCollege($this->election_campus);
    }

    public function updatedSelectedColleges(): void
    {
        $this->programsByCollege = [];
        foreach ($this->selectedColleges as $collegeId) {
            $this->programsByCollege[$collegeId] = Program::where('college_id', $collegeId)->get();
        }
    }

    public function updatedElectionType($value): void
    {
        $this->selectedPositions = [];

        if ($value == 1) {
            // Fetch both student and local council positions linked to the election
            $this->studentCouncilPositions = ElectionPosition::where('election_id', $this->electionId)
                ->whereHas('position', function ($query) {
                    $query->where('election_type_id', '2');
                })
                ->with('position')
                ->get()
                ->pluck('position.name', 'position.id');

            $this->localCouncilPositions = ElectionPosition::where('election_id', $this->electionId)
                ->whereHas('position', function ($query) {
                    $query->where('election_type_id', '3');
                })
                ->with('position')
                ->get()
                ->pluck('position.name', 'position.id');

            // Merge the two collections
            $this->positions = $this->studentCouncilPositions->merge($this->localCouncilPositions);

            // Re-index the positions
            $this->positions = array_combine(
                range(1, count($this->positions)),
                array_values($this->positions->toArray())
            );
        } elseif ($value == 2) {
            // Fetch only student council positions
            $this->studentCouncilPositions = ElectionPosition::where('election_id', $this->electionId)
                ->whereHas('position', function ($query) {
                    $query->where('election_type_id', '2');
                })
                ->with('position')
                ->get()
                ->pluck('position.name', 'position.id');

            $this->positions = $this->studentCouncilPositions->toArray();
        } elseif ($value == 3) {
            // Fetch only local council positions
            $this->localCouncilPositions = ElectionPosition::where('election_id', $this->electionId)
                ->whereHas('position', function ($query) {
                    $query->where('election_type_id', '3');
                })
                ->with('position')
                ->get()
                ->pluck('position.name', 'position.id');

            $this->positions = $this->localCouncilPositions->toArray();
        } else {
            // Reset if no valid election type is selected
            $this->studentCouncilPositions = [];
            $this->localCouncilPositions = [];
        }

        // Set the selected positions
        $this->selectedPositions = array_keys($this->positions);
    }

    public function fetchVoters(): void
    {
        $this->voters = User::query()
            ->when($this->election_campus, fn($query) => $query->where('campus_id', $this->election_campus))
            ->when($this->selectedColleges, fn($query) => $query->whereIn('college_id', $this->selectedColleges))
            ->when($this->selectedPrograms, fn($query) => $query->whereIn('program_id', $this->selectedPrograms))
            ->get();
    }

    public function fetchCollege($campusId): void
    {
        $this->colleges = College::where('campus_id', $campusId)->get();
    }

    public function update(): void
    {
        $this->validate([
            'election_name' => 'required|string|max:255',
            'election_type' => 'required',
            'election_campus' => 'required',
            'election_start' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    // Ensure the new start date is >= the original start date
                    $originalStartDate = $this->election->date_started;
                    if (strtotime($value) < strtotime($originalStartDate)) {
                        $fail("The election start date cannot be earlier than the current start date ($originalStartDate).");
                    }
                },
            ],
            'election_end' => 'required|date|after:election_start',
            'selectedPositions' => 'required|array',
            'electionImageEdit' => 'nullable|mimes:png|image|max:2048',
        ]);

        if ($this->electionImageEdit) {
            if ($this->currentImagePath) {
                Storage::disk('public')->delete($this->currentImagePath);
            }
            $path = $this->electionImageEdit->store('election_images', 'public');
            $this->election->update(['image_path' => $path]);
            $this->currentImagePath = $path;
        }



        // Update the election
        $this->election->update([
            'name' => $this->election_name,
            'type' => $this->election_type,
            'campus_id' => $this->election_campus,
            'date_started' => $this->election_start,
            'date_ended' => $this->election_end,
            'status' => $this->status,
            'image_path' => $this->currentImagePath,
        ]);


        // Update positions
        foreach ($this->selectedPositions as $positionId) {
            ElectionPosition::updateOrCreate(
                [
                    'election_id' => $this->election->id,
                    'position_id' => $positionId,
                ],
                []
            );
        }

        // Optionally, delete any that are no longer selected
        ElectionPosition::where('election_id', $this->election->id)
            ->whereNotIn('position_id', $this->selectedPositions)
            ->delete();


        $this->dispatch('election-updated');
    }

    public function removePosition($positionId): void
    {
        $this->selectedPositions = array_diff($this->selectedPositions, [$positionId]);
    }

    protected function getCurrentImageUrl(): string
    {
        return $this->currentImagePath
            ? asset('storage/' . $this->currentImagePath)
            : asset('images/placeholder.png');
    }

    public function updatedElectionImageEdit(): void
    {
        if ($this->electionImageEdit) {
            $this->temporaryImageEditUrl = $this->electionImageEdit->temporaryUrl();
            $this->dispatch('imageUpdated', ['imageUrl' => $this->temporaryImageEditUrl]);
        }
    }





    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
    {
        $electionTypes = election_type::all();
        $campus = Campus::all();

        return view('evotar.livewire.manage-election.edit-election', [
            'colleges' => $this->colleges,
            'programsByCollege' => $this->programsByCollege,
            'campus' => $campus,
            'electionTypes' => $electionTypes,
            'positions' => $this->positions,
        ]);
    }
}
