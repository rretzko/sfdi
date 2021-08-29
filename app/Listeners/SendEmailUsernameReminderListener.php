<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailUsernameReminderListener
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
     * $event->userids = 
     *  array:1 [▼
     *   0 => {#1335 ▼
     *     +"user_id": "6706"
     *      }
     *    ]
     * @return void
     */
    public function handle(\App\Events\UsernameReminderEvent $event)
    {
        foreach($event->userids AS $userid){
     
            $person = \App\Person::find($userid->user_id);
            //always send to the primary email
            \Illuminate\Support\Facades\Mail::to($person->emailPrimary)
                ->send(new \App\Mail\usernameReminderEmail($person));
            
            //if available, also send to the alternate email 
            if(strlen($person->emailAlternate)){
                \Illuminate\Support\Facades\Mail::to($person->emailAlternate)
                ->send(new \App\Mail\usernameReminderEmail($person));
            }
        }
    }
}
