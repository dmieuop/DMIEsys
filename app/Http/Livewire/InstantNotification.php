<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InstantNotification extends Component
{
    /** @var array */
    protected $listeners = ['showInstantNotification' => 'render'];

    /** @var bool */
    public $has_notification = false;
    /** @var string */
    public $notification = '';
    /** @var string */
    public $time = '';

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $all_unread_notification = auth()->user()->unreadNotifications;
        $recent_notification = $all_unread_notification
            ->where('created_at', '>=', now()->subSeconds(11)->toDateTimeString())->first();
        if ($recent_notification) {
            $this->has_notification = true;
            $this->notification = $recent_notification->data['text'];
            $this->time = $recent_notification->created_at->diffForHumans();
        } else {
            $this->has_notification = false;
            $this->notification = '';
            $this->time = '';
        }

        return view('livewire.instant-notification', [
            'has_notification' => $this->has_notification,
            'time' => $this->time,
            'notification' => $this->notification,
        ]);
    }
}
