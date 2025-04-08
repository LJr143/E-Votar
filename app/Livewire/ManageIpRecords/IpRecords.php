<?php

namespace App\Livewire\ManageIpRecords;

use App\Exports\ElectionsExport;
use App\Exports\IpRecordsExport;
use App\Models\IpRecord;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class IpRecords extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    protected $listeners = ['refreshIpRecords' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function exportIpRecords()
    {
        return Excel::download(new IpRecordsExport($this->search), 'LIST_OF_IP_RECORDS.xlsx');

    }

    public function render()
    {
        $ipRecords = IpRecord::query()
            ->whereNotNull('user_id') // 👈 Exclude guest records
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('ip_address', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('first_name', 'like', '%' . $this->search . '%')
                                ->orWhere('last_name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->with('user')
            ->orderBy('last_seen_at', 'desc')
            ->paginate($this->perPage);


        return view('evotar.livewire.manage-ip-records.ip-records', compact('ipRecords'));
    }
}
