<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mass;
use Carbon\Carbon;

class RegularMassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $churchId = 1;
        $today = Carbon::today();

        $masses = [
            [
                'mass_title' => 'Sunday Early',
                'day_of_week' => 'Sunday',
                'start_time' => '06:30:00',
                'end_time' => '07:30:00',
            ],
            [
                'mass_title' => 'Sunday Main',
                'day_of_week' => 'Sunday',
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
            ],
            [
                'mass_title' => 'Wednesday',
                'day_of_week' => 'Wednesday',
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
            ],
            [
                'mass_title' => 'Friday',
                'day_of_week' => 'Friday',
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
            ],
        ];

        foreach ($masses as $m) {
            $nextDate = Carbon::parse($today)->next($m['day_of_week'])->toDateString();

            $exists = Mass::where('church_id', $churchId)
                ->where('mass_type', 'regular')
                ->where('day_of_week', $m['day_of_week'])
                ->whereDate('mass_date', $nextDate)
                ->exists();

            if (! $exists) {
                Mass::create([
                    'church_id' => $churchId,
                    'mass_title' => $m['mass_title'],
                    'mass_type' => 'regular',
                    'mass_date' => $nextDate,
                    'start_time' => $m['start_time'],
                    'end_time' => $m['end_time'],
                    'day_of_week' => $m['day_of_week'],
                    'is_recurring' => true,
                    'description' => null,
                ]);
            }
        }
    }
}
