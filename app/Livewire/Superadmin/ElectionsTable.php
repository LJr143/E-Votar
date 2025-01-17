<?php

namespace App\Livewire\Superadmin;

use App\Models\Election;
use Livewire\Component;
use Livewire\WithPagination;

class ElectionsTable extends Component
{
    use WithPagination;

    protected $listeners = ['election-created' => '$refresh'];
    public $filter = 'all_elections';
    public $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage(); // Reset to the first page when search changes
    }

    public function updatingFilter(): void
    {
        $this->resetPage(); // Reset to the first page when filter changes
    }

    public function fetchElections()
    {
        // Fetching logic is now part of the render method using pagination.
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $query = Election::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->filter === 'ongoing_elections') {
            $query->where('status', 'ongoing');
        } elseif ($this->filter === 'completed_elections') {
            $query->where('status', 'completed');
        }

        return view('evotar.livewire.superadmin.elections-table', [
            'elections' => $query->paginate(10),
        ]);
    }
}
