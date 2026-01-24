<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// login as secretary@example.com if exists, else id 2
$user = App\Models\User::where('email', 'secretary@example.com')->first() ?: App\Models\User::find(2);
if (! $user) {
    echo "No secretary user found.\n";
    exit(1);
}
Auth::login($user);

$mass = App\Models\Mass::first();
if (! $mass) {
    echo "No masses found.\n";
    exit(1);
}

$members = $mass->church->members()->limit(3)->get();
if ($members->isEmpty()) {
    echo "No members for mass's church.\n";
    exit(1);
}

foreach ($members as $i => $member) {
    $attended = ($i < 3) ? 1 : 0; // mark first 3 attended
    // create or update
    $mass->attendances()->updateOrCreate(
        ['member_id' => $member->member_id],
        ['attended' => $attended]
    );
}

$rows = App\Models\MassAttendance::where('mass_id', $mass->mass_id)->get();
print_r($rows->toArray());
