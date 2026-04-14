<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display sales report page.
     */
    public function sales(Request $request)
    {
        // Get date range from request or default to last 30 days
        $dateFrom = $request->get('date_from', Carbon::now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', Carbon::now()->format('Y-m-d'));
        $groupBy = $request->get('group_by', 'day'); // day, week, month, year
        
        // Sales data query
        $salesQuery = Order::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
        
        // Group by period
        switch($groupBy) {
            case 'week':
                $salesData = $salesQuery->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('WEEK(created_at) as week'),
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(total) as total_sales'),
                    DB::raw('AVG(total) as average_order')
                )
                ->groupBy('year', 'week')
                ->orderBy('year', 'desc')
                ->orderBy('week', 'desc')
                ->get();
                
                // Format labels for chart
                $labels = $salesData->map(function($item) {
                    return "Week {$item->week}, {$item->year}";
                });
                $salesDataFormatted = $salesData;
                break;
                
            case 'month':
                $salesData = $salesQuery->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(total) as total_sales'),
                    DB::raw('AVG(total) as average_order')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
                
                // Format labels for chart
                $labels = $salesData->map(function($item) {
                    return Carbon::create()->month($item->month)->format('F') . " {$item->year}";
                });
                $salesDataFormatted = $salesData;
                break;
                
            case 'year':
                $salesData = $salesQuery->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(total) as total_sales'),
                    DB::raw('AVG(total) as average_order')
                )
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->get();
                
                // Format labels for chart
                $labels = $salesData->pluck('year');
                $salesDataFormatted = $salesData;
                break;
                
            default: // day
                $salesData = $salesQuery->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(total) as total_sales'),
                    DB::raw('AVG(total) as average_order')
                )
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy(DB::raw('DATE(created_at)'), 'desc')
                ->get();
                
                // Format labels for chart
                $labels = $salesData->map(function($item) {
                    return Carbon::parse($item->date)->format('M d, Y');
                });
                $salesDataFormatted = $salesData;
                break;
        }
        
        // Summary statistics
        $summary = [
            'total_orders' => $salesQuery->count(),
            'total_revenue' => $salesQuery->sum('total'),
            'average_order' => $salesQuery->avg('total'),
            'total_customers' => $salesQuery->distinct('user_id')->count('user_id'),
        ];
        
        // Orders by status
        $ordersByStatus = $salesQuery->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
        
        // Orders by payment method
        $ordersByPayment = $salesQuery->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('payment_method')
            ->get();
        
        // Top selling products
        $topProducts = Product::select('products.id', 'products.name', 'products.image')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->select(
                'products.id',
                'products.name',
                'products.image',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.reports.sales', compact(
            'salesDataFormatted', 'summary', 'ordersByStatus', 'ordersByPayment', 
            'topProducts', 'dateFrom', 'dateTo', 'groupBy', 'labels'
        ));
    }
    
    /**
     * Export sales report to CSV.
     */
    public function exportSales(Request $request)
    {
        $dateFrom = $request->get('date_from', Carbon::now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', Carbon::now()->format('Y-m-d'));
        
        $orders = Order::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->with('user', 'items')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $filename = 'sales_report_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");
            
            // Add headers
            fputcsv($file, [
                'Order #', 'Date', 'Customer', 'Email', 'Total', 'Status', 
                'Payment Method', 'Payment Status', 'Items Count'
            ]);
            
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->user ? $order->user->first_name . ' ' . $order->user->last_name : 'Guest',
                    $order->contact_email,
                    number_format($order->total, 2),
                    $order->status,
                    strtoupper($order->payment_method),
                    $order->payment_status,
                    $order->items->count(),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Display inventory report page.
     */
    public function inventory(Request $request)
    {
        $categoryId = $request->get('category');
        $stockStatus = $request->get('stock_status');
        $search = $request->get('search');
        
        $query = Product::with('category');
        
        // Apply filters
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }
        
        if ($categoryId && $categoryId != 'all') {
            $query->where('category_id', $categoryId);
        }
        
        if ($stockStatus) {
            switch($stockStatus) {
                case 'in_stock':
                    $query->where('stock', '>', 10);
                    break;
                case 'low_stock':
                    $query->where('stock', '>=', 1)->where('stock', '<=', 10);
                    break;
                case 'out_of_stock':
                    $query->where('stock', 0);
                    break;
            }
        }
        
        $products = $query->orderBy('stock', 'asc')->paginate(20);
        
        // Inventory summary
        $summary = [
            'total_products' => Product::count(),
            'total_value' => Product::sum(DB::raw('price * stock')),
            'low_stock_count' => Product::where('stock', '>=', 1)->where('stock', '<=', 10)->count(),
            'out_of_stock_count' => Product::where('stock', 0)->count(),
            'in_stock_count' => Product::where('stock', '>', 10)->count(),
            'total_categories' => Category::count(),
        ];
        
        // Get categories for filter
        $categories = Category::orderBy('name')->get();
        
        // Stock distribution by category
        $stockByCategory = Product::select('category_id', 
                DB::raw('COUNT(*) as product_count'),
                DB::raw('SUM(stock) as total_stock'),
                DB::raw('SUM(price * stock) as total_value')
            )
            ->with('category')
            ->groupBy('category_id')
            ->get();
        
        return view('admin.reports.inventory', compact(
            'products', 'summary', 'categories', 'stockByCategory',
            'categoryId', 'stockStatus', 'search'
        ));
    }
    
    /**
     * Export inventory report to CSV.
     */
    public function exportInventory(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->get('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        
        if ($request->get('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }
        
        $products = $query->orderBy('name')->get();
        
        $filename = 'inventory_report_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");
            
            fputcsv($file, [
                'ID', 'Name', 'SKU', 'Category', 'Brand', 'Price', 
                'Stock', 'Stock Value', 'Status', 'Featured'
            ]);
            
            foreach ($products as $product) {
                $stockStatus = $product->stock > 10 ? 'In Stock' : ($product->stock > 0 ? 'Low Stock' : 'Out of Stock');
                
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->sku,
                    $product->category ? $product->category->name : 'Uncategorized',
                    $product->brand,
                    number_format($product->price, 2),
                    $product->stock,
                    number_format($product->price * $product->stock, 2),
                    $stockStatus,
                    $product->is_featured ? 'Yes' : 'No'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}