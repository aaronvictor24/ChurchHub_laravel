<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Try to find user by visible name first, then fallback to secretary@example.com
$name = 'Claire Dellomos';
$user = App\Models\User::where('name', $name)->first();
if (! $user) {
    $user = App\Models\User::where('email', 'secretary@example.com')->first();
}

if (! $user) {
    echo "No user found to update\n";
    exit(1);
}

$old = $user->toArray();
$user->church_id = 1;
$user->save();

echo "Updated user:\n";
print_r($old);
echo "->\n";
print_r($user->toArray());
