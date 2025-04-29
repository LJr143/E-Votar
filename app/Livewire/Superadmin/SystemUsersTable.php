<?php

namespace App\Livewire\Superadmin;

use App\Exports\SystemUserAdminExport;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class SystemUsersTable extends Component
{
    use WithPagination;

    protected $listeners = [
        'system-user-created' => '$refresh',
        'system-user-updated' => '$refresh',
        'system-user-deleted' => '$refresh',
    ];

    public $showEditModal = false;
    public $showDeleteModal = false;
    public $userId;
    public $filter = 'all_users';
    public $search = '';
    public $perPage = 10;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilter(): void
    {
        $this->resetPage();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function exportSystemUsers()
    {
        return Excel::download(
            new SystemUserAdminExport($this->search, $this->filter),
            'LIST_OF_SYSTEM_USERS_ADMINS.xlsx'
        );
    }

    public function render()
    {
        $query = User::query()
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', [
                    'superadmin', 'admin', 'technical_officer',
                    'student-council-watcher', 'local-council-watcher'
                ]);
            })
            ->where('id', '!=', auth()->id());

        if ($this->search) {
            $matchingUserIds = User::searchEncrypted($this->search, ['first_name', 'last_name'])
                ->pluck('id');
            $query->whereIn('id', $matchingUserIds);
        }

        switch ($this->filter) {
            case 'admin':
            case 'student-council-watcher':
            case 'local-council-watcher':
            case 'technical_officer':
                $query->whereHas('roles', fn($q) => $q->where('name', $this->filter));
                break;
            case 'all_users':
            default:
                break;
        }

        $users = $query->paginate($this->perPage);

        return view('evotar.livewire.superadmin.system-users-table', [
            'users' => $users,
        ]);
    }
}
