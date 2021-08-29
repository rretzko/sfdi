<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $person;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\User $user, \App\Person $person)
    {
        $this->person = $person;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.studentWelcome');
    }
}
