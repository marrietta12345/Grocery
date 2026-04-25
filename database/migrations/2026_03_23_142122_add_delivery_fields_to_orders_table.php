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
        Schema::table('orders', function (Blueprint $table) {
            // Add delivery_fee if it doesn't exist
            if (!Schema::hasColumn('orders', 'delivery_fee')) {
                $table->decimal('delivery_fee', 10, 2)->default(0)->after('total');
            }
            
            // Add delivered_at if it doesn't exist
            if (!Schema::hasColumn('orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('shipping_address');
            }
            
            // DO NOT add shipping_address if it already exists
            // If you need to ensure shipping_address exists, you can add it conditionally
            // if (!Schema::hasColumn('orders', 'shipping_address')) {
            //     $table->text('shipping_address')->nullable()->after('delivery_fee');
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'delivery_fee')) {
                $table->dropColumn('delivery_fee');
            }
            
            if (Schema::hasColumn('orders', 'delivered_at')) {
                $table->dropColumn('delivered_at');
            }
            
            // Only drop shipping_address if you added it in this migration
            // if (Schema::hasColumn('orders', 'shipping_address')) {
            //     $table->dropColumn('shipping_address');
            // }
        });
    }
};