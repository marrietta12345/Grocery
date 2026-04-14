<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get user statistics - separate admins from regular users
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalRegularUsers = User::where('role', 'user')->count();
        
        // Get statistics
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'low_stock_products' => Product::where('stock', '<', 10)->where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('stock', '<=', 0)->count(),
            'total_users' => $totalUsers,
            'total_admins' => $totalAdmins,
            'total_regular_users' => $totalRegularUsers,
            'total_orders' => Order::count(), // This will be 0 until you create orders
        ];

        // Get products by category
        $productsByCategory = Category::select('categories.id', 'categories.name as category_name', DB::raw('COUNT(products.id) as total'))
            ->leftJoin('products', function($join) {
                $join->on('categories.id', '=', 'products.category_id')
                     ->where('products.is_active', '=', 1);
            })
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Get recent products with category relationship
        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        // Get low stock products with category relationship
        $lowStockProducts = Product::with('category')
            ->where('stock', '<', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // Get recent users (for display)
        $recentUsers = User::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'productsByCategory',
            'recentProducts',
            'lowStockProducts',
            'recentUsers'
        ));
    }
}