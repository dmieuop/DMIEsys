<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SetStudentAdvisor extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var array */
    public $body;

    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public function build(): \App\Mail\SetStudentAdvisor
    {
        return $this->subject('You have a new Academic advisor')->markdown('emails.set-student-advisor');
    }
}
