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

    private $email;
    private $token;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\User $user, string $email, string $token)
    {
        $this->email = $email;
        $this->token = $token;
        $this->user = $user;
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
        $pr = \App\PasswordResets::firstOrCreate([
            'email' => $this->email,
            'token' => $this->token,
            'user_id' => $this->user->id,
        ]);

        $pr->save();

        return $this->view('emails.passwordReset')
            ->with([
                'person' => $this->user['person'],
                'user_name' => $this->user->username,
                'token' => $this->token,
            ]);
    }
}
