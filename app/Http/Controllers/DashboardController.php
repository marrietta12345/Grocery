<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        
        if ($user->isDelivery()) {
            return redirect()->route('delivery.dashboard')->with('success', 'Welcome back, ' . $user->first_name . '!');
        }
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin ' . $user->first_name . '!');
        }
        
        // Get order statistics (with error handling in case orders table doesn't exist)
        try {
            $totalOrders = Order::where('user_id', $user->id)->count();
            $completedOrders = Order::where('user_id', $user->id)->where('status', 'completed')->count();
            $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
            $cancelledOrders = Order::where('user_id', $user->id)->where('status', 'cancelled')->count();
            $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        } catch (\Exception $e) {
            // If orders table doesn't exist, set defaults
            $totalOrders = 0;
            $completedOrders = 0;
            $pendingOrders = 0;
            $cancelledOrders = 0;
            $recentOrders = collect([]);
        }
        
        // Get all active products for browsing
        $products = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->get();
        
        // Get all active categories with product counts
        $categories = Category::withCount('products')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
        
        // Get featured products for carousel
        $featuredProducts = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(5)
            ->get();
        
        // Get recommended products
        $recommendedProducts = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        // If we have less than 4 featured products, add random ones
        if ($recommendedProducts->count() < 4) {
            $randomProducts = Product::with('category')
                ->where('is_active', true)
                ->where('is_featured', false)
                ->inRandomOrder()
                ->take(4 - $recommendedProducts->count())
                ->get();
                
            $recommendedProducts = $recommendedProducts->concat($randomProducts);
        }
        
        $totalProducts = Product::where('is_active', true)->count();
        
        return view('dashboard', compact(
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'cancelledOrders',
            'products',
            'categories',
            'recentOrders',
            'recommendedProducts',
            'featuredProducts',
            'totalProducts',
            'user'
        ));
    }
}