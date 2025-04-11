<?php

namespace App\Livewire\TechnicalOfficer;

use App\Models\IpRecord;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class UnblockUser extends Component
{
    public User $user;
    public $password;

    public function mount($user_id): void
    {
        $this->user = User::findOrFail($user_id);
    }

    public function unblockUser()
    {
        $this->validate([
            'password' => 'required|string',
        ]);

        // Verify the provided password matches the authenticated user's password
        if (!Hash::check($this->password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'password' => 'The password does not match our records.',
            ]);
        }

        // Prevent blocking superadmin users
        if ($this->user->hasRole('superadmin')) {
            throw ValidationException::withMessages([
                'password' => 'You cannot block a superadmin account.',
            ]);
        }



        // Allow the target user's IP
        $ipRecord = IpRecord::where('user_id', $this->user->id)->first();
        if ($ipRecord) {
            $ipRecord->update(['status' => 'allowed']);
        }

        // Flash success message and reset form
        session()->flash('success', 'User allowed successfully.');
        $this->reset();

        // Dispatch events
        $this->dispatch('system-user-allowed');
    }
    public function render()
    {
        return view('evotar.livewire.technical-officer.unblock-user');
    }
}
