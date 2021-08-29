<?php

namespace App\Mail;

use App\Person;
use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class usernameReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $person;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
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
        return $this->view('emails.usernameReminder')
                ->with([
                    'person' => $this->person,
                    'username' => $this->person->user->name,
                ]);
    }
}
