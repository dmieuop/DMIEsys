<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    public function run()
    {
        $roles = [
            'Super Admin',
            'System Admin',
            'Head of the Department',
            'Professor',
            'Senior Lecturer',
            'Lecturer',
            'Contract Basis Lecturer',
            'Probationary Lecturer',
            'Visiting Lecture',
            'Temporary Lecturer',
            'Management Assistant (DMIE)',
            'Management Assistant (PG)',
            'Research Assistant',
            'Temporary Instructor',
            'Instructor',
            'Technical Officer',
            'Instrument Mechanic',
            'Machine Operator',
            'Supporting Staff',
            'User',
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }
}
