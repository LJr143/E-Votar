<?php
namespace App\Livewire\ManageIpRecords;

use App\Exports\IpRecordsExport;
use App\Exports\SystemUserAdminExport;
use App\Models\IpRecord;
use App\Models\User;
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
                    // Search plaintext IP address (works normally)
                    $q->where('ip_address', 'like', "%{$this->search}%")

                        // Search encrypted user fields using your searchEncrypted method
                        ->orWhereHas('user', function ($userQuery) {
                            $matchingUserIds = User::searchEncrypted($this->search, ['first_name', 'last_name'])
                                ->pluck('id');
                            $userQuery->whereIn('id', $matchingUserIds);
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
