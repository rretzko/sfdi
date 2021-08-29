<?php

namespace App\Listeners;

use App\Mail\usernameReminderEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

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
        foreach($event->emails AS $email){

            $person = \App\Person::find($email->user_id);

            Mail::to($email->email)
                ->send(new usernameReminderEmail($person));
        }
    }
}
