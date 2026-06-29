<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$p = App\Models\Product::find(5);
$p->stock = 100;
$p->save();
echo "Stock updated: " . $p->stock;