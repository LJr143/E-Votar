<?php

namespace App\Livewire\TechnicalOfficer;

use App\Events\UserActionUpdated;
use App\Models\User;
use App\Models\IpRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class BlockUser extends Component
{
    public User $user;
    public $password;

    public function mount($user_id): void
    {
        $this->user = User::findOrFail($user_id);
    }

    public function blockUser()
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


        // Log out the current user if they’re blocking themselves
        if ($this->user->id === auth()->id()) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route('login')->with('success', 'User blocked successfully.');
        }

        // Invalidate the target user's sessions
        DB::table('sessions')
            ->where('user_id', $this->user->id)
            ->delete();

        // Block the target user's IP
        $ipRecord = IpRecord::where('user_id', $this->user->id)->first();
        if ($ipRecord) {
            $ipRecord->update(['status' => 'blocked']);
        }

        // Flash success message and reset form
        session()->flash('success', 'User blocked successfully.');
        $this->password = '';

        // Dispatch events
        $this->dispatch('system-user-blocked');
    }

    public function render()
    {
        return view('evotar.livewire.technical-officer.block-user');
    }
}
