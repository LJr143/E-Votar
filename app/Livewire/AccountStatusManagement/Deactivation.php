<?php

namespace App\Livewire\AccountStatusManagement;

use App\Events\UserActionUpdated;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Deactivation extends Component
{
    public User $user;
    public string $password = '';

    public function mount($user_id): void
    {
        $this->user = User::findOrFail($user_id);
    }

    public function deactivateUser(): void
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

        if ($this->user->hasRole('superadmin')) {
            throw ValidationException::withMessages([
                'password' => ['Superadmin accounts cannot be deactivated.'],
            ]);
        }

        try {
            $this->user->update([
                'account_status' => 'Deactivated',
            ]);

            session()->flash('success', 'User deactivated successfully.');
            $this->reset('password');

            $this->dispatch('deactivated-user');
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'password' => ['An error occurred while deactivating the user: ' . $e->getMessage()],
            ]);
        }
    }

    public function render()
    {
        return view('evotar.livewire.account-status-management.deactivation');
    }
}
