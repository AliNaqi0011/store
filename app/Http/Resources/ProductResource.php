<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'sku' => $this->sku,
            'price' => $this->price,
            'compare_price' => $this->compare_price,
            'stock_quantity' => $this->stock_quantity,
            'manage_stock' => $this->manage_stock,
            'in_stock' => $this->is_in_stock,
            'is_featured' => $this->is_featured,
            'rating' => $this->rating,
            'reviews_count' => $this->reviews_count,
            'primary_image' => $this->primary_image,
            'images' => $this->images,
            'category' => $this->category->name ?? null,
            'brand' => $this->brand->name ?? null,
        ];
    }
}