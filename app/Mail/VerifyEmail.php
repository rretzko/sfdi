<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $email; //email address displayed in the email
    public $person;
    public $type; //email type described in the email
    public $user;
    
    /**
     * Create a new message instance.
     *
     * @param string $type = primary or alternate
     * @return void
     */
    public function __construct(\App\User $user, $type='primary')
    {
        $emailtype = 'email'.ucfirst($type);
        $this->person = \App\Person::find($user->id);
        $this->email = $this->person->$emailtype;
        $this->type = $type;
        $this->user = $user;
    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verifyEmail');
    }
}
