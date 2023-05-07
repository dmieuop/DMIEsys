<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestExternalUserAccessToken extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $body;


    public function __construct(array $body)
    {
        $this->body = $body;
    }


    public function envelope()
    {
        return new Envelope(
            subject: 'Request to update profile',
        );
    }


    public function content()
    {
        return new Content(
            markdown: 'emails.request-external-user-access-token',
        );
    }


    public function attachments()
    {
        return [];
    }
}
