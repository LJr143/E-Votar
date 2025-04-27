<?php

namespace App\Livewire\AccountStatusManagement;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class UpdateFacialData extends Component
{
    public User $user;
    public string $password = '';

    public function mount($user_id): void
    {
        $this->user = User::findOrFail($user_id);
    }

    public function updateUserFaceData()
    {
        $this->validate([
            'password' => 'required|string',
        ]);

        if (!auth()->check()) {
            throw ValidationException::withMessages([
                'password' => ['You must be logged in to perform this action.'],
            ]);
        }

        if (!Hash::check($this->password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided password does not match your current password.'],
            ]);
        }

        try {

            $this->reset('password');

            $this->dispatch('update-user-face-data');

            // Get the previous URL and pass it as a query parameter
            $previousUrl = url()->previous();

            return redirect()->route('voter.facial.registration.get', [
                'id' => $this->user->id,
                'return_url' => $previousUrl,
            ]);

        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'password' => ['An error occurred while verifying the user: ' . $e->getMessage()],
            ]);
        }
    }

    public function render()
    {
        return view('evotar.livewire.update-facial-data');
    }
}
