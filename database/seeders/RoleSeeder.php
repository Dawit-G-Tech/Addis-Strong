<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['role_id' => 1, 'role_name' => 'user'],
            ['role_id' => 2, 'role_name' => 'member'],
            ['role_id' => 3, 'role_name' => 'trainer'],
            ['role_id' => 4, 'role_name' => 'staff'],
            ['role_id' => 5, 'role_name' => 'manager'],
            ['role_id' => 6, 'role_name' => 'admin'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['role_id' => $role['role_id']],
                ['role_name' => $role['role_name']]
            );
        }
    }
}
