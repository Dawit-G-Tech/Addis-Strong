<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\User;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        // Check if the user exists first
        $user = User::where('email', 'member1@gym.com')->first();
        
        if ($user) {
            Member::updateOrCreate(
                ['member_id' => $user->user_id],
                [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'phone' => '0911000002',
                    'address' => 'Addis Ababa',
                    'membership_id' => 1,
                    'weight' => 70.5,
                    'height' => 170.2,
                ]
            );
        }
    }
}
