<?php

namespace App\Livewire\ManageSystemUser;

use App\Models\User;
use Livewire\Component;

class DeleteUser extends Component
{
    public User $user;


    public function mount($user_id)
    {
        $this->user = User::findOrFail($user_id);
    }

    public function deleteUser()
    {
        if ($this->user->exists) {
            $this->user->delete();

        }
    }

    public function render()
    {
        return view('evotar.livewire.manage-system-user.delete-user');
    }
}
