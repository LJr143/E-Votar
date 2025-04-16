<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Feedback;
use App\Models\FeedbackToken;

class FeedbackForm extends Component
{
    public $name, $email, $rating = 0, $message, $token;

    public function submit()
    {
        $this->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'rating' => 'nullable|integer|min:1|max:5',
            'message' => 'required|string',
            'token' => 'required|string|exists:feedback_tokens,token',
        ]);

        // Find token and check if it's unused
        $feedbackToken = FeedbackToken::where('token', $this->token)->first();

        if ($feedbackToken->used) {
            session()->flash('error', 'This token has already been used.');
            return;
        }

        // Store feedback
        Feedback::create([
            'token' => $feedbackToken->token,
            'name' => $this->name,
            'email' => $this->email,
            'rating' => $this->rating,
            'message' => $this->message,
        ]);

        // Mark token as used
        $feedbackToken->update(['used' => true]);

        session()->flash('success', 'Thank you for your feedback!');
        $this->reset(['name', 'email', 'rating', 'message', 'token']);
    }

    public function render()
    {
        return view('evotar.livewire.feedback-form');
    }
}
