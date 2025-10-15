<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and gadgets',
                'children' => [
                    ['name' => 'Smartphones', 'slug' => 'smartphones'],
                    ['name' => 'Laptops', 'slug' => 'laptops'],
                    ['name' => 'Headphones', 'slug' => 'headphones'],
                ]
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Fashion and apparel',
                'children' => [
                    ['name' => 'Men\'s Clothing', 'slug' => 'mens-clothing'],
                    ['name' => 'Women\'s Clothing', 'slug' => 'womens-clothing'],
                    ['name' => 'Shoes', 'slug' => 'shoes'],
                ]
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Home improvement and garden supplies',
                'children' => [
                    ['name' => 'Furniture', 'slug' => 'furniture'],
                    ['name' => 'Kitchen', 'slug' => 'kitchen'],
                    ['name' => 'Garden Tools', 'slug' => 'garden-tools'],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
                'description' => $categoryData['description'],
                'is_active' => true,
                'sort_order' => 0,
            ]);

            if (isset($categoryData['children'])) {
                foreach ($categoryData['children'] as $index => $childData) {
                    Category::create([
                        'name' => $childData['name'],
                        'slug' => $childData['slug'],
                        'parent_id' => $category->id,
                        'is_active' => true,
                        'sort_order' => $index,
                    ]);
                }
            }
        }
    }
}