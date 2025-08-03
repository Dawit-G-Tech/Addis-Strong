<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['role_id' => 1, 'role_name' => 'user'],
            ['role_id' => 2, 'role_name' => 'member'],
            ['role_id' => 3, 'role_name' => 'trainer'],
            ['role_id' => 4, 'role_name' => 'staff'],
            ['role_id' => 5, 'role_name' => 'manager'],
        ]);
    }
}
