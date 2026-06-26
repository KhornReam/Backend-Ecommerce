<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->info('No categories found');
            return;
        }

        $products = [
            ['name' => 'iPhone 15 Pro', 'price' => 999.99, 'stock' => 50, 'category' => 'Electronics'],
            ['name' => 'MacBook Air M2', 'price' => 1299.99, 'stock' => 30, 'category' => 'Electronics'],
            ['name' => 'Nike Air Max', 'price' => 149.99, 'stock' => 100, 'category' => 'Fashion'],
            ['name' => 'Levi\'s Jeans', 'price' => 79.99, 'stock' => 75, 'category' => 'Fashion'],
            ['name' => 'Organic Apples', 'price' => 4.99, 'stock' => 200, 'category' => 'Food'],
            ['name' => 'Chocolate Bar', 'price' => 2.99, 'stock' => 500, 'category' => 'Food'],
        ];

        foreach ($products as $p) {
            $category = $categories->where('name', $p['category'])->first();
            
            Product::create([
                'name' => $p['name'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'category_id' => $category ? $category->id : null,
                'description' => 'Sample product: ' . $p['name'],
            ]);
            
            $this->command->info("Created: {$p['name']}");
        }
        
        $this->command->info('Products seeded!');
    }
}
