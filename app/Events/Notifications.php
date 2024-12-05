<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notifications
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public $member, public $message)
    {
        $this->member = $member;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('notifications.' . $this->member->user_id); // Ensures correct chat channel
    }

    /**
     * Customize the data broadcasted.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'content' => [
                'member' => $this->member->load('media.getUrl'),
                'message' => $this->message->message,
                'created_at' => $this->message->created_at,
            ]
        ];
    }
}
