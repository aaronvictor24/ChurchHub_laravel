<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rows = App\Models\Member::select('member_id', 'first_name', 'last_name', 'church_id')->limit(20)->get()->toArray();
print_r($rows);

echo "\nDistinct church_ids: \n";
print_r(App\Models\Member::select('church_id')->distinct()->get()->pluck('church_id')->toArray());
