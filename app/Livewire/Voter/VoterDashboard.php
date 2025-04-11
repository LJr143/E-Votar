<?php
namespace App\Livewire\Voter;

use App\Models\Election;
use App\Models\Vote;
use Livewire\Component;
class VoterDashboard extends Component
{
    public $electionId;
    public $election;
    public $voter;
    public $hasVoted;

    public function mount($slug)
    {
        $this->voter = auth()->user();
        $this->election = Election::where('slug', $slug)->first();

        $this->hasVoted = Vote::where('user_id', $this->voter->id)
            ->where('election_id', $this->election->id)
            ->exists();

        if (!$this->election) {
            session()->flash('error', 'Election not found.');
            return redirect()->route('voter-election-redirect');
        }

        return $this->electionId = $this->election->id;

    }

    public function submit()
    {
        if(!$this->hasVoted){
            session(['election_slug' => $this->election->slug]);
            return redirect()->route('voter.voting', ['slug' => session('election_slug')]);
        }
        else {
            session()->flash('error', 'Unverified Action. You can only vote once.');
            return redirect()->route('voter.election.redirect');
        }

    }


    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.voter.voter-dashboard', [
            'election' => $this->election,
            'voter'=> $this->voter,
            'hasVoted' => $this->hasVoted,
        ]);
    }
}
