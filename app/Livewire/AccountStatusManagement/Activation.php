<?php

namespace App\Livewire\AccountStatusManagement;

use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Activation extends Component
{
    public User $user;
    public string $password = '';

    public function mount($user_id): void
    {
        $this->user = User::findOrFail($user_id);
    }

    public function activateUser(): void
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
                'account_status' => 'Active',
            ]);

            ActivityLogger::log(
                'User Activation',
                "User has activated - {$this->user->first_name}",
                $this->user,
                [
                    'activated_by' => auth()->user()->id ?? null,
                    'activation_time' => now()->toDateTimeString()
                ]
            );

            session()->flash('success', 'User activated successfully.');
            $this->reset('password');

            $this->dispatch('activated-user');
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'password' => ['An error occurred while deactivating the user: ' . $e->getMessage()],
            ]);
        }
    }
    public function render()
    {
        return view('evotar.livewire.account-status-management.activation');
    }
}
