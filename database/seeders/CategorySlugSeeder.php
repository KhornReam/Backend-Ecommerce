<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySlugSeeder extends Seeder
{
    public function run(): void
    {
        Category::all()->each(function ($category) {
            $category->update(['slug' => Str::slug($category->name)]);
        });
    }
}
