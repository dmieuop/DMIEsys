<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GeneralNotificationJust extends Notification
{
    use Queueable;

    /** @var string */
    public $message;

    public function __construct(string $text)
    {
        $this->message = $text;
    }

    public function via(): array
    {
        return ['database'];
    }

    public function toArray(): array
    {
        return [
            'text' => $this->message,
        ];
    }
}
