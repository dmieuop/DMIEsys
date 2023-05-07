<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SetAMeetingWithStudent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var array */
    public $body;

    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public function build(): \App\Mail\SetAMeetingWithStudent
    {
        return $this->subject('A Meeting with your Advisor')->markdown('emails.set-a-meeting-with-student');
    }
}
