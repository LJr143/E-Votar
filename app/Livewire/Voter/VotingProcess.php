<?php
namespace App\Livewire\Voter;

use App\Models\Candidate;
use App\Models\Election;
use Livewire\Component;

class VotingProcess extends Component
{
    public $electionId;
    public $election;
    public $voter;
    public $positionsWithCandidates = [];

    public function mount($slug)
    {
        $this->voter = auth()->user();
        $this->election = Election::where('slug', $slug)->first();

        if (!$this->election) {
            session()->flash('error', 'Election not found.');
            return redirect()->route('voter-election-redirect');
        }

        $this->electionId = $this->election->id;

        // Fetch positions with candidates via election positions
        $this->positionsWithCandidates = $this->election->positions()
            ->with([
                'electionPositions.candidates.users.program',
                'electionPositions.candidates.users.programMajor'
            ])
            ->get();


    }
    public function vote($candidateId): void
    {
        $candidate = Candidate::find($candidateId);

        if (!$candidate) {
            session()->flash('error', 'Candidate not found.');
            return;
        }

        dd($candidate);
    }



    public function render()
    {
        return view('evotar.livewire.voter.voting-process', [
            'election' => $this->election,
            'positionsWithCandidates' => $this->positionsWithCandidates,
        ]);
    }
}
