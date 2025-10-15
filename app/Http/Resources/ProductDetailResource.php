<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'sku' => $this->sku,
            'price' => $this->price,
            'compare_price' => $this->compare_price,
            'stock_quantity' => $this->stock_quantity,
            'manage_stock' => $this->manage_stock,
            'in_stock' => $this->is_in_stock,
            'is_featured' => $this->is_featured,
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'rating' => $this->rating,
            'reviews_count' => $this->reviews_count,
            'primary_image' => $this->primary_image,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'brand' => [
                'id' => $this->brand?->id,
                'name' => $this->brand?->name,
                'slug' => $this->brand?->slug,
            ],
            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image_path' => $image->image_path,
                    'alt_text' => $image->alt_text,
                    'is_primary' => $image->is_primary,
                ];
            }),
            'variants' => $this->variants->where('is_active', true)->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'sku' => $variant->sku,
                    'price' => $variant->price,
                    'stock_quantity' => $variant->stock_quantity,
                    'attributes' => $variant->attributeValues->map(function ($value) {
                        return [
                            'attribute' => $value->attribute->name,
                            'value' => $value->value,
                            'label' => $value->label,
                            'color_code' => $value->color_code,
                        ];
                    }),
                ];
            }),
            'reviews' => $this->reviews->where('is_approved', true)->map(function ($review) {
                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'title' => $review->title,
                    'comment' => $review->comment,
                    'user_name' => $review->user->name,
                    'created_at' => $review->created_at,
                ];
            }),
        ];
    }
}