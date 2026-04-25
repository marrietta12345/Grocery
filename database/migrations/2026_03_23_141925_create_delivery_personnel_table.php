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
        Schema::create('delivery_personnel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone_number')->nullable();
            $table->enum('vehicle_type', ['motorcycle', 'car', 'bicycle'])->nullable();
            $table->string('license_plate')->nullable();
            $table->enum('availability_status', ['available', 'busy', 'offline'])->default('available');
            $table->decimal('current_latitude', 10, 8)->nullable();
            $table->decimal('current_longitude', 11, 8)->nullable();
            $table->integer('total_deliveries')->default(0);
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->integer('rating_count')->default(0);
            $table->timestamps();
            
            // Add index for faster queries
            $table->index('availability_status');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_personnel');
    }
};