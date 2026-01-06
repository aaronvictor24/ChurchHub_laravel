<?php

namespace App\Console\Commands;

use App\Models\Mass;
use Illuminate\Console\Command;
use Carbon\Carbon;

class BackfillPastRegularMasses extends Command
{
    protected $signature = 'masses:backfill-past {--days=7}';
    protected $description = 'Backfill past regular mass occurrences for history';

    public function handle()
    {
        $days = $this->option('days');
        $today = Carbon::today();
        $startDate = $today->copy()->subDays($days);

        // Get all recurring mass definitions (unique by church, day_of_week, time, title)
        $recurringDefinitions = Mass::where('is_recurring', 1)
            ->distinct('church_id', 'day_of_week', 'start_time', 'mass_title')
            ->get(['church_id', 'day_of_week', 'start_time', 'end_time', 'mass_title', 'mass_type'])
            ->groupBy(['church_id', 'day_of_week', 'start_time']);

        $created = 0;
        $skipped = 0;

        foreach ($recurringDefinitions as $churchGroup) {
            foreach ($churchGroup as $dayGroup) {
                foreach ($dayGroup as $timeGroup) {
                    foreach ($timeGroup as $mass) {
                        // Generate occurrences for the past week
                        $current = $startDate->copy();
                        while ($current < $today) {
                            $dayName = $current->format('l'); // e.g., "Sunday"

                            // Only create if the day matches the recurring day
                            if ($dayName === $mass->day_of_week) {
                                $exists = Mass::where('church_id', $mass->church_id)
                                    ->where('mass_title', $mass->mass_title)
                                    ->whereDate('mass_date', $current->toDateString())
                                    ->exists();

                                if (!$exists) {
                                    Mass::create([
                                        'church_id' => $mass->church_id,
                                        'mass_title' => $mass->mass_title,
                                        'mass_type' => $mass->mass_type,
                                        'mass_date' => $current->toDateString(),
                                        'start_time' => $mass->start_time,
                                        'end_time' => $mass->end_time,
                                        'day_of_week' => $mass->day_of_week,
                                        'is_recurring' => 1,
                                    ]);
                                    $created++;
                                    $this->info("✓ Created {$mass->mass_title} on {$current->toDateString()}");
                                } else {
                                    $skipped++;
                                }
                            }

                            $current->addDay();
                        }
                    }
                }
            }
        }

        $this->info("\n✅ Backfill complete: {$created} created, {$skipped} skipped.");
    }
}
