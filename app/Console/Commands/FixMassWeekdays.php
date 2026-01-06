<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mass;
use Carbon\Carbon;

class FixMassWeekdays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:mass-weekdays {--dry-run : Show changes without applying}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix mass records where day_of_week does not match mass_date';

    public function handle()
    {
        $dry = $this->option('dry-run');

        $masses = Mass::all();
        $toFix = [];

        foreach ($masses as $mass) {
            if (empty($mass->mass_date)) {
                continue;
            }

            $expected = Carbon::parse($mass->mass_date)->format('l');
            $current = $mass->day_of_week;

            if ($current !== $expected) {
                $toFix[] = [
                    'id' => $mass->mass_id,
                    'title' => $mass->mass_title,
                    'mass_date' => $mass->mass_date,
                    'current' => $current,
                    'expected' => $expected,
                ];
            }
        }

        if (empty($toFix)) {
            $this->info('No mismatched mass weekdays found.');
            return 0;
        }

        $this->info('Found ' . count($toFix) . ' masses with mismatched weekday:');
        foreach ($toFix as $t) {
            $this->line("[{$t['id']}] {$t['title']} date={$t['mass_date']} day_of_week={$t['current']} -> should be {$t['expected']}");
        }

        if ($dry) {
            $this->info('Dry run - no changes applied.');
            return 0;
        }

        if (! $this->confirm('Apply fixes (update day_of_week to match mass_date)?')) {
            $this->info('Aborted.');
            return 1;
        }

        foreach ($toFix as $t) {
            Mass::where('mass_id', $t['id'])->update(['day_of_week' => $t['expected']]);
            $this->line("Updated mass {$t['id']} -> day_of_week={$t['expected']}");
        }

        $this->info('Done.');
        return 0;
    }
}
