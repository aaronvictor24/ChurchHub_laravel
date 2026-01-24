<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "== USERS ==\n";
$users = App\Models\User::all(['id', 'name', 'email', 'role_id', 'church_id'])->toArray();
print_r($users);

echo "\n== MASSES ==\n";
$masses = App\Models\Mass::all(['mass_id', 'mass_title', 'mass_type', 'mass_date', 'day_of_week', 'is_recurring', 'church_id'])->toArray();
print_r($masses);

echo "\nDone.\n";
