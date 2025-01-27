<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserActionUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $action;

    public function __construct($user, $action)
    {
        $this->user = $user;
        $this->action = $action;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('user-actions');
    }

    public function broadcastWith(): array
    {
        return [
            'user' => $this->user,
            'action' => $this->action,
        ];
    }
}
