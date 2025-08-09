<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@gym.com',
                'name' => 'Alice Smith',
                'gender' => 'Female',
                'dob' => '1990-01-01',
                'registration_date' => now(),
                'password' => Hash::make('password'),
                'role_id' => 1, // Admin
                'status' => 'Active',
            ],
            [
                'email' => 'member1@gym.com',
                'name' => 'John Doe',
                'gender' => 'Male',
                'dob' => '1995-04-10',
                'registration_date' => now(),
                'password' => Hash::make('password'),
                'role_id' => 2, // Member
                'status' => 'Active',
            ],
            [
                'email' => 'trainer@gym.com',
                'name' => 'Sara Kebede',
                'gender' => 'Female',
                'dob' => '1988-08-08',
                'registration_date' => now(),
                'password' => Hash::make('password'),
                'role_id' => 3, // Trainer
                'status' => 'Active',
            ]
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
