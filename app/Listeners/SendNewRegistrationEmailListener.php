<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Created to work-around error: 
 * "Argument 1 passed to App\Listeners\SendEmailVerificationNotificationListener::handle() 
 * must be an instance of App\Events\EmailAddedEvent, 
 * instance of Illuminate\Auth\Events\Registered given"
 */
class SendNewRegistrationEmailListener
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
     *
     * Send email providing user with link to verify email address
     * from registration
     * 
     * "primary" is the only $event->type possible
     * 
     * @param  EmailAddedEvent  $event
     * @return void
     */
    public function handle(\App\Events\NewRegistrationEvent $event)
    {
        //SET VERIFICATION TOKEN
        $verifyUser = \App\VerifyUser::create([
            'user_id' => $event->student->person->user_id,
            'token' => sha1(time()),
        ]);
        
        //UPDATE PRIMARY EMAIL TO INCLUDE TOKEN
        $email = $event->student->person->emailPrimaryObject;
        $email->verified = $verifyUser->token;
        $email->save();
        
        \Illuminate\Support\Facades\Mail::to($event->student->person->emailPrimary)
            ->send(new \App\Mail\NewRegistrationMail(
                    $event->student, $verifyUser->token));
        
    }
}
