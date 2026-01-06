<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\Mass;
use Illuminate\Database\Seeder;

use App\Models\Pastor;

class MassSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Ensure at least one pastor exists
        $pastor = Pastor::first() ?? Pastor::create([
            'first_name' => 'Default',
            'middle_name' => '',
            'last_name' => 'Pastor',
            'suffix_name' => '',
            'email' => 'pastor@example.com',
            'age' => 40,
            'contact_number' => '0000000000',
            'address' => 'President Roxas, Capiz',
            'date_of_birth' => '1985-01-01',
            'gender' => 'Male',
            'is_deleted' => false,
        ]);

        // ✅ Ensure the church exists
        $church = Church::firstOrCreate(
            ['church_id' => 1],
            [
                'name' => 'Main Church',
                'address' => 'President Roxas, Capiz',
                'pastor_id' => $pastor->id,
            ]
        );

        $regularMasses = [
            [
                'day_of_week' => 'Wednesday',
                'mass_title' => 'Midweek Service',
                'start_time' => '18:00:00',
                'end_time' => '20:00:00'
            ],
            [
                'day_of_week' => 'Friday',
                'mass_title' => 'Prayer Revival',
                'start_time' => '18:00:00',
                'end_time' => '20:00:00'
            ],
            [
                'day_of_week' => 'Saturday',
                'mass_title' => 'Evangelism',
                'start_time' => '18:00:00',
                'end_time' => '20:00:00'
            ],
            [
                'day_of_week' => 'Sunday',
                'mass_title' => 'Mass Service',
                'start_time' => '09:00:00',
                'end_time' => '11:30:00'
            ],
        ];

        foreach ($regularMasses as $mass) {
            Mass::create([
                'church_id' => $church->church_id,
                'mass_title' => $mass['mass_title'],
                'mass_type' => 'regular',
                'mass_date' => now(),
                'start_time' => $mass['start_time'],
                'end_time' => $mass['end_time'],
                'day_of_week' => $mass['day_of_week'],
                'is_recurring' => true,
            ]);
        }
    }
}
