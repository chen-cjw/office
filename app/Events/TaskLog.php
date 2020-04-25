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
    public $model_id;
    public $model_type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string  $content,int $user_id,int $model_id,string $model_type)
    {
        $this->content = $content;
        $this->user_id = $user_id;
        $this->model_id = $model_id;
        $this->model_type = $model_type;
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
