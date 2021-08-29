<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\School;
use App\Student;

class StudentAddedSchoolEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $school;
    public $student;
    public $teachers;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(School $school, Student $student, array $teachers)
    {
        $this->school = $school;
        $this->student = $student;
        $this->teachers = $teachers;
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
