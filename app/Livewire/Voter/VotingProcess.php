<?php

namespace App\Livewire\Voter;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Livewire\Component;

class VotingProcess extends Component
{
    public $election;
    public $voter;
    public $positionsWithCandidates = [];
    public $currentStage;
    public $studentCouncilPositions = [];
    public $localCouncilPositions = [];
    public $showProceedButton = false;

    protected $listeners = ['submitVotes'];
    public $selectedCandidates = [];
    public $showSummaryModal = false; // Add this property for the modal

    public function mount($slug)
    {
        $this->voter = auth()->user();
        $this->election = Election::where('slug', $slug)->first();

        if (!$this->election) {
            session()->flash('error', 'Election not found.');
            return redirect()->route('voter-election-redirect');
        }

        // Fetch positions with their election positions and candidates for the current election
        $this->positionsWithCandidates = $this->election->positions()
            ->with([
                'electionPositions.candidates' => function ($q) {
                    $q->where('election_id', $this->election->id) // Filter candidates by election_id
                    ->with(['users.program', 'users.programMajor']);
                }
            ])
            ->get();

        // Categorize the positions
        $this->studentCouncilPositions = $this->positionsWithCandidates->filter(function ($position) {
            return $position->electionType->name === 'Student Council Election';
        });

        $this->localCouncilPositions = $this->positionsWithCandidates->filter(function ($position) {
            return $position->electionType->name === 'Local Council Election';
        });

        // Determine initial stage and proceed button
        if ($this->election->election_type->name === 'Student and Local Council Election') {
            $this->currentStage = 'student';
            $this->showProceedButton = $this->studentCouncilPositions->isNotEmpty() && $this->localCouncilPositions->isNotEmpty();
        } elseif ($this->election->election_type->name === 'Student Council Election') {
            $this->currentStage = 'student';
        } elseif ($this->election->election_type->name === 'Local Council Election') {
            $this->currentStage = 'local';
        }
    }

    public function proceedToLocalCouncilElection(): void
    {
        if ($this->currentStage === 'student' && $this->showProceedButton) {
            $this->currentStage = 'local';
        }
    }

    public function goBackToStudentCouncilElection(): void
    {
        if ($this->currentStage === 'local') {
            $this->currentStage = 'student';
        }
    }

    public function showSummary(): void
    {
        $this->showSummaryModal = true; // Show the modal
    }

    // Add selections to the stored array
    public function addSelections($selections): void
    {
        foreach ($selections as $key => $value) {
            $this->selectedCandidates[$key] = $value;
        }
    }

    public function selectCandidate($positionId, $candidateId): void
    {
        $this->selectedCandidates[$positionId] = $candidateId;
    }

    // Process all stored selections
    public function submitVotes(): void
    {
        foreach ($this->selectedCandidates as $positionId => $candidateId) {
            $candidate = Candidate::find($candidateId);
            if ($candidate) {
                Vote::create([
                    'user_id' => auth()->id(),
                    'candidate_id' => $candidate->id,
                    'election_id' => $this->election->id,
                    'election_type_id'=> $this->election->election_type->id,
                    'position_id' => $candidate->election_positions->position->id,
                ]);
            }
        }

        $this->selectedCandidates = []; // Clear after submission
        $this->showSummaryModal = false; // Hide the modal
        session()->flash('success', 'Votes submitted successfully.');
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        // Filter positions based on the current stage
        if ($this->currentStage === 'student') {
            $positionsWithCandidates = $this->studentCouncilPositions->map(function ($position) {
                $position->candidates = $position->electionPositions
                    ->flatMap(function ($electionPosition) {
                        return $electionPosition->candidates
                            ->where('election_id', $this->election->id)
                            ->map(function ($candidate) {
                                $candidate->load('users.program', 'users.programMajor', 'partyLists');
                                return $candidate;
                            });
                    });
                return $position;
            });
        } else {
            // Local Council Election
            $positionsWithCandidates = $this->localCouncilPositions->map(function ($position) {
                $position->candidates = $position->electionPositions
                    ->flatMap(function ($electionPosition) {
                        return $electionPosition->candidates
                            ->where('election_id', $this->election->id)
                            ->filter(function ($candidate) {
                                return $candidate->users->program_id === auth()->user()->program_id; // Match program
                            })
                            ->map(function ($candidate) {
                                $candidate->load('users.program', 'users.programMajor', 'partyLists');
                                return $candidate;
                            });
                    });
                return $position;
            });
        }

        return view('evotar.livewire.voter.voting-process', [
            'election' => $this->election,
            'positions' => $positionsWithCandidates,
            'currentStage' => $this->currentStage,
            'showProceedButton' => $this->showProceedButton,
            'selectedCandidates' => $this->selectedCandidates,
            'showSummaryModal' => $this->showSummaryModal,
        ]);
    }
}
