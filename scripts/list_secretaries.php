<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$secs = App\Models\Secretary::all(['secretary_id', 'email', 'church_id'])->toArray();
print_r($secs);
