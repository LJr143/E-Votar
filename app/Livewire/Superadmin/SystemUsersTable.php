<?php

namespace App\Livewire\Superadmin;

use App\Exports\SystemUserAdminExport;
use App\Models\User;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class SystemUsersTable extends Component
{
    protected $listeners = ['system-user-created' => '$refresh', 'system-user-updated'=>'$refresh', 'system-user-deleted' => '$refresh'];
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $userId;
    public $users;
    public $filter = 'all_users';
    public $search = '';

    public function mount(): void
    {
        $this->fetchUsers();
    }

    public function updatedSearch(): void
    {
        $this->fetchUsers();
    }

    public function updatedFilter(): void
    {
        $this->fetchUsers();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->fetchUsers();
    }


    public function fetchUsers(): void
    {
        $query = User::query();

        $query->whereHas('roles', function ($q) {
            $q->whereIn('name', ['superadmin', 'admin', 'technical_officer', 'watcher']);
        });

        if ($this->search) {
            $query->where('first_name', 'like', '%' . $this->search . '%');
        }

        if ($this->filter === 'all_users') {
            $query->whereHas('roles', function ($q) {
                $q->whereIn('name', ['superadmin', 'admin', 'technical_officer', 'watcher']);
            });
        } elseif ($this->filter === 'admin') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            });
        } elseif ($this->filter === 'watcher') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'watcher');
            });
        } elseif ($this->filter === 'technical_officer') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'technical_officer');
            });
        }

        $this->users = $query->get();
    }


    public function exportSystemUsers()
    {
        return Excel::download(new SystemUserAdminExport($this->search, $this->filter), 'LIST_OF_SYSTEM_USERS_ADMINS.xlsx');

    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $this->fetchUsers();
        return view('evotar.livewire.superadmin.system-users-table', ['users' => $this->users,]);
    }
}
