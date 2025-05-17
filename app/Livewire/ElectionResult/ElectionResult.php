<?php

namespace App\Livewire\ElectionResult;

use App\Models\Candidate;
use App\Models\Council;
use App\Models\Election;
use App\Models\ElectionPosition;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ElectionResult extends Component
{
    public $selectedElection;
    public $elections;
    public $filter = 'Student and Local Council Election';
    public $search = '';
    public $latestElection;
    public $totalVoters;
    public $totalVoterVoted;
    public $selectedElectionName;
    public $selectedElectionCampus;
    public $hasStudentCouncilPositions = false;
    public $hasLocalCouncilPositions = false;
    public $studentCouncilWinners = [];
    public $localCouncilWinners = [];
    public $voteTally = [];

    public function mount()
    {
        $this->selectedElection = session('selectedElection');
        $this->elections = Election::with('campus', 'election_type')->get();
        if ($this->selectedElection) {
            $this->latestElection = Election::find($this->selectedElection);
            $this->loadElectionData();
        }
    }

    public function updatedSelectedElection()
    {
        if ($this->selectedElection) {
            $this->latestElection = Election::find($this->selectedElection);
            $this->loadElectionData();
        }
    }

    protected function loadElectionData()
    {
        if (!$this->latestElection) {
            return;
        }

        $this->selectedElectionName = $this->latestElection->name;
        $this->selectedElectionCampus = $this->latestElection->campus;

        // Load vote tally data
        $this->loadVoteTallyData();

        // Load winners
        $this->studentCouncilWinners = $this->getWinnersByElectionType('Student Council Election');
        $this->localCouncilWinners = $this->getWinnersByProgram();

        // Check if there are positions
        $this->hasStudentCouncilPositions = !empty($this->studentCouncilWinners);
        $this->hasLocalCouncilPositions = !empty($this->localCouncilWinners);
    }

    protected function loadVoteTallyData()
    {
        $this->voteTally = [];
        $positions = ElectionPosition::where('election_id', $this->latestElection->id)
            ->with('position')
            ->get();

        $baseVoterQuery = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('name', '!=', 'faculty');
        })->whereDoesntHave('electionExcludedVoters', function ($q) {
            $q->where('election_id', $this->latestElection->id);
        });

        $this->totalVoters = $baseVoterQuery->count();
        $this->totalVoterVoted = DB::table('votes')
            ->where('election_id', $this->latestElection->id)
            ->distinct('user_id')
            ->count('user_id');

        foreach ($positions as $position) {
            $councilIds = DB::table('council_position_settings')
                ->where('position_id', $position->position->id)
                ->pluck('council_id')
                ->toArray();

            foreach ($councilIds as $councilId) {
                $council = Council::find($councilId);
                if (!$council) {
                    continue;
                }

                $voteTallyCount = DB::table('votes')
                    ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
                    ->join('users', 'candidates.user_id', '=', 'users.id')
                    ->join('programs', 'users.program_id', '=', 'programs.id')
                    ->where('votes.election_id', $this->latestElection->id)
                    ->where('candidates.election_position_id', $position->id)
                    ->when(!str($council->name)->contains('Student Council'), function ($query) use ($councilId) {
                        $query->where('programs.council_id', $councilId);
                    })
                    ->distinct('votes.user_id')
                    ->count('user_id');

                $totalVotersForPosition = $this->totalVoterVoted;
                $abstainCount = max(0, $totalVotersForPosition - $voteTallyCount);

                $this->voteTally[] = [
                    'position_id' => $position->position->id,
                    'council' => $council->name,
                    'vote_tally' => $voteTallyCount,
                    'abstain_count' => $abstainCount,
                    'total_voters' => $totalVotersForPosition,
                ];
            }
        }
    }

    public function getWinnersByElectionType($electionType): array
    {
        $winners = [];

        $positions = ElectionPosition::where('election_id', $this->latestElection->id)
            ->whereHas('position.electionType', function ($q) use ($electionType) {
                $q->where('name', $electionType);
            })
            ->with('position')
            ->get();

        foreach ($positions as $position) {
            $positionId = $position->position->id;
            $positionName = $position->position->name;
            $numWinners = $position->position->num_winners ?? 1;

            $totalVotesForPosition = DB::table('votes')
                ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
                ->where('votes.election_id', $this->latestElection->id)
                ->where('candidates.election_position_id', $position->id)
                ->distinct('user_id')
                ->count('user_id');

            $councilPositionSettings = DB::table('council_position_settings')
                ->where('position_id', $position->position->id)
                ->get();

            $candidatesByCouncil = Candidate::where('election_position_id', $position->id)
                ->with('users.program.council')
                ->withCount([
                    'votes as votes_count' => function ($query) {
                        $query->select(DB::raw('count(distinct user_id)'))
                            ->where('election_id', $this->latestElection->id)
                            ->where('candidate_id', DB::raw('candidates.id'));
                    }
                ])
                ->having('votes_count', '>', 0)
                ->when($this->search, function ($query) {
                    $query->whereHas('users', function ($q) {
                        $q->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    });
                })
                ->get()
                ->groupBy(function ($candidate) use ($councilPositionSettings) {
                    $councilId = $candidate->users->program->council->id ?? '0';
                    if ($councilId !== '0') {
                        $separateByMajor = $councilPositionSettings->where('council_id', $councilId)->first()->separate_by_major ?? false;
                        return $separateByMajor ? $councilId . '-' . ($candidate->users->program_major_id ?? '0') : $councilId;
                    }
                    return '0';
                });

            foreach ($candidatesByCouncil as $groupKey => $candidates) {
                $groupVotes = DB::table('votes')
                    ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
                    ->join('users', 'candidates.user_id', '=', 'users.id')
                    ->join('programs', 'users.program_id', '=', 'programs.id')
                    ->where('votes.election_id', $this->latestElection->id)
                    ->where('candidates.election_position_id', $position->id)
                    ->where('programs.council_id', $candidates->first()->users->program->council->id ?? null)
                    ->when(str_contains($groupKey, '-'), function ($q) use ($candidates) {
                        $q->where('users.program_major_id', $candidates->first()->users->program_major_id ?? null);
                    })
                    ->distinct('user_id')
                    ->count('user_id');

                $sortedCandidates = $candidates->sortByDesc('votes_count')->values();
                $selectedWinners = [];

                // Select winners, handling ties
                for ($i = 0; count($selectedWinners) < $numWinners && $i < $sortedCandidates->count(); $i++) {
                    $currentCandidate = $sortedCandidates[$i];
                    $currentVotes = $currentCandidate->votes_count;

                    $selectedWinners[] = $currentCandidate;

                    // Check for ties at the last winner position
                    if (count($selectedWinners) >= $numWinners) {
                        $lastWinnerVotes = $currentVotes;
                        for ($j = $i + 1; $j < $sortedCandidates->count(); $j++) {
                            if ($sortedCandidates[$j]->votes_count == $lastWinnerVotes) {
                                $selectedWinners[] = $sortedCandidates[$j];
                            } else {
                                break;
                            }
                        }
                    }
                }

                foreach ($selectedWinners as $candidate) {
                    $winners[] = [
                        'position' => $positionName,
                        'position_id' => $positionId,
                        'candidate' => $candidate,
                        'council' => $candidate->users->program->council->name ?? 'N/A',
                        'major' => $candidate->users->programMajor->name ?? 'N/A',
                        'votes_count' => $candidate->votes_count,
                        'vote_percentage' => $groupVotes > 0 ? round(($candidate->votes_count / $groupVotes) * 100, 2) : 0,
                    ];
                }
            }
        }

        return $winners;
    }

    public function getWinnersByProgram(): array
    {
        $winnersByProgram = [];

        $programs = Council::all();

        foreach ($programs as $program) {
            $positions = ElectionPosition::where('election_id', $this->latestElection->id)
                ->whereHas('position.electionType', function ($q) {
                    $q->where('name', 'Local Council Election');
                })
                ->with('position')
                ->get();

            $winners = [];

            foreach ($positions as $position) {
                $positionId = $position->position->id;
                $positionName = $position->position->name;
                $numWinners = $position->position->num_winners ?? 1;

                $totalVotesForPosition = DB::table('votes')
                    ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
                    ->join('users', 'candidates.user_id', '=', 'users.id')
                    ->join('programs', 'users.program_id', '=', 'programs.id')
                    ->where('votes.election_id', $this->latestElection->id)
                    ->where('candidates.election_position_id', $position->id)
                    ->where('programs.council_id', $program->id)
                    ->distinct('votes.user_id')
                    ->count('user_id');

                $councilPositionSettings = DB::table('council_position_settings')
                    ->where('position_id', $position->position->id)
                    ->where('council_id', $program->id)
                    ->first();

                $separateByMajor = $councilPositionSettings ? $councilPositionSettings->separate_by_major : false;

                $query = Candidate::where('election_position_id', $position->id)
                    ->whereHas('users.program.council', function ($q) use ($program) {
                        $q->where('id', $program->id);
                    })
                    ->with('users', 'users.program', 'users.programMajor')
                    ->withCount([
                        'votes as votes_count' => function ($query) use ($program) {
                            $query->select(DB::raw('count(distinct user_id)'))
                                ->where('election_id', $this->latestElection->id)
                                ->where('candidate_id', DB::raw('candidates.id'))
                                ->when($program->name !== 'Student Council', function ($q) use ($program) {
                                    $q->join('users', 'votes.user_id', '=', 'users.id')
                                        ->join('programs', 'users.program_id', '=', 'programs.id')
                                        ->where('programs.council_id', $program->id);
                                });
                        }
                    ])
                    ->having('votes_count', '>', 0)
                    ->when($this->search, function ($query) {
                        $query->whereHas('users', function ($q) {
                            $q->where('first_name', 'like', '%' . $this->search . '%')
                                ->orWhere('last_name', 'like', '%' . $this->search . '%');
                        });
                    })
                    ->orderByDesc('votes_count');

                if ($separateByMajor) {
                    $candidatesByMajor = $query->get()->groupBy(function ($candidate) {
                        return $candidate->users->programMajor->name ?? 'No Major';
                    });

                    foreach ($candidatesByMajor as $major => $candidates) {
                        $majorVotes = DB::table('votes')
                            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
                            ->join('users', 'candidates.user_id', '=', 'users.id')
                            ->join('programs', 'users.program_id', '=', 'programs.id')
                            ->where('votes.election_id', $this->latestElection->id)
                            ->where('candidates.election_position_id', $position->id)
                            ->where('programs.council_id', $program->id)
                            ->where('users.program_major_id', $candidates->first()->users->program_major_id ?? null)
                            ->distinct('votes.user_id')
                            ->count('user_id');

                        $sortedCandidates = $candidates->sortByDesc('votes_count')->values();
                        $selectedWinners = [];

                        // Select winners, handling ties
                        for ($i = 0; count($selectedWinners) < $numWinners && $i < $sortedCandidates->count(); $i++) {
                            $currentCandidate = $sortedCandidates[$i];
                            $currentVotes = $currentCandidate->votes_count;

                            $selectedWinners[] = $currentCandidate;

                            // Check for ties at the last winner position
                            if (count($selectedWinners) >= $numWinners) {
                                $lastWinnerVotes = $currentVotes;
                                for ($j = $i + 1; $j < $sortedCandidates->count(); $j++) {
                                    if ($sortedCandidates[$j]->votes_count == $lastWinnerVotes) {
                                        $selectedWinners[] = $sortedCandidates[$j];
                                    } else {
                                        break;
                                    }
                                }
                            }
                        }

                        foreach ($selectedWinners as $candidate) {
                            $winners[] = [
                                'position' => $positionName,
                                'position_id' => $positionId,
                                'candidate' => $candidate,
                                'major' => $major,
                                'votes_count' => $candidate->votes_count,
                                'vote_percentage' => $majorVotes > 0 ? round(($candidate->votes_count / $majorVotes) * 100, 2) : 0,
                            ];
                        }
                    }
                } else {
                    $candidates = $query->get();
                    $sortedCandidates = $candidates->sortByDesc('votes_count')->values();
                    $selectedWinners = [];

                    // Select winners, handling ties
                    for ($i = 0; count($selectedWinners) < $numWinners && $i < $sortedCandidates->count(); $i++) {
                        $currentCandidate = $sortedCandidates[$i];
                        $currentVotes = $currentCandidate->votes_count;

                        $selectedWinners[] = $currentCandidate;

                        // Check for ties at the last winner position
                        if (count($selectedWinners) >= $numWinners) {
                            $lastWinnerVotes = $currentVotes;
                            for ($j = $i + 1; $j < $sortedCandidates->count(); $j++) {
                                if ($sortedCandidates[$j]->votes_count == $lastWinnerVotes) {
                                    $selectedWinners[] = $sortedCandidates[$j];
                                } else {
                                    break;
                                }
                            }
                        }
                    }

                    foreach ($selectedWinners as $candidate) {
                        $winners[] = [
                            'position' => $positionName,
                            'position_id' => $positionId,
                            'candidate' => $candidate,
                            'major' => 'N/A',
                            'votes_count' => $candidate->votes_count,
                            'vote_percentage' => $totalVotesForPosition > 0 ? round(($candidate->votes_count / $totalVotesForPosition) * 100, 2) : 0,
                        ];
                    }
                }
            }

            if (!empty($winners)) {
                $winnersByProgram[$program->name] = $winners;
            }
        }

        return $winnersByProgram;
    }

    public function exportElectionResult()
    {
        // Implement export logic if needed
    }

    public function render()
    {
        return view('evotar.livewire.election-result.election-result');
    }
}
