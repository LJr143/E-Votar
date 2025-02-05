<?php

namespace App\Livewire\ManageActiveUser;

use App\Models\User;
use Livewire\Component;

class ActiveUserCard extends Component
{
    public $userSelected;

    protected $listeners = ['userSelected' => 'loadUser'];

    public function loadUser($userId)
    {
        $this->userSelected = User::find($userId);
    }

    public function blockUser($userId){
        $this->userSelected = User::find($userId);

    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-active-user.active-user-card');
    }
}
