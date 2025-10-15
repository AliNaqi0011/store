<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('original_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->integer('discount_percentage');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('stock_limit')->nullable();
            $table->integer('sold_count')->default(0);
            $table->enum('type', ['flash', 'clearance', 'bundle', 'vip'])->default('flash');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
