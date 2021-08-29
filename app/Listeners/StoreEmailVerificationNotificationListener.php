<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreEmailVerificationNotificationListener
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
     * Store the text of the email into the database as a Missive object
     * 
     * @param  EmailAddedEvent  $event
     * @return void
     */
    public function handle(\App\Events\EmailAddedEvent $event)
    {
        $email_type = 'email'.ucfirst($event->type);
             
        if($event->person->$email_type){
        
            \Illuminate\Support\Facades\Log::info(
                ucfirst($event->type).' email verification '
                . 'requested for: '
                . $event->person->fullName.' (id: '.$event->person->user_id.') ');
        
            $missive = new \App\Missive;
            $missive->person = $event->person;
            $missive->template = 'sendEmailVerificationNotification';
            $missive->type = $event->type;
            $missive->add();
            $missive->save();
        }
    }
}
