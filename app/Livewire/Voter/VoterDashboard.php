<?php
namespace App\Livewire\Voter;

use App\Models\Election;
use App\Models\FeedbackToken;
use App\Models\Vote;
use App\Models\VoterEncodeVote;
use Carbon\Carbon;
use Livewire\Component;
class VoterDashboard extends Component
{
    public $electionId;
    public $election;
    public $voter;
    public $hasVoted;
    public $hasEnded;

    public $encodedVotes;
    public $feedbackToken;

    public function mount($slug)
    {
        $this->voter = auth()->user();
        $this->election = Election::where('slug', $slug)->first();
        $this->feedbackToken = FeedbackToken::where('user_id', $this->voter->id)->where('election_id', $this->election->id)->first();

        $this->hasVoted = Vote::where('user_id', $this->voter->id)
            ->where('election_id', $this->election->id)
            ->exists();

        $this->hasEnded = $this->election->date_ended <= now();
        $this->encodedVotes = VoterEncodeVote::where([
            ['election_id', '=', $this->election->id],
            ['user_id', '=', $this->voter->id]
        ])->first();



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
