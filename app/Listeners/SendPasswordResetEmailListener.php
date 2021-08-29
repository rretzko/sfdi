<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPasswordResetEmailListener
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
    public function handle(\App\Events\ResetPasswordRequestEvent $event)
    { 
        foreach($event->person->emails AS $email){
        
            if(strlen($email->email)){
            
            \Illuminate\Support\Facades\Mail::to($email->email)
                ->send(new \App\Mail\passwordResetEmail($event->person));
            }
        }
    }
}
