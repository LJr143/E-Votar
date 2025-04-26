<?php

namespace App\Livewire;

use App\Models\Campus;
use App\Models\College;
use App\Models\Program;
use App\Models\program_major;
use App\Models\User;
use Livewire\Component;

class ConfirmAcademicDetails extends Component
{
    public $voterId;
    public $voter;
    public $showModal = false;

    // Academic fields
    public $campuses;
    public $colleges = [];
    public $programs = [];
    public $majors = [];

    public $campus_id;
    public $college_id;
    public $program_id;
    public $major_id;
    public $year_level;

    protected $rules = [
        'campus_id' => 'required|exists:campuses,id',
        'college_id' => 'required|exists:colleges,id',
        'program_id' => 'required|exists:programs,id',
        'major_id' => 'required|exists:program_majors,id',
    ];

    public function mount($voterId): void
    {
        $this->voterId = $voterId;
        $this->campuses = Campus::all();
        $this->voter = User::find($this->voterId);

        $this->campus_id = $this->voter->campus_id;
        $this->college_id = $this->voter->college_id;
        $this->program_id = $this->voter->program_id;
        $this->major_id = $this->voter->program_major_id;
        $this->year_level = $this->voter->year_level;

        $this->loadDependentData();
    }

    public function openModal(): void
    {

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->resetValidation();
        $this->showModal = false;
    }

    public function loadDependentData(): void
    {
        if ($this->campus_id) {
            $this->colleges = College::where('campus_id', $this->campus_id)->get();
        }

        if ($this->college_id) {
            $this->programs = Program::where('college_id', $this->college_id)->get();
        }

        if ($this->program_id) {
            $this->majors = program_major::where('program_id', $this->program_id)->get();
        }
    }

    public function updatedCampusId(): void
    {
        $this->reset(['college_id', 'program_id', 'major_id']);
        $this->loadDependentData();
    }

    public function updatedCollegeId(): void
    {
        $this->reset(['program_id', 'major_id']);
        $this->loadDependentData();
    }

    public function updatedProgramId(): void
    {
        $this->reset(['major_id']);
        $this->loadDependentData();
    }

    public function verifyAcademic(): void
    {
        $this->validate();

        $this->voter->update([
            'campus_id' => $this->campus_id,
            'college_id' => $this->college_id,
            'program_id' => $this->program_id,
            'program_major_id' => $this->major_id,
            'year_level' => $this->year_level,
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => auth()->user()->id,
            'verification_expires_at' => now()->addYear()
        ]);

        $this->dispatch('verification-completed');
        $this->closeModal();
    }

    public function render()
    {
        return view('evotar.livewire.confirm-academic-details');
    }
}
