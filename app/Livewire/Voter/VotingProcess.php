<?php

namespace App\Livewire\Voter;

use App\Helpers\EncryptionHelper;
use App\Helpers\SteganographyHelper;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use App\Models\VoterEncodeVote;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
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
    public $showSummaryModal = false;
    public $showDuplicateErrorModal = false;
    public $duplicateError = '';

    public function mount($slug)
    {
        $this->voter = auth()->user();
        $this->election = Election::where('slug', $slug)->first();

        if (!$this->election) {
            session()->flash('error', 'Election not found.');
            return redirect()->route('voter-election-redirect');
        }

        $this->positionsWithCandidates = $this->election->positions()
            ->with([
                'electionPositions.candidates' => function ($q) {
                    $q->where('election_id', $this->election->id)
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
        if ($this->hasDuplicateVotes()) {
            $this->showDuplicateErrorModal = true;
            $this->duplicateError = 'Duplicate votes detected. Please review your selections.';
            return;
        }

        $this->showSummaryModal = true;
    }

    public function addSelections($selections): void
    {
        foreach ($selections as $key => $value) {
            // Keep the original key format: selected_candidate_{position_id}_{slot_number}
            $this->selectedCandidates[$key] = $value;
        }
    }

    public function selectCandidate($positionId, $candidateId): void
    {
        $this->selectedCandidates[$positionId] = $candidateId;
    }

    private function hasDuplicateVotes(): bool
    {
        $votesByPosition = [];

        foreach ($this->selectedCandidates as $key => $candidateId) {
            $positionId = explode('_', str_replace('selected_candidate_', '', $key))[0];

            if (!isset($votesByPosition[$positionId])) {
                $votesByPosition[$positionId] = [];
            }

            $votesByPosition[$positionId][] = $candidateId;
        }

        foreach ($votesByPosition as $positionId => $candidateIds) {
            if (count($candidateIds) !== count(array_unique($candidateIds))) {
                return true;
            }
        }

        return false;
    }

    public function submitVotes(): void
    {
        // Check for duplicates
        if ($this->hasDuplicateVotes()) {
            $this->showDuplicateErrorModal = true;
            $this->duplicateError = 'Duplicate votes detected. Please review your selections.';
            return;
        }

        // Prepare vote data
        $voteData = [
            'election_id' => $this->election->id,
            'voter_id' => auth()->id(),
            'votes' => $this->selectedCandidates,
            'timestamp' => now()->toDateTimeString(),
        ];

        // Encode the vote data as JSON
        $jsonData = json_encode($voteData);

        // Debugging: Log the JSON data
        \Log::info('JSON Data before Encryption:', ['data' => $jsonData]);

        // Encrypt the JSON data
        EncryptionHelper::setKey(config('app.stegano_secret_key'));
        $encryptedData = EncryptionHelper::encrypt($jsonData);

        // Debugging: Log the encrypted data
        \Log::info('Encrypted Data:', ['data' => $encryptedData]);

        // Encode the encrypted data into an image
        $imagePath = storage_path('app/public/assets/election-image/student-and-local-council-election-2023.png');
        $outputPath = storage_path('app/public/encoded_votes/' . auth()->id() . '_vote.png');
        SteganographyHelper::encode($imagePath, $encryptedData, $outputPath);

        // Debugging: Log the output image path
        \Log::info('Encoded Image Path:', ['path' => $outputPath]);

        // Save the encoded vote record
        VoterEncodeVote::create([
            'user_id' => auth()->id(),
            'election_id' => $this->election->id,
            'encoded_image_path' => $outputPath,
        ]);


        // Create regular vote records
        foreach ($this->selectedCandidates as $key => $candidateId) {
            [$positionId, $slot] = explode('_', str_replace('selected_candidate_', '', $key));

            $candidate = Candidate::find($candidateId);
            if ($candidate) {
                Vote::create([
                    'user_id' => auth()->id(),
                    'candidate_id' => $candidate->id,
                    'election_id' => $this->election->id,
                    'election_type_id' => $this->election->election_type->id,
                    'position_id' => $positionId,
                    'vote_slot' => $slot,
                ]);
            }
        }

        // Reset selections and show success message
        $this->selectedCandidates = [];
        session()->flash('success', 'Votes submitted successfully. Download your encoded vote receipt.');
        $this->redirect(route('voter.voting.confirm'));
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
                                return $candidate->users->program_id === auth()->user()->program_id;
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
