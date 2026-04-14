<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use Carbon\Carbon;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        // Percentage discount
        Promotion::create([
            'code' => 'GROCERY50',
            'name' => 'Weekend Special',
            'description' => 'Get 50% off on your weekend shopping!',
            'type' => 'percentage',
            'value' => 50,
            'min_order_amount' => 500,
            'usage_limit' => 100,
            'used_count' => 0,
            'starts_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addDays(30),
            'is_active' => true,
        ]);

        // Fixed amount discount
        Promotion::create([
            'code' => 'SAVE100',
            'name' => 'Save ₱100',
            'description' => 'Get ₱100 off on orders above ₱1000',
            'type' => 'fixed',
            'value' => 100,
            'min_order_amount' => 1000,
            'usage_limit' => 50,
            'used_count' => 0,
            'starts_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addDays(15),
            'is_active' => true,
        ]);

        // Welcome new users
        Promotion::create([
            'code' => 'WELCOME10',
            'name' => 'Welcome Discount',
            'description' => '10% off for new customers',
            'type' => 'percentage',
            'value' => 10,
            'min_order_amount' => null,
            'usage_limit' => 1,
            'used_count' => 0,
            'starts_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addDays(60),
            'is_active' => true,
        ]);

        // Free shipping (as a fixed amount discount)
        Promotion::create([
            'code' => 'FREESHIP',
            'name' => 'Free Shipping',
            'description' => 'Free shipping on orders above ₱2000',
            'type' => 'fixed',
            'value' => 50, // Shipping fee amount to deduct
            'min_order_amount' => 2000,
            'usage_limit' => null,
            'used_count' => 0,
            'starts_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addDays(7),
            'is_active' => true,
        ]);
    }
}