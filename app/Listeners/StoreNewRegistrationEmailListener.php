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
class StoreNewRegistrationEmailListener
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
        $missive = new \App\Missive;
        $missive->person = $event->student->person;
        $missive->template = 'sendNewRegistrationEmail';
        $missive->type = 'primary';
        $missive->add();
        $missive->save();
    }
    
}
