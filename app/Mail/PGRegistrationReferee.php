<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PGRegistrationReferee extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var array */
    public $body;

    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public function build(): \App\Mail\PGRegistrationReferee
    {
        $applicantname = $this->body['applicantname'];
        return $this->subject('Referee report - ' . $applicantname)->markdown('emails.pg-registration-referee');
    }
}
