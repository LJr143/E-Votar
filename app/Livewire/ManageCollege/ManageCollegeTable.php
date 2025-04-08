<?php

namespace App\Livewire\ManageCollege;

use App\Exports\CollegeExport;
use App\Models\Campus;
use App\Models\Candidate;
use App\Models\College;
use App\Models\Election;
use App\Models\ElectionPosition;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ManageCollegeTable extends Component
{
    use WithPagination;

    // Listens for events to refresh the component
    protected $listeners = ['college-created' => '$refresh', 'college-deleted' => '$refresh', 'college-updated' => '$refresh'];

    // Component properties
    public $filter = 'All Campus'; // Filter for election status
    public $search = ''; // Search term

    /**
     * Reset pagination when search is updated.
     */
    public function updatedSearch(): void
    {
        $this->resetPage(); // Ensure pagination resets when search changes
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

    public function exportColleges()
    {
        return Excel::download(
            new CollegeExport($this->search, $this->filter),
            'CAMPUS_COLLEGE_LIST.xlsx'
        );
    }

    /**
     * Render the Livewire component view.
     */
    public function render()
    {
        // Get all campus names for dynamic filtering
        $campusList = Campus::select('name')->get();

        // Start a query on the Campus model
        $query = Campus::query()->with('colleges');

        // Apply search filter
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhereHas('colleges', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
        }

        // Apply campus filter
        if ($this->filter !== 'All Campus') {
            $query->where('name', $this->filter);
        }

        return view('evotar.livewire.manage-college.manage-college-table', [
            'campuses' => $query->paginate(10),
            'campusList' => $campusList, // Pass all campus names for dynamic buttons
        ]);
    }

}
