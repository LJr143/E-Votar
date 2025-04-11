<?php

namespace App\Livewire\SelectedElection;

use App\Models\Candidate;
use App\Models\Council;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class VoteTallyInWebsite extends Component
{
    protected $listeners = ['updateChartData' => '$refresh'];
    public $council;
    public $councilId;
    public $positionsWithCandidates = [];
    public $studentCouncilPositions = [];
    public $localCouncilPositions = [];
    public $filter;
    public $selectedElection;
    public $councils;
    public $search = '';


    public function mount($councilId)
    {
        $this->councilId = $councilId;
        $this->council = Council::find($councilId);
        $selectedElectionId = session('selectedElectionWeb');

        if ($selectedElectionId) {
            $election = Election::with('election_type')->find($selectedElectionId);

            if ($election) {
                $this->filter = $election->election_type->name;
                $this->selectedElection = $selectedElectionId;
            } else {
                $this->filter = null;
                $this->selectedElection = null;
            }
        } else {
            $this->filter = null;
            $this->selectedElection = null;
        }

        $this->councils = Council::all();

        if ($this->selectedElection) {
            $this->positionsWithCandidates = Election::find($this->selectedElection)
                ->positions()
                ->with([
                    'electionPositions.candidates' => function ($q) {
                        $q->where('election_id', $this->selectedElection);

                        if (!str($this->council->name)->contains('Student Council')) {
                            $q->whereHas('users.program', function ($query) {
                                $query->where('council_id', $this->council->id);
                            });
                        }

                        $q->with(['users.program', 'users.programMajor'])
                            ->withCount('votes'); // ✅ This counts votes for each candidate
                    }
                ])
                ->get();




            $this->studentCouncilPositions = $this->positionsWithCandidates->filter(function ($position) {
                return $position->electionType->name === 'Student Council Election';
            });

            $this->localCouncilPositions = $this->positionsWithCandidates->filter(function ($position) {
                return $position->electionType->name === 'Local Council Election';
            });
        }
    }



    public function render()
    {
        $candidatesByPosition = [];

        if ($this->selectedElection) {

            if (stripos($this->council->name, 'Student Council')) {
                $this->studentCouncilPositions->map(function ($position) use (&$candidatesByPosition) {
                    $candidates = Candidate::where('election_id', $this->selectedElection)
                        ->whereHas('election_positions.position', function ($query) use ($position) {
                            $query->where('id', $position->id);
                        })
//                        ->when(!str($this->council->name)->contains('Student Council'), function ($query) {
//                            $query->whereHas('users.program', function ($q) {
//                                $q->where('council_id', $this->council->id);
//                            });
//                        })
                        ->where(function (Builder $query) {
                            $query->whereHas('users', function ($q) {
                                $q->where('first_name', 'like', '%' . $this->search . '%');
                            })
                                ->orWhereHas('partyLists', function ($q) {
                                    $q->where('name', 'like', '%' . $this->search . '%');
                                });
                        })
                        ->with(['users.program', 'users.programMajor', 'partyLists'])
                        ->get();

                    $candidatesByPosition[$position->name] = $candidates;
                    return $position;
                });
            } else{
                $this->localCouncilPositions->map(function ($position) use (&$candidatesByPosition) {
                    $candidates = Candidate::where('election_id', $this->selectedElection)
                        ->whereHas('election_positions.position', function ($query) use ($position) {
                            $query->where('id', $position->id);
                        })
                        ->whereHas('users.program', function ($q) {
                            $q->where('council_id', $this->council->id);
                        })
                        ->where(function (Builder $query) {
                            $query->whereHas('users', function ($q) {
                                $q->where('first_name', 'like', '%' . $this->search . '%');
                            })
                                ->orWhereHas('partyLists', function ($q) {
                                    $q->where('name', 'like', '%' . $this->search . '%');
                                });
                        })
                        ->with(['users.program', 'users.programMajor', 'partyLists'])->withCount('votes')
                        ->get();

                    $candidatesByPosition[$position->name] = $candidates;
                    return $position;
                });

            }

        }
        return view('evotar.livewire.selected-election.vote-tally-in-website',[
            'council' => $this->council,
            'candidates' => $candidatesByPosition,
            'election' => $this->selectedElection ? Election::find($this->selectedElection) : null,
            'positions' => $this->positionsWithCandidates,
        ]);
    }
}
