<?php

namespace App\Mail;

use App\Person;
use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class newParentEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $person;
    private $student;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Person $person, Student $student)
    {
        $this->person = $person;
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * uses global MAIL_FROM_ADDRESS and MAIL_FROM_NAME for "From" and "Reply-To"
     * 
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.newParent')
                ->with([
                    'parent' => $this->person,
                    'student' => $this->student,
                    'user' => \App\User::find($this->student->user_id),
                ]);
    }
}
