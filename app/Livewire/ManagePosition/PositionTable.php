<?php

namespace App\Livewire\ManagePosition;

use App\Models\Position;
use Livewire\Component;
use Livewire\WithPagination;

class PositionTable extends Component
{
    use WithPagination;

    protected $listeners = ['position-created' => '$refresh', 'position-edited' => '$refresh'];

    // Component properties
    public $filter = 'all_position';
    public $search = '';

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
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        // Start a query on the Position model
        $query = Position::query()->with('electionType');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->filter === 'all_position') {
            // Do not filter anything, return all positions
            $query->whereHas('electionType', function ($query) {
                $query->whereIn('name', [
                    'Student and Local Council Election',
                    'Student Council Election',
                    'Local Council Election',
                    'Special Election'
                ]);
            });
        } elseif ($this->filter === 'student_and_local_position') {
                $query->whereHas('electionType', function ($query) {
                    $query->where('name', 'Student and Local Council Election');
                });
            } elseif ($this->filter === 'student_position') {
                $query->whereHas('electionType', function ($query) {
                    $query->where('name', 'Student Council Election');
                });
            } elseif ($this->filter === 'local_position') {
                $query->whereHas('electionType', function ($query) {
                    $query->where('name', 'Local Council Election');
                });
            } elseif ($this->filter === 'special_position') {
                $query->whereHas('electionType', function ($query) {
                    $query->where('name', 'Special Election');
                });
            }


        return view('evotar.livewire.manage-position.position-table', [
            'positions' => $query->paginate(5),
        ]);
    }
}
