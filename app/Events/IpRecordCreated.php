<?php

namespace App\Events;

use App\Models\IpRecord;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class IpRecordCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ipRecord;

    public function __construct(IpRecord $ipRecord)
    {
        $this->ipRecord = $ipRecord;
        Log::info('IpRecordCreated event constructed', [
            'ip_record_id' => $ipRecord->id,
            'ip_address' => $ipRecord->ip_address,
            'user_id' => $ipRecord->user_id,
        ]);
    }

    public function broadcastOn(): array
    {
        Log::info('IpRecordCreated broadcasting on channel: ip-records');
        return [new Channel('ip-records')];
    }

    public function broadcastWith(): array
    {
        $data = [
            'id' => $this->ipRecord->id,
            'ip_address' => $this->ipRecord->ip_address,
            'user_id' => $this->ipRecord->user_id,
            'status' => $this->ipRecord->status,
            'last_seen_at' => $this->ipRecord->last_seen_at->toDateTimeString(),
            'user' => $this->ipRecord->user ? [
                'first_name' => $this->ipRecord->user->first_name,
                'last_name' => $this->ipRecord->last_name,
            ] : null,
        ];
        Log::info('IpRecordCreated broadcast data', $data);
        return $data;
    }

    public function broadcastAs(): string
    {
        Log::info('IpRecordCreated broadcast as: IpRecordCreated');
        return 'IpRecordCreated';
    }
}
