<?php
namespace App\Livewire\ManageVoter;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class VoterTable extends Component
{
    use WithPagination;
    protected $listeners  = ['voter-updated' => '$refresh'];

//    public string $filter = 'all_users';
    public string $search = '';
    public $perPage = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

//    public function updatingFilter(): void
//    {
//        $this->resetPage();
//    }
//
//    public function setFilter(string $filter): void
//    {
//        $this->filter = $filter;
//        $this->resetPage();
//    }

    public function fetchUsers(): array|\LaravelIdea\Helper\App\Models\_IH_User_C|\Illuminate\Pagination\LengthAwarePaginator
    {
        $user = User::whereHas('roles', function ($q) {
            $q->where('name', 'voter');
        })
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%');
            });

        if ($this->perPage === 'all') {
            return User::all();
        }else{
            return $user->paginate($this->perPage);
        }

    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-voter.voter-table', [
            'voters' => $this->fetchUsers(),
        ]);
    }
}
