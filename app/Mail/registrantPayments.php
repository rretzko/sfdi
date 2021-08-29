<?php

namespace App\Mail;

use App\Registrant;
use App\School;
use App\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class registrantPayments extends Mailable
{
    use Queueable, SerializesModels;

    private $registrant;
    private $school;
    private $teacher;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Registrant $registrant, Teacher $teacher, School $school)
    {
        $this->registrant = $registrant;
        $this->school = $school;
        $this->teacher = $teacher;
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
        return $this->view('emails.registrantpayments')
                ->text('emails.registrantpayments_plain')
                ->with([
                    'registrant' => $this->registrant,
                    'school' => $this->school,
                    'teacher' => $this->teacher,
                ]);
    }
}
