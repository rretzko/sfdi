<?php

namespace App\Listeners;

use App\User;
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
        foreach($event->emails AS $email) {

            $token = sha1(time());

            $user = User::find($email->user_id);

            if ($user->isStudent()){

                \Illuminate\Support\Facades\Mail::to($email->email)
                    ->send(new \App\Mail\passwordResetEmail($user, $email->email, $token));
            }else{

                dd(__METHOD__);
            }
        }

    }
}
