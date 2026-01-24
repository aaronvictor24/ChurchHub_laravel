<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$from = 4;
$to = 1;
$count = App\Models\Member::where('church_id', $from)->count();
if ($count === 0) {
    echo "No members with church_id={$from} found.\n";
    exit(0);
}

App\Models\Member::where('church_id', $from)->update(['church_id' => $to]);

echo "Updated {$count} members from church_id={$from} to church_id={$to}.\n";
