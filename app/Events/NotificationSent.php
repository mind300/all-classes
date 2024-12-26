<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($message, public $user_id)
    {
        $this->message = $message;
        $this->user_id = $user_id;
        
        Notification::create([
            'navigate' => 'chat',
            'user_id'=>$this->user_id,
            'name' => $this->message->member->first_name . ' ' . $this->message->member->last_name,
            'media' => $this->message->member->getMedia('member')?->first()?->getUrl(),
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notification.' . $this->user_id); // Ensures correct chat channel
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
                'navigate' => 'chat',
                'user_id' => $this->user_id,
                'name' => $this->message->member->first_name . ' ' . $this->message->member->last_name,
                'media' => $this->message->member->getMedia('member')?->first()?->getUrl(),
            ]
        ];
    }
}
