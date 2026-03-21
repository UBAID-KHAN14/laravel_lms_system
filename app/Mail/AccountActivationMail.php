<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;


class AccountActivationMail extends Mailable
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Activate Your Account')
            ->view('emails.account-activation');
    }
}
