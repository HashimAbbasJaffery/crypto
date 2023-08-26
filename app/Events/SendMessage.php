<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $sender_id;
    public $reciever_id;
    public $message;
    public function __construct(int $sender_id, int $reciever_id, string $message)
    {
        $this->sender_id = $sender_id;
        $this->reciever_id = $reciever_id;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $ids = [ $this->sender_id, $this->reciever_id ];
        sort($ids);
        return [ "channel-" . implode("-", $ids) ];
    }

    public function broadcastAs() {
        return "sendMessage";
    }
}
