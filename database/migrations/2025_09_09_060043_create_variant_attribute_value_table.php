<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variant_attribute_value', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained()->onDelete('cascade');
            $table->foreignId('attribute_value_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['product_variant_id', 'attribute_value_id'], 'variant_attribute_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_attribute_value');
    }
};