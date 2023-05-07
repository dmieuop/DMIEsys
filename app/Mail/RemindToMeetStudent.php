<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RemindToMeetStudent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var array */
    public $body;

    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public function build(): \App\Mail\RemindToMeetStudent
    {
        return $this->subject('It\'s time to meet your students')->markdown('emails.remind-to-meet-student');
    }
}
