<?php

namespace App\Traits;

use App\Models\Log;
use App\Models\User;

trait System
{
    public function can(string $action): bool
    {
        $thisUser = User::find(auth()->user()->id);
        if ($thisUser->getRoleNames()[0] == 'Super Admin') return True;
        else if ($thisUser->hasPermissionTo($action)) return True;
        else return False;
    }

    public function canAny(array $action): bool
    {
        $thisUser = User::find(auth()->user()->id);
        if ($thisUser->getRoleNames()[0] == 'Super Admin') return True;
        else if ($thisUser->hasAnyPermission($action)) return True;
        else return False;
    }

    public function passed(string $message): void
    {
        Log::create([
            'action' => $message,
            'user' => auth()->user()->username,
        ]);
    }

    public function failed(object $th): void
    {
        Log::create([
            'action' => $th->getMessage(),
            'state' => 'failed',
            'user' => auth()->user()->username,
        ]);
    }
}
