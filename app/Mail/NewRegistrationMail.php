<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $token;
    public $user;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Student $student, $token)
    {
        $this->student = $student;
        $this->token = $token;
        $this->user = \App\User::find($student->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.newRegistration');
    }
}
