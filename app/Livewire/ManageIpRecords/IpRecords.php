<?php

namespace App\Livewire\ManageIpRecords;

use App\Models\IpRecord;
use Livewire\Component;
use Livewire\WithPagination;

class IpRecords extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['refreshIpRecords' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $ipRecords = IpRecord::query()
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('ip_address', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->with('user')
            ->orderBy('last_seen_at', 'desc')
            ->paginate(10);

        return view('evotar.livewire.manage-ip-records.ip-records', compact('ipRecords'));
    }
}
