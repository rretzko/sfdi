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
        $emails = [];

        foreach($event->users AS $user) {

            if (strlen($user['person']['student']->emailPersonal)) {

                $emails[] = $user['person']['student']->emailPersonal;
            }

            if (strlen($user['person']['student']->emailSchool)) {

                $emails[] = $user['person']['student']->emailSchool;
            }
        }

        foreach(array_unique($emails) AS $uemail) {

            \Illuminate\Support\Facades\Mail::to('rretzko@hotmail.com') //$uemail
                ->send(new \App\Mail\passwordResetEmail($event->users, $uemail));
        }

    }
}
