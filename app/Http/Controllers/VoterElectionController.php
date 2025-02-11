<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\User;

class VoterElectionController extends Controller
{
    public function voterDashboard($slug)
    {
        $election = Election::where('slug', $slug)->firstOrFail();
        return view('evotar.voter.pages.dashboard', ['election_id' => $election->slug]);
    }

    public function voterElectionRedirect()
    {
        $voter = auth()->user();
        $elections = $this->getElectionsForVoter($voter->id);

        return view('evotar.voter.pages.voter-election-redirect', ['elections' => $elections, 'voter' => $voter]);
    }


    public function getElectionsForVoter($voterId)
    {
        if (!User::find($voterId)) {
            return collect();
        }

        return Election::whereNotIn('id', function ($query) use ($voterId) {
            $query->select('election_id')
                ->from('election_excluded_voters')
                ->where('user_id', $voterId);
        })->get();
    }

    public function getElectionEndTime($electionId = null)
    {
        $election = $electionId ? Election::find($electionId) : Election::latest()->first();

        if (!$election) {
            return response()->json(['error' => 'Election not found'], 404);
        }

        return response()->json([
            'start_time' => $election->date_started,
            'end_time' => $election->date_ended
        ]);
    }

    public function voting($slug)
    {
        $voter = auth()->user();
        $election = Election::where('slug', $slug)->firstOrFail();
        return view('evotar.voter.pages.voting-election-page', ['voter' => $voter, 'election' => $election, 'slug'=>$election->slug]);
    }

}
