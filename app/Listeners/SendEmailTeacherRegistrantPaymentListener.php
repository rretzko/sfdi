<?php

namespace App\Listeners;

use App\Events\StudentAddedSchoolEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailTeacherRegistrantPaymentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *@todo add verified condition
     * @param  StudentAddedSchool  $event
     * @return void
     */
    public function handle(\App\Events\RegistrantPaymentEvent $event)
    {
        $members = $event->registrant->eventversion->event->organization->members;
        
        foreach($event->registrant->student->teachers AS $teacher){
        
            if($members->contains($teacher->person)){
                
                $email = $teacher->person->emailPrimary;
                
                Mail::to($email)->send(new \App\Mail\registrantPayments(
                   $event->registrant, $teacher, $event->registrant->school()));
            }
        }
    }
}
