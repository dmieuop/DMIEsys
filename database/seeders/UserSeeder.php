<?php

namespace Database\Seeders;

use App\Models\ModelHasRole;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'SuperAdmin',
            'title' => 'Mr',
            'username' => 'admin',
            'email' => 'superadmin@email.com',
            'newuser' => 0,
            'password' => Hash::make('password'),
            'hidden' => 1,
        ]);

        $user2 = User::create([
            'name' => 'HeadOfDepartment',
            'title' => 'Mr',
            'username' => 'head',
            'email' => 'hod@email.com',
            'newuser' => 0,
            'password' => Hash::make('password'),
        ]);

        $user1->assignRole('Super Admin');
        $user2->assignRole('Head of the Department');
    }
}
