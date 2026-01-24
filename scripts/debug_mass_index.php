<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// login as secretary (id may vary; using 2 per your tinker output)
Illuminate\Support\Facades\Auth::loginUsingId(2);

$controller = new App\Http\Controllers\Secretary\MassController();
$response = $controller->index();
$data = $response->getData();

echo "== MASSES ==\n";
print_r($data['masses'] instanceof \Illuminate\Pagination\LengthAwarePaginator ? $data['masses']->items() : $data['masses']);

echo "\n== HISTORY ==\n";
print_r($data['historyMasses']);

echo "\nDone.\n";
