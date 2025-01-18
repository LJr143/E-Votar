<?php

namespace App\Livewire\ManageSystemUser;

use Livewire\Component;

class DeleteUser extends Component
{
    public $user_id;

    public function mount($user_id)
    {
        $this->$user_id = $user_id;
    }

    public function render()
    {
        return view('evotar.livewire.manage-system-user.delete-user');
    }
}
