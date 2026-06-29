<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = App\Models\User::where('email', 'reamkhorn12345@gmail.com')->first();
if ($user) {
    $user->password = bcrypt('Ream123!@#');
    $user->save();
    echo "Password updated for: " . $user->email;
} else {
    echo "User not found";
}