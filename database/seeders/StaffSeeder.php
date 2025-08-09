<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\User;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        // Check if the user exists first
        $user = User::where('email', 'trainer@gym.com')->first();
        
        if ($user) {
            Staff::updateOrCreate(
                ['staff_id' => $user->user_id],
                [
                    'hire_date' => now()->subYears(2),
                    'salary' => 6000.00,
                ]
            );
        }
    }
}
