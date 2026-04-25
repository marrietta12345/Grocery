<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default categories
        DB::table('categories')->insert([
            ['name' => 'Fresh Produce', 'slug' => 'fresh-produce', 'icon' => 'bi-apple', 'order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dairy', 'slug' => 'dairy', 'icon' => 'bi-cup-straw', 'order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Beverages', 'slug' => 'beverages', 'icon' => 'bi-cup', 'order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Snacks', 'slug' => 'snacks', 'icon' => 'bi-basket', 'order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bakery', 'slug' => 'bakery', 'icon' => 'bi-basket', 'order' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meat & Seafood', 'slug' => 'meat-seafood', 'icon' => 'bi-basket', 'order' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Frozen Foods', 'slug' => 'frozen-foods', 'icon' => 'bi-snow', 'order' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pantry Staples', 'slug' => 'pantry-staples', 'icon' => 'bi-box', 'order' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Household', 'slug' => 'household', 'icon' => 'bi-house', 'order' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Personal Care', 'slug' => 'personal-care', 'icon' => 'bi-person', 'order' => 10, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};