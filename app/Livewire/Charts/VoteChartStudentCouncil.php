<?php

namespace App\Livewire\Charts;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\User;
use Livewire\Component;

class VoteChartStudentCouncil extends Component
{
    public $electionId;
    protected $listeners = ['updateChartData' => 'updateChart'];
    public $totalVoters, $totalVoterVoted;

    public function mount($electionId): void
    {
        $this->electionId = $electionId;
        $this->loadChartData();
        $this->fetchVoterTally();
    }

    public function updateChart($electionId): void
    {
        $this->electionId = $electionId;
        $this->loadChartData();
        $this->fetchVoterTally();
    }

    public function fetchVoterTally(): void
    {
        $election = Election::find($this->electionId);
        if ($election) {
            // Fetch total voters for the selected council
            $this->totalVoters = User::where('campus_id', $election->campus_id)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'voter');
                })
                ->whereDoesntHave('electionExcludedVoters', function ($query) use ($election) {
                    $query->where('election_id', $election->id);
                })
                ->count();

            // Fetch total voters who voted for the selected council
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

    public function loadChartData(): void
    {
        $election = Election::findOrFail($this->electionId);

        // Filter positions by councilType
        $electionPositions = ElectionPosition::where('election_id', $this->electionId)
            ->with('position.electionType')
            ->whereHas('position.electionType', function ($query) {
                $query->where('name', 'Student Council Election');
            })
            ->get();

        // Get positions as labels (x-axis)
        $labels = $electionPositions->pluck('position.name')->toArray();

        $totalVoters = User::where('campus_id', $election->campus_id)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'voter');
            })
            ->whereDoesntHave('electionExcludedVoters', function ($query) use ($election) {
                $query->where('election_id', $election->id);
            })
            ->count();

        // Get candidates for the filtered positions
        $candidates = Candidate::whereIn('election_position_id', $electionPositions->pluck('id'))
            ->with(['users', 'election_positions.position', 'votes'])
            ->get();

        $datasets = [];

        foreach ($candidates as $candidate) {
            $positionName = $candidate->election_positions->position->name;
            $candidateName = $candidate->users->first_name . ' ' . $candidate->users->last_name;

            // Initialize dataset for this candidate with zeros for all positions
            $data = array_fill(0, count($labels), 0);

            // Count actual votes from the `votes` table
            $voteCount = $candidate->votes->count();

            // Set the vote count for the candidate's actual position
            $positionIndex = array_search($positionName, $labels);
            if ($positionIndex !== false) {
                $data[$positionIndex] = $voteCount;
            }

            $datasets[] = [
                'label' => $candidateName,
                'data' => $data,
                'backgroundColor' => 'rgba(' . rand(50, 255) . ',' . rand(50, 255) . ',' . rand(50, 255) . ', 1)',
                'borderColor' => 'rgba(0, 0, 0, 1)',
                'borderWidth' => 1,
            ];
        }

        // If no candidates, show a placeholder dataset
        if (empty($datasets)) {
            $datasets[] = [
                'label' => 'No Candidates',
                'data' => array_fill(0, count($labels), 0),
                'backgroundColor' => 'rgba(200, 200, 200, 0.5)',
                'borderColor' => 'rgba(200, 200, 200, 1)',
                'borderWidth' => 1,
            ];
        }

        logger()->info("📊 Chart Data Sent: ", ['labels' => $labels, 'datasets' => $datasets]);

        $this->dispatch('chartStudentCouncilUpdated', [
            'labels' => $labels,
            'datasets' => $datasets,
            'totalVoters' => $totalVoters,
        ]);
    }

    public function render()
    {
        return view('evotar.livewire.charts.vote-chart-student-council');
    }
}
