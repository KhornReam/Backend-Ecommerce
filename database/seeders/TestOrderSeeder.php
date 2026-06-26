<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestOrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'ream@example.com')->first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Mr Ream',
                'email' => 'ream@example.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]);
            $this->command->info('Created user: Mr Ream');
        }
        $products = Product::take(3)->get();

        if (!$user || $products->isEmpty()) {
            $this->command->info('User or products not found');
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        foreach ($products as $index => $product) {
            $quantity = rand(1, 3);
            $total = $product->price * $quantity;

            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now()->subDays(rand(0, 30)),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);

            $this->command->info("Created order #{$order->id} for {$user->name}");
        }

        $this->command->info('Test orders created for Mr Ream');
    }
}
