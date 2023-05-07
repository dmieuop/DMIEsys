<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

trait CreatesUser
{
    /**
     * Creates the application.
     */
    public function createUser(String $permission = 'see notification', String $role = 'Test User'): User
    {
        Role::create([
            'name' => $role
        ]);

        Permission::create([
            'name' => $permission
        ]);

        $user = new User();
        $user->title = "Mr";
        $user->name = "TestUser";
        $user->username = Str::random(15);
        $user->email = Str::random(10) . "@email.com";
        $user->password = Hash::make('password');
        $user->newuser = 0;
        $user->active_status = 1;
        $user->save();
        $user->assignRole($role);
        $user->givePermissionTo($permission);

        return $user;
    }
}
