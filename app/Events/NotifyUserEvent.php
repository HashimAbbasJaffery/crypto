<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyUserEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $id;
    public $sender_id;
    public $message;
    public $username;
    public $photo;
    public function __construct(
        int $id, 
        int $sender_id, 
        string $message,
        string $username,
        string $photo
    )
    {
        $this->id = $id;
        $this->sender_id = $sender_id;
        $this->message = $message;
        $this->username = $username;
        $this->photo = $photo;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [ "channel-notify-" . $this->id ];
    }

    public function broadcastAs() {
        return "notifyUserEvent";
    }
}
