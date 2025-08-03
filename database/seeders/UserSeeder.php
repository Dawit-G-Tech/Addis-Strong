<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'first_name' => 'Alice',
                'last_name' => 'Smith',
                'email' => 'admin@gym.com',
                'phone' => '0911000001',
                'gender' => 'Female',
                'dob' => '1990-01-01',
                'address' => 'Addis Ababa',
                'hashed_password' => Hash::make('password'),
                'role_id' => 1, // Admin
                'status' => 'Active',
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'member1@gym.com',
                'phone' => '0911000002',
                'gender' => 'Male',
                'dob' => '1995-04-10',
                'address' => 'Addis Ababa',
                'hashed_password' => Hash::make('password'),
                'role_id' => 2, // Member
                'status' => 'Active',
            ],
            [
                'first_name' => 'Sara',
                'last_name' => 'Kebede',
                'email' => 'trainer@gym.com',
                'phone' => '0911000003',
                'gender' => 'Female',
                'dob' => '1988-08-08',
                'address' => 'Addis Ababa',
                'hashed_password' => Hash::make('password'),
                'role_id' => 3, // Trainer
                'status' => 'Active',
            ]
        ]);
    }
}
