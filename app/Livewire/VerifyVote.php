<?php

namespace App\Livewire;

use App\Models\VoterEncodeVote;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Helpers\SteganographyHelper;
use App\Helpers\EncryptionHelper;
use Illuminate\Support\Facades\Storage;

class VerifyVote extends Component
{
    public $voteId;
    public $password = '';
    public $encryptedData;
    public $voteData;
    public $error;
    public $success;
    public $user;

    public function mount($voteId)
    {
        $this->user = auth()->user();
        $this->voteId = $voteId;
    }

    public function verifyVote()
    {
        $this->reset(['error', 'success', 'encryptedData', 'voteData']);

        try {
            // Get the encoded vote record
            $encodedVote = VoterEncodeVote::findOrFail($this->voteId);

            // Verify the voter owns this vote
            if (auth()->id() !== $encodedVote->user_id) {
                throw new \Exception('You can only verify your own votes.');
            }

            // Verify the password
            if (!Hash::check($this->password, $this->user->password)) {
                throw new \Exception('Invalid verification password.');
            }

            // Get the image path
            $imagePath = storage_path('app/public/' . $encodedVote->encoded_image_path);

            if (!file_exists($imagePath)) {
                throw new \Exception('Vote receipt image not found.');
            }

            // Extract encrypted data from image
            $encryptedData = SteganographyHelper::decode($imagePath);

            if (empty($encryptedData)) {
                throw new \Exception('No encrypted data found in the image.');
            }

            // Decrypt the data
            EncryptionHelper::setKey(config('app.stegano_secret_key'));
            $decryptedData = EncryptionHelper::decrypt($encryptedData);

            if (!$decryptedData) {
                throw new \Exception('Decryption failed. Data might be corrupted.');
            }

            $voteData = json_decode($decryptedData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Failed to decode vote data.');
            }

            // Update component properties
            $this->encryptedData = $encryptedData;
            $this->voteData = $voteData;
            $this->success = 'Vote verified successfully!';

        } catch (\Exception $e) {
            $this->error = 'Verification failed: ' . $e->getMessage();
            logger()->error('Vote verification failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function render()
    {
        return view('evotar.livewire.verify-vote');
    }
}
