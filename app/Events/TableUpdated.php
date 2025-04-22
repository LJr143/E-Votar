<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TableUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct($data = null)
    {
        $this->data = $data ?? ['message' => 'Table updated at ' . now()];
    }

    public function broadcastOn(): Channel
    {
        return new Channel('table-updates');
    }

    // Optional: Customize the broadcast name
    public function broadcastAs()
    {
        return 'table.updated';
    }

    // Optional: Fine-tune what gets broadcast
    public function broadcastWith()
    {
        return [
            'data' => $this->data,
            'server_time' => now()->toDateTimeString()
        ];
    }
}
