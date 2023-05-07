<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeNewUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var array */
    public $body;

    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public function build(): \App\Mail\WelcomeNewUser
    {
        return $this->subject('Welcome to DMIEsys')->markdown('emails.newuser');
    }
}
