<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('chat.' . $this->message->chat_id); // Ensures correct chat channel
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
                'id' => $this->message->id,
                'member_id' => $this->message->member_id,
                'chat_id' => $this->message->chat_id,
                'message' => $this->message->message,
                'created_at' => $this->message->created_at,
            ]
        ];
    }
}
