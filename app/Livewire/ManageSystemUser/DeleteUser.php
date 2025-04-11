<?php

namespace App\Livewire\ManageSystemUser;

use App\Events\UserActionUpdated;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DeleteUser extends Component
{
    public User $user;
    public $password;

    public function mount($user_id): void
    {
        $this->user = User::findOrFail($user_id);
    }

    public function deleteUser(): void
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


        // Prevent deletion of admin users
        if ($this->user->hasRole('superadmin')) {
            throw ValidationException::withMessages([
                'password' => 'You cannot delete superadmin account',
            ]);
        }

        // Revoke all permissions from the user
        foreach ($this->user->permissions as $permission) {
            $this->user->revokePermissionTo($permission);
        }

        $this->user->roles()->detach();

        session()->flash('success', 'User deleted successfully.');
        $this->password = '';

        event(new UserActionUpdated($this->user->id, 'deleted'));
        $this->dispatch( 'system-user-deleted');


    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-system-user.delete-user');
    }
}
