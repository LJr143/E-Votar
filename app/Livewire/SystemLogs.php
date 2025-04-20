<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class SystemLogs extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedLogs = [];
    public $selectAll = false;
    protected $logs; // Add this property

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function exportSelected()
    {
        // Implement export functionality
    }

    public function updatedSelectAll($value): void
    {
        $this->selectedLogs = $value
            ? $this->getLogs()->pluck('id')->toArray()
            : [];
    }

    public function updatedSelectedLogs(): void
    {
        $this->selectAll = false;
    }

    public function deleteSelected(): void
    {
        ActivityLog::whereIn('id', $this->selectedLogs)->delete();
        $this->selectedLogs = [];
        session()->flash('message', 'Selected logs deleted successfully.');
    }

    protected function getLogs()
    {
        return ActivityLog::with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('action', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('first_name', 'like', '%'.$this->search.'%')
                                ->where('last_name', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('evotar.livewire.system-logs', [
            'logs' => $this->getLogs()
        ]);
    }
}
