<?php

namespace App\Livewire\ManageProgramMajor;

use App\Exports\ProgramExport;
use App\Exports\ProgramMajorExport;
use App\Models\Campus;
use App\Models\Program;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ManageProgramMajor extends Component
{use WithPagination;

    // Listens for events to refresh the component
    protected $listeners = ['program-major-created' => '$refresh', 'program-major-deleted' => '$refresh', 'program-major-updated' => '$refresh'];

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

    public function exportProgramMajors()
    {
        return Excel::download(
            new ProgramMajorExport($this->search, $this->filter),
            'PROGRAMS_MAJORS_LIST.xlsx'
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
        $query = Program::query()->with('majors', 'college.campus');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhereHas('majors', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('college.campus', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
        }


        // Apply campus filter
        if ($this->filter !== 'All Campus') {
            $query->whereHas('college.campus', function ($q) {
                $q->where('name', $this->filter);
            });
        }

        return view('evotar.livewire.manage-program-major.manage-program-major', [
            'programs' => $query->paginate(10),
            'campusList' => $campusList,
        ]);
    }
}
