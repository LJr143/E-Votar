<?php

namespace App\Http\Controllers;

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
        $programs = Program::pluck('name', 'id'); // Get all programs with their IDs and names

        // Fetch the count of distinct users who voted for each program in the selected election
        $votesPerProgram = Vote::where('election_id', $selectedElectionId)
            ->join('users', 'votes.user_id', '=', 'users.id') // Join the users table
            ->selectRaw('users.program_id, count(distinct votes.user_id) as user_count')
            ->groupBy('users.program_id')
            ->pluck('user_count', 'program_id'); // Get the user count per program

        // Map all programs and include those with zero votes
        $result = $programs->map(function ($programName, $programId) use ($votesPerProgram) {
            return [
                'program_name' => $programName,
                'user_count' => $votesPerProgram->get($programId, 0), // Default to 0 if no votes exist
            ];
        });

        return $result;
    }
}
