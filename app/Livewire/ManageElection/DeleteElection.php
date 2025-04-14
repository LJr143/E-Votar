<?php

namespace App\Livewire\ManageElection;

use App\Models\Election;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DeleteElection extends Component
{
    public Election $election;
    public $password;

    public function mount(int $electionId): void
    {
        $this->election = Election::findOrFail($electionId);
    }

    public function deleteElection(): void
    {
        $this->validate([
            'password' => 'required|string',
        ]);


        // Verify the provided password matches the user's password
        if (!Hash::check($this->password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'password' => 'The password does not match our records.',
            ]);
        }

        if (!$this->password) {
            throw ValidationException::withMessages([
                'password' => 'The password cannot be empty.',
            ]);
        }

        if ($this->election->exists) {
            $this->election->delete();
            $this->dispatch('election-deleted');

        }
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-election.delete-election');
    }
}
