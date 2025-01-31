<?php
namespace App\Livewire\ManageVoter;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class VoterTable extends Component
{
    use WithPagination;

    public string $filter = 'all_users';
    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function fetchUsers()
    {
        return User::whereHas('roles', function ($q) {
            $q->where('name', 'voter');
        })
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }

    public function render()
    {
        return view('evotar.livewire.manage-voter.voter-table', [
            'voters' => $this->fetchUsers(),
        ]);
    }
}
