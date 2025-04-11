<?php

namespace App\Livewire\TechnicalOfficer;

use App\Events\IpRecordCreated;
use App\Models\IpRecord;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DeleteIpAddress extends Component
{
    public User $user;
    public $password;

    public function mount($user_id): void
    {
        $this->user = User::findOrFail($user_id);
    }

    public function deleteIpAddress()
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
            return redirect()->route('admin.login')->with('success', 'User blocked successfully.');
        }

        $ipRecord = IpRecord::where('user_id', $this->user->id)->first();

        if ($ipRecord) {
            $ipRecord->delete();

            // ✅ Fire the broadcast event before or after deletion
            Log::info('Broadcast on Deleted');
            event(new IpRecordCreated($ipRecord));
        }

        // Delete the target user's IP
        IpRecord::where('user_id', $this->user->id)->first()?->delete();

        // Invalidate the target user's sessions
        DB::table('sessions')
            ->where('user_id', $this->user->id)
            ->delete();

        // Flash success message and reset form
        session()->flash('success', 'IP address deleted successfully.');
        $this->reset();


        // Dispatch events
        $this->dispatch('ip-record-deleted');
    }

    public function render()
    {
        return view('evotar.livewire.technical-officer.delete-ip-address');
    }
}
