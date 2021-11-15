<?php

namespace App\Mail;

use App\Person;
use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class passwordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $uemail;
    private $users;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $users, string $uemail)
    {
        $this->uemail = $uemail;
        $this->users = $users;
    }

    /**
     * Build the message.
     *
     * uses global MAIL_FROM_ADDRESS and MAIL_FROM_NAME for "From" and "Reply-To"
     *
     * @return $this
     */
    public function build()
    {
        foreach ($this->users as $user) {

            $token = sha1(time());

            $pr = \App\PasswordResets::firstOrCreate([
                'email' => $this->uemail,
                'token' => $token,
            ]);
            $pr->save();

            return $this->view('emails.passwordReset')
                ->with([
                    'person' => $user['person'],
                    'user_name' => $user->username,
                    'token' => $token,
                ]);
        }
    }
}
