<?php

namespace App\Livewire\Superadmin;

use App\Models\Election;
use Livewire\Component;

class ElectionsTable extends Component
{
    public $elections;
    public $filter = 'all_elections';
    public $search = '';

    public function mount(): void
    {
        $this->fetchElections();
    }

    public function updatedSearch(): void
    {
        $this->fetchElections();
    }

    public function updatedFilter(): void
    {
        $this->fetchElections();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->fetchElections(); // Refetch elections when the filter changes
    }

    public function fetchElections(): void
    {
        // Start a query on the Election model
        $query = Election::query();

        // Apply search filter if the search term is not empty
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Apply status filter based on the selected filter
        if ($this->filter === 'ongoing_elections') {
            $query->where('status', 'ongoing');
        } elseif ($this->filter === 'completed_elections') {
            $query->where('status', 'completed');
        }

        // Execute the query and get the results
        $this->elections = $query->get();
    }

    public function render()
    {
        return view('evotar.livewire.superadmin.elections-table', [
            'elections' => $this->elections,
        ]);
    }
}
