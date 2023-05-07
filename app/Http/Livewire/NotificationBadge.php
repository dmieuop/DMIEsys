<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotificationBadge extends Component
{
    /** @var array */
    protected $listeners = ['updateNotificationBadge' => 'render'];

    public function render(): \Illuminate\View\View
    {
        $hasNoNotification = true;
        $notificationCount = '';
        $count = auth()->user()->unreadNotifications->count();
        if ($count > 9) {
            $hasNoNotification = false;
            $notificationCount = '9+';
        } elseif ($count > 0) {
            $hasNoNotification = false;
            $notificationCount = '0' . $count;
        } else {
            $hasNoNotification = true;
            $notificationCount = '';
        }
        return view('livewire.notification-badge', [
            'hasNoNotification' => $hasNoNotification,
            'notificationCount' => $notificationCount,
        ]);
    }
}
