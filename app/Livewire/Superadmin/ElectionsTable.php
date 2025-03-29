<?php

namespace App\Livewire\Superadmin;

use App\Models\Election;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class ElectionsTable extends Component
{
    use WithPagination;

    protected $listeners = [
        'election-created' => '$refresh',
        'election-deleted' => '$refresh'
    ];

    public $filter = 'all_elections';
    public $search = '';

    // Add debounce for search input (milliseconds)
    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q'],
        'filter' => ['except' => 'all_elections']
    ];


    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }


    public function render()
    {
        $query = Election::query()
            ->with('election_type')
            ->orderBy('created_at', 'desc');

        // Enhanced search functionality
        if ($this->search) {
            $query->where(function (Builder $query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('election_type', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('date_started', 'like', '%' . $this->search . '%')
                    ->orWhere('date_ended', 'like', '%' . $this->search . '%');
            });
        }

        // Status filter
        if ($this->filter === 'ongoing_elections') {
            $query->where('status', 'ongoing');
        } elseif ($this->filter === 'completed_elections') {
            $query->where('status', 'completed');
        }

        $elections = $query->paginate(10);

        return view('evotar.livewire.superadmin.elections-table', [
            'elections' => $elections,
            'hasResults' => $elections->total() > 0,
        ]);
    }
}
