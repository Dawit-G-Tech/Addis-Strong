<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        Staff::create([
            'staff_id' => 3, // Matches user_id in users table
            'hire_date' => now()->subYears(2),
            'salary' => 6000.00,
        ]);
    }
}
