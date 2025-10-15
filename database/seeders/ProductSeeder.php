<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $smartphones = Category::where('slug', 'smartphones')->first();
        $laptops = Category::where('slug', 'laptops')->first();
        $mensClothing = Category::where('slug', 'mens-clothing')->first();
        
        $apple = Brand::where('slug', 'apple')->first();
        $samsung = Brand::where('slug', 'samsung')->first();
        $dell = Brand::where('slug', 'dell')->first();
        $nike = Brand::where('slug', 'nike')->first();

        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'The latest iPhone with advanced features and powerful performance.',
                'short_description' => 'Latest iPhone with Pro features',
                'sku' => 'IPH15PRO001',
                'price' => 999.99,
                'compare_price' => 1099.99,
                'stock_quantity' => 50,
                'category_id' => $smartphones->id,
                'brand_id' => $apple->id,
                'is_featured' => true,
                'rating' => 4.8,
                'reviews_count' => 125,
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'slug' => 'samsung-galaxy-s24',
                'description' => 'Premium Android smartphone with excellent camera and display.',
                'short_description' => 'Premium Android smartphone',
                'sku' => 'SGS24001',
                'price' => 899.99,
                'stock_quantity' => 30,
                'category_id' => $smartphones->id,
                'brand_id' => $samsung->id,
                'is_featured' => true,
                'rating' => 4.6,
                'reviews_count' => 89,
            ],
            [
                'name' => 'Dell XPS 13',
                'slug' => 'dell-xps-13',
                'description' => 'Ultra-portable laptop with premium build quality and performance.',
                'short_description' => 'Ultra-portable premium laptop',
                'sku' => 'DXPS13001',
                'price' => 1299.99,
                'stock_quantity' => 20,
                'category_id' => $laptops->id,
                'brand_id' => $dell->id,
                'rating' => 4.7,
                'reviews_count' => 67,
            ],
            [
                'name' => 'Nike Air Max 270',
                'slug' => 'nike-air-max-270',
                'description' => 'Comfortable running shoes with modern design and excellent cushioning.',
                'short_description' => 'Comfortable running shoes',
                'sku' => 'NAM270001',
                'price' => 149.99,
                'stock_quantity' => 100,
                'category_id' => $mensClothing->id,
                'brand_id' => $nike->id,
                'is_featured' => true,
                'rating' => 4.5,
                'reviews_count' => 234,
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);
            
            // Add a placeholder image for each product
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'https://dummyimage.com/400x300/4f46e5/ffffff&text=' . urlencode($product->name),
                'alt_text' => $product->name,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }
    }
}