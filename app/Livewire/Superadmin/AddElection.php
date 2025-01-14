<?php

namespace App\Livewire\Superadmin;

use App\Models\campus;
use App\Models\college;
use App\Models\Election;
use App\Models\election_type;
use App\Models\ElectionPosition;
use App\Models\Position;
use App\Models\Program;
use App\Models\User;
use Livewire\Component;

class AddElection extends Component
{
    public $election_name;
    public $election_type;
    public $election_campus;
    public $election_start;
    public $election_end;
    public $positions = [];
    public $studentCouncilPositions = [];
    public $localCouncilPositions = [];
    public $selectedPositions = [];
    public $currentStep = 1;
    public $voters = [];

    public $selectedVoters = []; // To hold selected voters
    public $selectedCollege; // For filtering by college
    public $selectedProgram; // For filtering by program
    public $colleges = []; // To hold college options
    public $programs = []; // To hold program options

    public $status = '';

    public function mount(): void
    {
        // Default to election type 1 (Student and Local Council)
        $this->updatedElectionType(1);
        $this->colleges = College::all();
        $this->fetchVoters(null);


    }

    public function updatedElectionCampus($value): void
    {
        // Fetch voters when the campus changes
        $this->fetchVoter($value);
    }

    public function updatedSelectedCollege($collegeId): void
    {
        $this->programs = $collegeId ? Program::where('college_id', $collegeId)->get() : [];
        $this->selectedProgram = null;
        $this->filterVoters();
    }

    public function updatedSelectedProgram(): void
    {
        $this->filterVoters();
    }

    public function fetchVoters(): void
    {
        $this->voters = User::query()
            ->when($this->election_campus, fn ($query) => $query->where('campus_id', $this->election_campus))
            ->when($this->selectedCollege, fn ($query) => $query->where('college_id', $this->selectedCollege))
            ->when($this->selectedProgram, fn ($query) => $query->where('program_id', $this->selectedProgram))
            ->get();
    }

    public function filterVoters(): void
    {
        $this->voters = User::query()
            ->when($this->election_campus, fn ($query) => $query->where('campus_id', $this->election_campus))
            ->when($this->selectedCollege, fn ($query) => $query->where('college_id', $this->selectedCollege))
            ->when($this->selectedProgram, fn ($query) => $query->where('program_id', $this->selectedProgram))
            ->get();
    }

    public function updatedElectionType($value): void
    {
        // Clear selected positions when election type changes
        $this->selectedPositions = [];

        if ($value == 1) {
            // Election type 1: Include both Student and Local Council positions
            $this->studentCouncilPositions = Position::where('election_type_id', '2')->pluck('name', 'id');
            $this->localCouncilPositions = Position::where('election_type_id', '3')->pluck('name', 'id');

            // Combine positions
            $this->positions = $this->studentCouncilPositions->merge($this->localCouncilPositions);

            // Adjust keys to start from 1
            $this->positions = array_combine(range(1, count($this->positions)), array_values($this->positions->toArray()));
        } elseif ($value == 2) {
            // Election type 2: Only Student Council positions
            $this->studentCouncilPositions = Position::where('election_type_id', '2')->pluck('name', 'id');
            $this->positions = $this->studentCouncilPositions->toArray();
        } elseif ($value == 3) {
            // Election type 3: Only Local Council positions
            $this->localCouncilPositions = Position::where('election_type_id', '3')->pluck('name', 'id');
            $this->positions = $this->localCouncilPositions->toArray();
        } else {
            // Default: No positions
            $this->studentCouncilPositions = [];
            $this->localCouncilPositions = [];
        }

        // Automatically add fetched positions to selectedPositions
        $this->selectedPositions = array_keys($this->positions);
    }

    public function removePosition($positionId): void
    {
        $this->selectedPositions = array_diff($this->selectedPositions, [$positionId]);
    }

    public function proceedToVoters(): void
    {
        // Validate election details
        $this->validate([
            'election_name' => 'required|string|max:255',
            'election_type' => 'required',
            'election_campus' => 'required',
            'election_start' => 'required|date',
            'election_end' => 'required|date|after:election_start',
            'selectedPositions' => 'required|array',
        ]);

        //Proceed to step 2
        $this->currentStep = 2;
    }

    public function submit(): void
    {
        if ($this->election_start >= now()){
            $this->status = 'ongoing';
        }else {
            $this->status = 'unverified';
        }
        //Create the election
        $election = Election::create([
            'name' => $this->election_name,
            'type' => $this->election_type,
            'campus_id' => $this->election_campus,
            'date_started' => $this->election_start,
            'date_ended' => $this->election_end,
            'status' => $this->status
        ]);

        $this->dispatch('election-created');

// Attach selected positions to the election
        foreach ($this->selectedPositions as $positionId) {
            // Ensure the position exists
            $position = Position::find($positionId);

            if ($position) {
                // Create a new ElectionPosition instance
                $electionPosition = new ElectionPosition();
                $electionPosition->election_id = $election->id; // Assign the election ID
                $electionPosition->position_id = $position->id; // Assign the position ID
                $electionPosition->save(); // Save the ElectionPosition record
            }
        }



        //Reset the form
        $this->reset();


    }

    public function backToStep1(): void
    {
        $this->currentStep = 1;

    }

    public function fetchVoter($campusId): void
    {
        // Fetch voters based on the selected campus ID
        $this->voters = User::where('campus_id', $campusId)->get();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
    {
        //fetch all election type for the form
        $electionTypes = election_type::all();

        //fetch all campus for the form
        $campus = campus::all();


        return view('evotar.livewire.superadmin.add-election', [
            'colleges' => $this->colleges,
            'programs' => $this->programs,
            'campus' => $campus,
            'electionTypes' => $electionTypes,
        ]);
    }
}
