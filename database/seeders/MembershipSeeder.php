<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Membership;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        Membership::insert([
            [
                'name' => 'Basic Plan',
                'duration_months' => 1,
                'price' => 30.00,
                'access_level' => 'Basic',
                'status' => 'active',
            ],
            [
                'name' => 'Standard Plan',
                'duration_months' => 3,
                'price' => 80.00,
                'access_level' => 'Standard',
                'status' => 'active',
            ],
            [
                'name' => 'Premium Plan',
                'duration_months' => 6,
                'price' => 150.00,
                'access_level' => 'Premium',
                'status' => 'active',
            ],
        ]);
    }
}
