<?php

namespace App\Livewire\ManageActiveUser;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ActiveUserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $perPage = 5;

    protected $listeners = ['refreshTable' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function selectUser($userId): void
    {
        $user = User::find($userId);

        if ($user) {
            $this->dispatch('userSelected', $user->id);
        }
    }
    public function getActiveUsersProperty(): array|\LaravelIdea\Helper\App\Models\_IH_User_C|\Illuminate\Pagination\LengthAwarePaginator
    {
        return User::whereIn('id', function ($query) {
            $query->select('user_id')
                ->from('sessions')
                ->whereNotNull('user_id')
                ->where('last_activity', '>=', now()->subMinutes(config('session.lifetime'))->timestamp);
        })->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'technical_officer');
        })
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate($this->perPage);
    }


    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-active-user.active-user-table', [
            'activeUsers' => $this->activeUsers,
        ]);
    }
}
