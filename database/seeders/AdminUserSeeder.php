<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            $this->command->warn('⚠️ Admin role not found. Run RoleSeeder first.');
            return;
        }

        User::updateOrCreate(
            ['email' => 'admin@churchhub.com'], // Search by email
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'), // Change later
                'role_id' => $adminRole->id,
            ]
        );
    }
}
