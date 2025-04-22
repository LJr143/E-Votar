<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TableUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct($data = null)
    {
        $this->data = $data ?? ['message' => 'Table updated at ' . now()];
    }

    public function broadcastOn()
    {
        return new Channel('table-updates');
    }

    public function broadcastWith(): array
    {
        return [
            'data' => $this->data,
            'server_time' => now()->toDateTimeString()
        ];
    }
}
