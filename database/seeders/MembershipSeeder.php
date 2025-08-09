<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Membership;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        $memberships = [
            [
                'membership_id' => 1,
                'name' => 'Basic Plan',
                'duration_months' => 1,
                'price' => 30.00,
                'access_level' => 'Basic',
                'status' => 'active',
            ],
            [
                'membership_id' => 2,
                'name' => 'Standard Plan',
                'duration_months' => 3,
                'price' => 80.00,
                'access_level' => 'Standard',
                'status' => 'active',
            ],
            [
                'membership_id' => 3,
                'name' => 'Premium Plan',
                'duration_months' => 6,
                'price' => 150.00,
                'access_level' => 'Premium',
                'status' => 'active',
            ],
        ];

        foreach ($memberships as $membership) {
            Membership::updateOrCreate(
                ['membership_id' => $membership['membership_id']],
                $membership
            );
        }
    }
}
