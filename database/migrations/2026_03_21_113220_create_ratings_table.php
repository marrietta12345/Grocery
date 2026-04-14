<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->unsigned()->default(5); // 1-5 stars
            $table->text('review')->nullable();
            $table->json('images')->nullable(); // For review images
            $table->string('title')->nullable(); // Review title
            $table->boolean('is_verified_purchase')->default(false);
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            // Ensure one review per product per order
            $table->unique(['order_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};