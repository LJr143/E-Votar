<?php

namespace App\Http\Controllers;

use App\Models\AbstainVote;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Program;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $this->showCandidates();
    }
    public function showCandidates()
    {
        $candidates = $this->getCandidates();
        $elections = $this->getElection();

        return view('evotar.admin.dashboard', [
            'candidates' => $candidates,
            'elections' => $elections
        ]);
    }

    public function getElection()
    {
        $elections = Election::with(['campus', 'election_type'])->get(); // Ensure relationships are loaded

        if ($elections->isEmpty()) {
            \Log::error('No elections found in the database.');
        }

        return $elections;
    }


    public function getSelectedElection(Request $request)
    {

    }

    public function getCandidates()
    {
        $candidates = Candidate::all();

        return $candidates;
    }

    public function getLabels()
    {
        // Fetch user counts per program
        $votesPerProgram = $this->getVotesPerPrograms();

        // Extract program names (labels)
        $labels = $votesPerProgram->pluck('program_name')->toArray();

        // Generate dynamic colors based on the number of programs
        $colors = $this->generateColors(count($labels));

        // Extract user counts
        $votes = $votesPerProgram->pluck('user_count')->toArray();

        // Return the data as JSON
        return response()->json([
            'labels' => $labels,
            'colors' => $colors,
            'votes' => $votes,
        ]);
    }

    private function generateColors($count)
    {
        $colors = [];
        for ($i = 0; $i < $count; $i++) {
            // Generate a random hex color
            $colors[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }
        return $colors;
    }

    private function getVotesPerPrograms()
    {
        $selectedElectionId = session('selectedElection');

        // Fetch all programs
        $programs = Program::pluck('name', 'id');

        // Count regular votes per program
        $votesPerProgram = Vote::where('election_id', $selectedElectionId)
            ->join('users', 'votes.user_id', '=', 'users.id')
            ->selectRaw('users.program_id, count(distinct votes.user_id) as user_count')
            ->groupBy('users.program_id')
            ->pluck('user_count', 'program_id');

        // Count abstentions per program
        $abstentionsPerProgram = AbstainVote::where('election_id', $selectedElectionId)
            ->join('users', 'abstain_votes.user_id', '=', 'users.id')
            ->selectRaw('users.program_id, count(distinct abstain_votes.user_id) as abstention_count')
            ->groupBy('users.program_id')
            ->pluck('abstention_count', 'program_id');

        // Combine both counts
        $result = $programs->map(function ($programName, $programId) use ($votesPerProgram, $abstentionsPerProgram) {
            return [
                'program_name' => $programName,
                'voter_count' => $votesPerProgram->get($programId, 0) + $abstentionsPerProgram->get($programId, 0),
                'regular_votes' => $votesPerProgram->get($programId, 0),
                'abstentions' => $abstentionsPerProgram->get($programId, 0)
            ];
        });

        return $result;
    }
}
