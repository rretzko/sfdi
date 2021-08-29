<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParentAttachedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $person;
    public $student;

    /**
     * Create a new event instance.
     *
     * @param Person $person
     * @param string $type = alternate or primary
     * @return void
     */
    public function __construct(\App\Person $person, \App\Student $student)
    {
        $this->person = $person;
        $this->student = $student;
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
