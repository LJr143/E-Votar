<?php

namespace App\Http\Controllers;

use App\Helpers\EncryptionHelper;
use App\Helpers\SteganographyHelper;
use App\Models\Election;
use App\Models\User;
use App\Models\VoterEncodeVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    public function confirmVoting()
    {
        // Fetch the latest encoded vote for the authenticated user
        $encodedVote = VoterEncodeVote::where('user_id', auth()->id())
            ->latest() // Get the most recent vote
            ->first();

        // Ensure the encoded vote exists
        if (!$encodedVote) {
            return redirect()->route('voter.dashboard')->with('error', 'No vote found to verify.');
        }

        // Pass the encoded vote to the view
        return view('evotar.voter.pages.vote-confirmation-page', [
            'encodedVote' => $encodedVote,
        ]);
    }

    public function showVerifyVotePage()
    {

        return view('evotar.voter.pages.verify-vote');
    }

    public function verifyVote(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'vote_image' => 'required|image|mimes:png,jpeg,jpg|max:2048', // Max 2MB
        ]);

        // Save the uploaded file temporarily
        $uploadedImage = $request->file('vote_image');
        $imagePath = $uploadedImage->store('temp', 'public');

        try {
            // Step 1: Extract the encrypted data from the image
            $imageFullPath = storage_path('app/public/' . $imagePath);
            $encryptedData = SteganographyHelper::decode($imageFullPath);

            if (empty($encryptedData)) {
                throw new \Exception('No encrypted data found in the image.');
            }

            // Debugging: Log the encrypted data
            Log::info('Encrypted Data from Image:', ['data' => $encryptedData]);

            // Step 2: Decrypt the data
            EncryptionHelper::setKey(config('app.stegano_secret_key'));
            $decryptedData = EncryptionHelper::decrypt($encryptedData);

            if (!$decryptedData) {
                throw new \Exception('Decryption failed. Data might be corrupted.');
            }

            // Debugging: Log the decrypted data
            Log::info('Decrypted Data:', ['data' => $decryptedData]);

            // Step 3: Decode the JSON data
            $voteData = json_decode($decryptedData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Failed to decode JSON: ' . json_last_error_msg());
            }

            // Delete the temporary file
            Storage::disk('public')->delete($imagePath);

            // Step 4: Return to the verification page with both encrypted and decrypted data
            return redirect()->route('verify.vote.page')->with([
                'success' => 'Vote verified successfully!',
                'encryptedData' => $encryptedData, // Display the encrypted data
                'voteData' => $voteData, // Display the decrypted data
            ]);
        } catch (\Exception $e) {
            // Delete the temporary file in case of an error
            Storage::disk('public')->delete($imagePath);

            // Log the error
            Log::error('Vote verification failed:', ['error' => $e->getMessage()]);

            return redirect()->route('verify.vote.page')->with('error', 'Failed to verify vote. Error: ' . $e->getMessage());
        }
    }

}
