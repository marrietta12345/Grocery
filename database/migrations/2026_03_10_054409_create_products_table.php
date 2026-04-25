<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand');
            $table->string('category'); // Fresh Produce, Dairy, Beverages, Snacks, Bakery, Meat & Seafood
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('sku')->nullable()->unique();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('unit')->default('pcs'); // kg, g, pcs, liter
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index('category');
            $table->index('is_featured');
            $table->index('is_active');
            $table->index(['category', 'is_active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};