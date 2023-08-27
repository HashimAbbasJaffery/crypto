<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $id;
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function broadcastOn() {
        return [ "channel-" . $this->id ];
    }

    public function broadcastAs() {
        return "newMessageNotification";
    }
}
