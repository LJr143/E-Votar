<?php
namespace App\Livewire\ManageIpRecords;

use App\Exports\IpRecordsExport;
use App\Exports\SystemUserAdminExport;
use App\Models\IpRecord;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class IpRecords extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $refreshKey = 0;

    protected $listeners = [
        'ip-record-deleted' => '$refresh',
        'system-user-allowed' => '$refresh',
        'system-user-blocked' => '$refresh',
        'echo:user-logged-in,UserLoggedIn' => '$refresh'
    ];


    public function exportIpRecords()
    {
        return Excel::download(new IpRecordsExport($this->search), 'LIST_OF_IP_RECORDS_'. now() . '.xlsx');

    }

    public function render()
    {
        $ipRecords = IpRecord::query()
            ->whereNotNull('user_id')
            ->whereHas('user', function ($query) {
                $query->whereDoesntHave('roles', function ($q) {
                    $q->where('name', 'technical_officer');
                });
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('ip_address', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('first_name', 'like', "%{$this->search}%")
                                ->orWhere('last_name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->with('user')
            ->orderByDesc('last_seen_at')
            ->paginate($this->perPage);


        return view('evotar.livewire.manage-ip-records.ip-records', [
            'ipRecords' => $ipRecords
        ]);
    }
}
