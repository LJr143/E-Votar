<?php

namespace App\Livewire\ManageProgram;

use App\Models\Campus;
use App\Models\Candidate;
use App\Models\College;
use App\Models\Election;
use App\Models\ElectionPosition;
use Livewire\Component;
use Livewire\WithPagination;

class ManageProgramTable extends Component
{
    use WithPagination;

    // Listens for events to refresh the component
    protected $listeners = ['program-created' => '$refresh', 'program-deleted' => '$refresh', 'program-updated' => '$refresh'];

    // Component properties
    public $filter = 'All Campus'; // Filter for election status
    public $search = ''; // Search term

    /**
     * Reset pagination when search is updated.
     */
    public function updatedSearch(): void
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
        // Get all campus names for dynamic filtering
        $campusList = Campus::select('name')->get();

        // Start a query on the Campus model
        $query = College::query()->with('programs');

        // Apply search filter
        $query = College::with('programs');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhereHas('programs', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('campus', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
        }


        // Apply campus filter
        if ($this->filter !== 'All Campus') {
            $query->whereHas('campus', function ($q) {
                $q->where('name', $this->filter);
            });
        }


        return view('evotar.livewire.manage-program.manage-program-table', [
            'colleges' => $query->paginate(10),
            'campusList' => $campusList,
        ]);
    }

}
