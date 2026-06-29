<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$products = App\Models\Product::all(['id','name','stock','price']);
foreach ($products as $p) {
    echo $p->id . ': ' . $p->name . ' - Stock: ' . $p->stock . ' - Price: $' . $p->price . PHP_EOL;
}