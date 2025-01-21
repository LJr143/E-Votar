<?php

namespace App\Livewire\Superadmin;

use App\Models\Election;
use Livewire\Component;
use Livewire\WithPagination;

class ElectionsTable extends Component
{
    use WithPagination;

    // Listens for events to refresh the component
    protected $listeners = ['election-created' => 'refreshComponent'];

    // Component properties
    public $filter = 'all_elections'; // Filter for election status
    public $search = ''; // Search term

    /**
     * Reset pagination when search is updated.
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when filter is updated.
     */
    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Refresh the component when an election is created.
     */
    public function refreshComponent(): void
    {
        $this->resetPage();
    }

    /**
     * Render the Livewire component view.
     */
    public function render()
    {
        // Start a query on the Election model
        $query = Election::query()->with('election_type');

        // Apply search filter
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Apply status filter
        if ($this->filter === 'ongoing_elections') {
            $query->where('status', 'ongoing');
        } elseif ($this->filter === 'completed_elections') {
            $query->where('status', 'completed');
        }

        // Return the view with paginated results
        return view('evotar.livewire.superadmin.elections-table', [
            'elections' => $query->paginate(10),
        ]);
    }
}
