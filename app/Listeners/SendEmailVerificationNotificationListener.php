<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailVerificationNotificationListener
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
     * 
     * @param  EmailAddedEvent  $event
     * @return void
     */
    public function handle(\App\Events\EmailAddedEvent $event)
    {
        $email_type = 'email'.ucfirst($event->type);

        if($event->person->$email_type){ //if an email of $event->type is found
        
            \Illuminate\Support\Facades\Mail::to($event->person->$email_type)
                ->send(new \App\Mail\VerifyEmail(
                        \App\User::find($event->person->user_id), $event->type));
        }
    }
}
