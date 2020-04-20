<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskLog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $content;
    public $user_id;
    public $task_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string  $content,int $user_id,int $task_id)
    {
        $this->content = $content;
        $this->user_id = $user_id;
        $this->task_id = $task_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
