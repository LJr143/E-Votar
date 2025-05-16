<?php

namespace App\Livewire\SelectedElection;

use App\Models\Candidate;
use App\Models\Council;
use App\Models\Election;
use App\Models\program_major;
use App\Models\ProgramMajor;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ElectionResultInWebsite extends Component
{
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
                            ->withCount('votes');
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
        $winnersByPosition = [];

        if ($this->selectedElection) {
            $election = Election::find($this->selectedElection);

            if (stripos($this->council->name, 'Student Council') !== false) {
                $this->studentCouncilPositions->map(function ($position) use (&$candidatesByPosition, &$winnersByPosition, $election) {
                    $candidates = Candidate::where('election_id', $this->selectedElection)
                        ->whereHas('election_positions.position', function ($query) use ($position) {
                            $query->where('id', $position->id);
                        })
                        ->with(['users.program', 'users.programMajor', 'partyLists'])
                        ->withCount('votes')
                        ->get();

                    $candidatesByPosition[$position->name] = $candidates;

                    if ($election->hasEnded() && $candidates->isNotEmpty()) {
                        // Filter candidates with votes > 0
                        $validCandidates = $candidates->filter(function ($candidate) {
                            return $candidate->votes_count > 0;
                        });

                        if ($validCandidates->isNotEmpty()) {
                            $numWinners = $position->num_winners ?? 1;
                            $winners = $validCandidates->sortByDesc('votes_count')->take($numWinners)->all();
                            $winnersByPosition[$position->name] = $winners;
                        }
                    }

                    return $position;
                });
            } else {
                $this->localCouncilPositions->map(function ($position) use (&$candidatesByPosition, &$winnersByPosition, $election) {
                    $candidates = Candidate::where('election_id', $this->selectedElection)
                        ->whereHas('election_positions.position', fn($q) => $q->where('id', $position->id))
                        ->whereHas('users.program', fn($q) => $q->where('council_id', $this->council->id))
                        ->with(['users.program', 'users.programMajor', 'partyLists'])
                        ->withCount('votes')
                        ->get();

                    if ($election->hasEnded() && $candidates->isNotEmpty()) {
                        // Filter candidates with votes > 0
                        $validCandidates = $candidates->filter(function ($candidate) {
                            return $candidate->votes_count > 0;
                        });

                        if ($validCandidates->isNotEmpty()) {
                            $settings = \DB::table('council_position_settings')
                                ->where('position_id', $position->id)
                                ->where('council_id', $this->council->id)
                                ->first();

                            $separateByMajor = $settings && $settings->separate_by_major;
                            $numWinners = $position->num_winners ?? 1;

                            if ($separateByMajor) {
                                $majors = program_major::whereHas('program', fn($q) => $q->where('council_id', $this->council->id))
                                    ->distinct()
                                    ->pluck('id');

                                $winners = [];
                                foreach ($majors as $majorId) {
                                    $majorCandidates = $validCandidates->filter(function ($candidate) use ($majorId) {
                                        return $candidate->users->programMajor->id === $majorId;
                                    });

                                    if ($majorCandidates->isNotEmpty()) {
                                        $majorWinners = $majorCandidates->sortByDesc('votes_count')->take($numWinners)->all();
                                        $winners = array_merge($winners, $majorWinners);
                                    }
                                }
                                if (!empty($winners)) {
                                    $winnersByPosition[$position->name] = $winners;
                                }
                            } else {
                                $winners = $validCandidates->sortByDesc('votes_count')->take($numWinners)->all();
                                if (!empty($winners)) {
                                    $winnersByPosition[$position->name] = $winners;
                                }
                            }
                        }
                    }

                    return $position;
                });
            }
        }

        return view('evotar.livewire.selected-election.election-result-in-website', [
            'council' => $this->council,
            'candidates' => $candidatesByPosition,
            'winners' => $winnersByPosition,
            'election' => $this->selectedElection ? Election::find($this->selectedElection) : null,
            'positions' => $this->positionsWithCandidates,
        ]);
    }
}
