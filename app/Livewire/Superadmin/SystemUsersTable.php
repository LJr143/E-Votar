<?php

namespace App\Livewire\Superadmin;

use App\Models\Election;
use App\Models\User;
use Livewire\Component;

class SystemUsersTable extends Component
{
    protected $listeners = ['election-created' => '$refresh'];
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
        // Start a query on the User model
        $query = User::query();

        // Apply role filter using whereHas
        $query->whereHas('roles', function ($q) {
            $q->whereIn('name', ['superadmin', 'admin', 'technical_officer', 'watcher']);
        });

        // Apply search filter if the search term is not empty
        if ($this->search) {
            $query->where('first_name', 'like', '%' . $this->search . '%');
        }

        // Apply status filter based on the selected filter
        if ($this->filter === 'all_users') {
            $query->whereHas('roles', function ($q) {
               $q->whereIn('name', ['superadmin', 'admin', 'technical_officer', 'watcher']);
            });
        }elseif ($this->filter === 'admin') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            });
        }
        elseif ($this->filter === 'watcher'){
            $query->whereHas('roles', function ($q) {
               $q->where('name', 'watcher');
            });
        }
        elseif ($this->filter === 'technical_officer'){
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'technical_officer');
            });
        }

        // Execute the query and get the results
        $this->users = $query->get();
    }
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.superadmin.system-users-table', [ 'users' => $this->users,]);
    }
}
