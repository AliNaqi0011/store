<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page_type'); // home, product, category, etc.
            $table->string('page_id')->nullable(); // specific page/product/category ID
            $table->string('meta_title');
            $table->text('meta_description');
            $table->text('meta_keywords')->nullable();
            $table->text('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->text('custom_head_tags')->nullable();
            $table->timestamps();
            
            $table->unique(['page_type', 'page_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seo_settings');
    }
};