<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'ClaireDellomos@gmail.com';
$sec = App\Models\Secretary::where('email', $email)->first();
if (! $sec) {
    echo "Secretary not found for {$email}\n";
    exit(1);
}
$old = $sec->toArray();
$sec->church_id = 1;
$sec->save();
echo "Updated secretary church_id from {$old['church_id']} to {$sec->church_id}\n";
print_r($sec->toArray());
