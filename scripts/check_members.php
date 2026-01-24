<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$members = App\Models\Member::where('church_id', 1)->get(['member_id', 'first_name', 'last_name', 'church_id'])->toArray();
if (empty($members)) {
    echo "No members found for church_id=1\n";
} else {
    print_r($members);
}
