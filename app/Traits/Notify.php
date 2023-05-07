<?php

namespace App\Traits;

use App\Models\User;
use App\Notifications\GeneralNotification;
use App\Notifications\GeneralNotificationJust;
use Illuminate\Support\Facades\Notification;

trait Notify
{
    public function notifyHOD(string $message): void
    {
        $users = User::all();
        foreach ($users as $user) {
            if ($user->hasRole('Head of the Department')) {
                Notification::send($user, new GeneralNotificationJust($message));
            }
        }
    }

    public function notifyAll(string $message): void
    {
        $users = User::all();
        foreach ($users as $user) {
            Notification::send($user, new GeneralNotification($message));
        }
    }

    public function notifyTechnicalStaff(string $message): void
    {
        $users = User::all();
        foreach ($users as $user) {
            if ($user->hasRole(['Technical Officer', 'Instrument Mechanic', 'Machine Operator'])) {
                Notification::send($user, new GeneralNotification($message));
            }
        }
    }

    public function notifyOffice(string $message): void
    {
        $users = User::all();
        foreach ($users as $user) {
            if ($user->hasRole('Management Assistant (DMIE)')) {
                Notification::send($user, new GeneralNotificationJust($message));
            }
        }
    }

    public function notifyAcademicStaff(string $message): void
    {
        $users = User::all();
        foreach ($users as $user) {
            if ($user->hasRole(['Head of the Department', 'Professor', 'Senior Lecturer', 'Lecturer', 'Contract Basis Lecturer', 'Probationary Lecturer', 'Visiting Lecture', 'Temporary Lecturer', 'Temporary Instructor', 'Instructor'])) {
                Notification::send($user, new GeneralNotification($message));
            }
        }
    }

    public function notifyLecturers(string $message): void
    {
        $users = User::all();
        foreach ($users as $user) {
            if ($user->hasRole(['Head of the Department', 'Professor', 'Senior Lecturer', 'Lecturer', 'Contract Basis Lecturer', 'Probationary Lecturer', 'Visiting Lecture', 'Temporary Lecturer'])) {
                Notification::send($user, new GeneralNotification($message));
            }
        }
    }

    public function notifySelf(string $message): void
    {
        $user = User::find(auth()->user()->id)->first();
        Notification::send($user, new GeneralNotificationJust($message));
    }

    public function notifyUser(object $user, string $message): void
    {
        Notification::send($user, new GeneralNotificationJust($message));
    }

    public function notifyUsers(object $users, string $message, bool $otherCondition = true, int $exceptUserId = 10000): void
    {
        foreach ($users as $user) {
            if ($user->id != $exceptUserId && $otherCondition) {
                Notification::send($user, new GeneralNotification($message));
            }
        }
    }
}
