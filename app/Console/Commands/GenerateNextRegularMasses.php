<?php

namespace App\Console\Commands;

use App\Models\Mass;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateNextRegularMasses extends Command
{
    protected $signature = 'masses:generate-next';
    protected $description = 'Auto-generate next regular masses';

    public function handle()
    {
        $today = Carbon::today();

        // Get latest regular mass per church
        $latestRegularMasses = Mass::where('mass_type', 'regular')
            ->orderBy('mass_date', 'desc')
            ->get()
            ->groupBy('church_id');

        foreach ($latestRegularMasses as $churchId => $masses) {
            $latest = $masses->first();

            $this->line("Processing church {$churchId}: latest mass_date={$latest->mass_date}, day_of_week={$latest->day_of_week}, is_recurring=" . ($latest->is_recurring ? '1' : '0'));

            // Skip if mass already scheduled in future
            if (Carbon::parse($latest->mass_date)->isFuture()) {
                $this->line("  - Skipped: latest mass is in the future ({$latest->mass_date}).");
                continue;
            }

            // Ensure it's recurring and has a weekday
            if (! $latest->is_recurring || empty($latest->day_of_week)) {
                $this->line('  - Skipped: not recurring or missing day_of_week.');
                continue;
            }

            // Compute next date (use `day_of_week` column)
            $day = ucfirst($latest->day_of_week);
            try {
                $nextDate = Carbon::parse($latest->mass_date)->next($day);
            } catch (\Throwable $e) {
                $this->error("  - Error computing next date for church {$churchId}: " . $e->getMessage());
                continue;
            }

            // Prevent duplicates
            $exists = Mass::where('church_id', $churchId)
                ->where('mass_type', 'regular')
                ->whereDate('mass_date', $nextDate->toDateString())
                ->exists();

            if ($exists) {
                $this->line('  - Skipped: next date already exists (' . $nextDate->toDateString() . ').');
                continue;
            }

            // Create new mass
            try {
                // compute weekday from the next date to avoid perpetuating incorrect stored weekdays
                $nextDay = Carbon::parse($nextDate)->format('l');

                Mass::create([
                    'church_id'   => $latest->church_id,
                    'mass_title'  => $latest->mass_title,
                    'mass_date'   => $nextDate->toDateString(),
                    'start_time'  => $latest->start_time,
                    'end_time'    => $latest->end_time,
                    'mass_type'   => 'regular',
                    'day_of_week' => $nextDay,
                    'is_recurring' => true,
                ]);
                $this->line('  - Created next regular mass for ' . $nextDate->toDateString());
            } catch (\Throwable $e) {
                $this->error('  - Failed to create mass: ' . $e->getMessage());
            }
        }

        $this->info('Next regular masses generated successfully.');
    }
}
