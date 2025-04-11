<?php

namespace App\Exports;

use App\Livewire\ElectionResult\ElectionResult;
use App\Models\Candidate;
use App\Models\Council;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ElectionResultExport extends ElectionResult implements FromView, ShouldAutoSize, WithDrawings
{
    public $studentCouncilWinners;
    public $localCouncilWinners;
    public $election;
    public $search, $filter, $selectedElection, $totalVoters, $totalVoterVoted;

    public function __construct($search, $filter, $selectedElection)
    {
        $this->search = $search;
        $this->filter = $filter;
        $this->selectedElection = $selectedElection;
        $this->election = Election::with('election_type')->find($this->selectedElection);
        $this->fetchWinners();
        $this->fetchVoterTally($this->election->id);
    }

    public function fetchWinners(): void
    {
        if ($this->election) {
            $this->studentCouncilWinners = $this->getWinnersByElectionType('Student Council Election');
            $this->localCouncilWinners = $this->getWinnersByProgram();
        } else {
            $this->studentCouncilWinners = collect();
            $this->localCouncilWinners = collect();
        }
    }

    public function fetchVoterTally($electionId): void
    {
        $election = Election::find($this->selectedElection);
        if ($election) {
            $this->totalVoters = User::where('campus_id', $election->campus_id)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'voter');
                })
                ->whereDoesntHave('electionExcludedVoters', function ($query) use ($election) {
                    $query->where('election_id', $election->id);
                })
                ->count();

            $this->totalVoterVoted = User::where('campus_id', $election->campus_id)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'voter');
                })
                ->whereDoesntHave('electionExcludedVoters', function ($query) use ($election) {
                    $query->where('election_id', $election->id);
                })
                ->whereHas('votes', function ($query) use ($election) {
                    $query->where('election_id', $election->id);
                })
                ->count();
        }
    }

    public function getWinnersByElectionType($electionType): array
    {
        // Same logic as your Livewire component
        $winners = [];

        $positions = ElectionPosition::where('election_id', $this->election->id)
            ->whereHas('position.electionType', function ($q) use ($electionType) {
                $q->where('name', $electionType);
            })
            ->with('position')
            ->get();

        foreach ($positions as $position) {
            // Fetch council-specific settings for this position
            $councilPositionSettings = DB::table('council_position_settings')
                ->where('position_id', $position->position->id)
                ->get();

            // Group candidates by council and major (if required)
            $candidatesByCouncil = Candidate::where('election_position_id', $position->id)
                ->with('users.program.council')
                ->withCount('votes')
                ->having('votes_count', '>', 0)
                ->get()
                ->groupBy(function ($candidate) use ($councilPositionSettings) {
                    $councilId = $candidate->users->program->council->id;
                    $separateByMajor = $councilPositionSettings->where('council_id', $councilId)->first()->separate_by_major ?? false;

                    if ($separateByMajor) {
                        return $councilId . '-' . $candidate->users->major; // Group by council and major
                    } else {
                        return $councilId; // Group by council only
                    }
                });

            foreach ($candidatesByCouncil as $groupKey => $candidates) {
                // Sort candidates by vote count and take the top N
                $sortedCandidates = $candidates->sortByDesc('votes_count')->take($position->position->num_winners);

                foreach ($sortedCandidates as $candidate) {
                    $winners[] = [
                        'position' => $position->position->name,
                        'candidate' => $candidate,
                        'council' => $candidate->users->program->council->name,
                        'major' => $candidate->users->major ?? 'N/A',
                    ];
                }
            }
        }

        return $winners;
    }

    public function getWinnersByProgram(): array
    {
        // Same logic as your Livewire component
        $winnersByProgram = [];
        // Fetch all programs (councils)
        $programs = Council::all();

        foreach ($programs as $program) {
            // Fetch positions for Local Council Election
            $positions = ElectionPosition::where('election_id', $this->election->id)
                ->whereHas('position.electionType', function ($q) {
                    $q->where('name', 'Local Council Election');
                })
                ->with('position')
                ->get();

            $winners = [];

            foreach ($positions as $position) {
                // Fetch council-specific settings for this position
                $councilPositionSettings = DB::table('council_position_settings')
                    ->where('position_id', $position->position->id)
                    ->where('council_id', $program->id)
                    ->first();

                // Determine if winners should be separated by major
                $separateByMajor = $councilPositionSettings ? $councilPositionSettings->separate_by_major : false;

                // Fetch the top N candidates for this position within the program
                $query = Candidate::where('election_position_id', $position->id)
                    ->whereHas('users.program.council', function ($q) use ($program) {
                        $q->where('id', $program->id);
                    })
                    ->with('users')
                    ->withCount('votes')
                    ->having('votes_count', '>', 0)
                    ->orderByDesc('votes_count');

                if ($separateByMajor) {
                    // Group candidates by major and select winners for each major
                    $candidatesByMajor = $query->get()->groupBy(function ($candidate) {
                        return $candidate->users->programMajor->name ?? 'No Major'; // Ensure programMajor exists
                    });

                    foreach ($candidatesByMajor as $major => $candidates) {
                        $sortedCandidates = $candidates->sortByDesc('votes_count')->take($position->position->num_winners);

                        foreach ($sortedCandidates as $candidate) {
                            $winners[] = [
                                'position' => $position->position->name,
                                'candidate' => $candidate,
                                'major' => $major,
                            ];
                        }
                    }
                } else {
                    // Select winners globally for the council (no separation by major)
                    $candidates = $query->take($position->position->num_winners)->get();

                    foreach ($candidates as $candidate) {
                        $winners[] = [
                            'position' => $position->position->name,
                            'candidate' => $candidate,
                            'major' => 'N/A',
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
            'studentCouncilWinners' => $this->studentCouncilWinners,
            'localCouncilWinners' => $this->localCouncilWinners,
            'election' => $this->election,
            'totalVoterVoted' => $this->totalVoterVoted,
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
