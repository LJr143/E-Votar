<?php
namespace App\Livewire\Voter;

use App\Models\Election;
use Livewire\Component;
use Carbon\Carbon;

class VoterDashboard extends Component
{
    public $electionId;
    public $election;
    public $voter;

    public function mount($slug)
    {
        $this->voter = auth()->user();
        $this->election = Election::where('slug', $slug)->first();

        if (!$this->election) {
            session()->flash('error', 'Election not found.');
            return redirect()->route('voter-election-redirect');
        }

        return $this->electionId = $this->election->id;

    }

    public function submit()
    {
        if ($this->election->election_type->name == 'Student and Local Council Election') {
            session(['election_slug' => $this->election->slug]);
            return redirect()->route('voter.step1');
        }
        else {
            session(['election_slug' => $this->election->slug]);
            return redirect()->route('voter.voting');
        }

    }


    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.voter.voter-dashboard', [
            'election' => $this->election,
            'voter'=> $this->voter,
        ]);
    }
}
