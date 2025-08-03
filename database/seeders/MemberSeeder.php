<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        Member::create([
            'member_id' => 2, // Matches user_id in users table
            'membership_id' => 1,
            'weight' => 70.5,
            'height' => 170.2,
        ]);
    }
}
