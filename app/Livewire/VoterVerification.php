<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VoterVerification extends Component
{
    public $voter;
    public $document;
    public $statusMessage;

    public function mount()
    {

        $this->voter = Auth::user();
        if (!$this->voter->hasCompleteAcademicDetails()) {
            redirect()->route('academic.details');
        }
    }

    public function submitVerification()
    {
        $this->validate([
            'document' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $this->voter->update([
            'is_verified' => true,
            'verification_expires_at' => now()->addYear(), // Expires in 1 year
        ]);

        $this->statusMessage = 'Successfully verified for ' . now()->year;
    }
    public function render()
    {
        return view('evotar.livewire.voter-verification');
    }
}
