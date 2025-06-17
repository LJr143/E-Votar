<?php

namespace App\Exports;

use App\Models\AbstainVote;
use App\Models\Candidate;
use App\Models\Council;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ElectionResultExport implements FromView, ShouldAutoSize, WithDrawings
{
    protected $studentCouncilWinners;
    protected $localCouncilWinners;
    protected $election;
    protected $totalVoters;
    protected $totalVoterVoted;
    protected $abstainCounts;

    public function __construct($search, $filter, $selectedElection)
    {
        $this->election = Election::with('election_type')->find($selectedElection);

        if ($this->election) {
            $this->fetchWinners();
            $this->fetchVoterTally();
            $this->fetchAbstainCounts();
        }
    }

    protected function fetchWinners(): void
    {
        if ($this->election) {
            $this->studentCouncilWinners = $this->getWinnersByElectionType('Student Council Election');
            $this->localCouncilWinners = $this->getWinnersByProgram();
        }
    }

    protected function fetchVoterTally(): void
    {
        $this->totalVoters = User::where('campus_id', $this->election->campus_id)
            ->whereDoesntHave('electionExcludedVoters', fn($q) => $q->where('election_id', $this->election->id))
            ->count();

        $this->totalVoterVoted = User::where('campus_id', $this->election->campus_id)
            ->whereDoesntHave('electionExcludedVoters', fn($q) => $q->where('election_id', $this->election->id))
            ->where(function($query) {
                $query->whereHas('votes', fn($q) => $q->where('election_id', $this->election->id))
                    ->orWhereHas('abstainVotes', fn($q) => $q->where('election_id', $this->election->id));
            })
            ->count();

    }

    protected function fetchAbstainCounts(): void
    {
        $this->abstainCounts = AbstainVote::where('election_id', $this->election->id)
            ->selectRaw('position_id, count(*) as count')
            ->groupBy('position_id')
            ->pluck('count', 'position_id');
    }

    protected function getWinnersByElectionType($electionType): array
    {
        $winners = [];
        $positions = ElectionPosition::where('election_id', $this->election->id)
            ->whereHas('position.electionType', fn($q) => $q->where('name', $electionType))
            ->with('position')
            ->get();

        foreach ($positions as $position) {
            $positionId = $position->position->id;
            $positionName = $position->position->name;

            $councilPositionSettings = DB::table('council_position_settings')
                ->where('position_id', $positionId)
                ->get();

            $candidatesByCouncil = Candidate::where('election_position_id', $position->id)
                ->with('users.program.council')
                ->withCount('votes')
                ->having('votes_count', '>', 0)
                ->get()
                ->groupBy(function ($candidate) use ($councilPositionSettings) {
                    $councilId = $candidate->users->program->council->id;
                    $separateByMajor = $councilPositionSettings->where('council_id', $councilId)->first()->separate_by_major ?? false;
                    return $separateByMajor ? $councilId . '-' . $candidate->users->major : $councilId;
                });

            foreach ($candidatesByCouncil as $groupKey => $candidates) {
                $sortedCandidates = $candidates->sortByDesc('votes_count')->take($position->position->num_winners);

                foreach ($sortedCandidates as $candidate) {
                    $winners[] = [
                        'position' => $positionName,
                        'position_id' => $positionId,
                        'candidate' => $candidate,
                        'council' => $candidate->users->program->council->name,
                        'major' => $candidate->users->major ?? 'N/A',
                        'abstain_count' => $this->abstainCounts[$positionId] ?? 0
                    ];
                }
            }
        }

        return $winners;
    }

    protected function getWinnersByProgram(): array
    {
        $winnersByProgram = [];
        $programs = Council::all();

        foreach ($programs as $program) {
            $positions = ElectionPosition::where('election_id', $this->election->id)
                ->whereHas('position.electionType', fn($q) => $q->where('name', 'Local Council Election'))
                ->with('position')
                ->get();

            $winners = [];

            foreach ($positions as $position) {
                $positionId = $position->position->id;
                $positionName = $position->position->name;

                $councilPositionSettings = DB::table('council_position_settings')
                    ->where('position_id', $positionId)
                    ->where('council_id', $program->id)
                    ->first();

                $separateByMajor = $councilPositionSettings ? $councilPositionSettings->separate_by_major : false;

                $query = Candidate::where('election_position_id', $position->id)
                    ->whereHas('users.program.council', fn($q) => $q->where('id', $program->id))
                    ->with('users')
                    ->withCount('votes')
                    ->having('votes_count', '>', 0)
                    ->orderByDesc('votes_count');

                if ($separateByMajor) {
                    $candidatesByMajor = $query->get()->groupBy(fn($c) => $c->users->programMajor->name ?? 'No Major');

                    foreach ($candidatesByMajor as $major => $candidates) {
                        $sortedCandidates = $candidates->sortByDesc('votes_count')->take($position->position->num_winners);

                        foreach ($sortedCandidates as $candidate) {
                            $winners[] = [
                                'position' => $positionName,
                                'position_id' => $positionId,
                                'candidate' => $candidate,
                                'major' => $major,
                                'abstain_count' => $this->abstainCounts[$positionId] ?? 0
                            ];
                        }
                    }
                } else {
                    $candidates = $query->take($position->position->num_winners)->get();

                    foreach ($candidates as $candidate) {
                        $winners[] = [
                            'position' => $positionName,
                            'position_id' => $positionId,
                            'candidate' => $candidate,
                            'major' => 'N/A',
                            'abstain_count' => $this->abstainCounts[$positionId] ?? 0
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

    public function view(): View
    {
        return view('evotar.reports.exports.electionResultReport', [
            'studentCouncilWinners' => $this->studentCouncilWinners ?? [],
            'localCouncilWinners' => $this->localCouncilWinners ?? [],
            'election' => $this->election,
            'totalVoterVoted' => $this->totalVoterVoted,
            'totalVoters' => $this->totalVoters,
            'abstainCounts' => $this->abstainCounts ?? collect()
        ]);
    }

    public function drawings(): Drawing
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('University Logo');
        $drawing->setPath(public_path('storage/assets/image/University of Southeastern Philippines Tagum Unit.png'));
        $drawing->setHeight(50);
        $drawing->setWidth(300);
        $drawing->setOffsetX(280);
        $drawing->setCoordinates('C1');

        return $drawing;
    }
}
