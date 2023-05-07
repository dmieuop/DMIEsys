<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $academicPermissions = [
            'add base course',
            'see base course',
            'edit base course',
            'delete base course',
            'add course',
            'see course',
            'edit course',
            'delete course',
            'add mark',
            'see mark',
            'edit mark',
            'delete mark',
            'add student',
            'see student',
            'edit student',
            'delete student',
            'add student advisor',
            'student counselor',
            'add advisory comments',
            'see attainment report',
            'see ilo achievement',
        ];

        $laboratoryPermissions = [
            'add laboratory',
            'see laboratory',
            'edit laboratory',
            'delete laboratory',
            'add machine',
            'see machine',
            'edit machine',
            'delete machine',
            'add maintenance',
            'update maintenance',
            'see maintenance',
            'edit maintenance',
            'delete maintenance',
            'do maintenance',
            'add inventory',
            'see inventory',
            'edit inventory',
            'delete inventory',
        ];

        $hrPermissions = [];
        $financePermissions = [];

        $generalPermissions = [
            'manage dmielib',
            'see dmielib',
            'access dmielib',
            'see pg registration',
            'add user',
            'see user',
            'edit user',
            'deactivate user',
            'change user permission',
            'change user role',
            'add new hod',
            'set pg registration',
            'see logs',
        ];

        $otherPermissions = [
            'see notification',
            'can chat',
            'see calender',
            'update profile picture'
        ];

        foreach ($academicPermissions as $permission) Permission::create(['name' => $permission]);
        foreach ($laboratoryPermissions as $permission) Permission::create(['name' => $permission]);
        foreach ($hrPermissions as $permission) Permission::create(['name' => $permission]);
        foreach ($financePermissions as $permission) Permission::create(['name' => $permission]);
        foreach ($generalPermissions as $permission) Permission::create(['name' => $permission]);
        foreach ($otherPermissions as $permission) Permission::create(['name' => $permission]);
    }
}
