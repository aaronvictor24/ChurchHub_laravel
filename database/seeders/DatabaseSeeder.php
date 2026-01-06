<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Church;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\MassSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Call essential seeders
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
            MassSeeder::class,
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
                'church_id' => $church->church_id ?? $church->id, // supports either primary key naming
            ]);
        }

        // ✅ Safe test user (only if not already exists)
        if (!User::where('email', 'test@example.com')->exists()) {
            User::firstOrCreate(
                ['email' => 'test@example.com'],
                [
                    'name' => 'Test User',
                    'password' => bcrypt('password'),
                ]
            );
        }
    }
}
