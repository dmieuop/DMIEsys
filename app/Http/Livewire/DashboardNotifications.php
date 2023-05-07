<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DashboardNotifications extends Component
{
    /** @var bool */
    public $hasNotifications;
    /** @var bool */
    public $hasUnreadNotifications;
    /** @var array */
    public $unread_notifications;
    /** @var int */
    public $unread_notifications_count = 0;
    /** @var \Illuminate\Notifications\DatabaseNotificationCollection|null */
    public $all_notifications = null;
    /** @var int */
    public $all_notifications_count = 0;
    /** @var int */
    public $notificationCount;

    /** @var array */
    protected $listeners = ['updateNotificationBadge' => 'mount'];

    /**
     * @return void
     */
    public function mount()
    {
        $this->hasNotifications = false;
        $this->hasUnreadNotifications = false;
        $this->unread_notifications = auth()->user()->unreadNotifications;
        if ($this->unread_notifications) $this->unread_notifications_count = $this->unread_notifications->count();
        $this->all_notifications = auth()->user()->notifications;
        $this->all_notifications_count = $this->all_notifications->count();
        if ($this->unread_notifications->count()) {
            $this->hasUnreadNotifications = true;
            $this->hasNotifications = true;
            $this->notificationCount = $this->unread_notifications->count();
        } elseif ($this->all_notifications->count()) {
            $this->hasUnreadNotifications = false;
            $this->hasNotifications = true;
        }
        $this->emit('updateNotificationBadge');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.dashboard-notifications');
    }

    /**
     * @param string $id
     * @return void
     */
    public function MarkAsRead(string $id)
    {
        foreach ($this->unread_notifications as $notifications) {
            if ($notifications->id == $id) {
                $notifications->markAsRead();
                break;
            }
        }
        $this->mount();
    }

    /**
     * @param string $id
     * @return void
     */
    public function Delete(string $id)
    {
        foreach ($this->all_notifications as $notifications) {
            if ($notifications->id == $id) {
                $notifications->delete();
                break;
            }
        }
        $this->mount();
    }

    /**
     * @return void
     */
    public function ReadAll()
    {
        foreach ($this->unread_notifications as $notifications) {
            $notifications->markAsRead();
        }
        $this->mount();
    }

    /**
     * @return void
     */
    public function DeleteAll()
    {
        foreach ($this->all_notifications as $notifications) {
            $notifications->delete();
        }
        $this->mount();
    }
}
