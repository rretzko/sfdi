<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailStudentWelcomeListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(\App\Events\PrimaryEmailVerifiedEvent $event)
    {
        $person = \App\Person::find($event->user->id);
        
        \Illuminate\Support\Facades\Log::info('Primary email verified for: '
                . $person->fullName.' (id: '.$event->user->id.') ');
        
        \Illuminate\Support\Facades\Mail::to($person->emailPrimary)
                ->send(new \App\Mail\studentWelcome($event->user, $person));
        
    }
}
