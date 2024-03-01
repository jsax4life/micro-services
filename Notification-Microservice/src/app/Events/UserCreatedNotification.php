<?php

namespace App\Events;

use App\User; 
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreatedNotification extends Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function broadcastOn()
    {
        return ['user-created']; 
    }

    /**
     * @param  mixed  $notifiable
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'user' => $this->user->toArray(), 
        ];
    }
}
