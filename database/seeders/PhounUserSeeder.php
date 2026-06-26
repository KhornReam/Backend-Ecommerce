<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PhounUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'phoun@example.com'],
            [
                'name' => 'Mr Phoun',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        $this->command->info("User: {$user->name} ({$user->email})");

        $products = Product::take(4)->get();

        if ($products->isEmpty()) {
            $this->command->info('No products found');
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        foreach ($products as $index => $product) {
            $quantity = rand(1, 5);
            $total = $product->price * $quantity;

            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now()->subDays(rand(0, 60)),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);

            $this->command->info("Created order #{$order->id} - \${$total} ({$order->status})");
        }

        $this->command->info('Test orders created for Mr Phoun');
    }
}
