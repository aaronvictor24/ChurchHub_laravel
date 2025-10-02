<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Church;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call role & admin seeders
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
        ]);

        // ✅ Ensure at least one church exists
        $church = Church::first() ?? Church::create([
            'name'    => 'Main Church',
            'address' => 'Default Address',
        ]);

        // ✅ Get the secretary role
        $secretaryRole = Role::where('name', 'secretary')->first();

        // ✅ Create a secretary user if not exists
        if ($secretaryRole && !User::where('email', 'secretary@example.com')->exists()) {
            User::create([
                'name'      => 'Secretary One',
                'email'     => 'secretary@example.com',
                'password'  => Hash::make('password'),
                'role_id'   => $secretaryRole->id,
                'church_id' => $church->id,
            ]);
        }

        // ✅ Safe test user (only if not already exists)
        if (!User::where('email', 'test@example.com')->exists()) {
            User::firstOrCreate(
                ['email' => 'test@example.com'],
                [
                    'name' => 'Test User',
                    'password' => bcrypt('password'), // add default password
                ]
            );
        }
    }
}
