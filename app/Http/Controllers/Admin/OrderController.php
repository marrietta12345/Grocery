<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])->latest();

        // Search by order number or customer
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%")
                  ->orWhere('contact_phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->paginate(15)->withQueryString();
        
      
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', Order::STATUS_SHIPPED)->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())->where('payment_status', 'paid')->sum('total'),
            'month_orders' => Order::whereMonth('created_at', now()->month)->count(),
            'month_revenue' => Order::whereMonth('created_at', now()->month)->where('payment_status', 'paid')->sum('total'),
        ];

        // Get counts for filter dropdowns 
        $statusCounts = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', Order::STATUS_SHIPPED)->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        $paymentStatusCounts = [
            'paid' => Order::where('payment_status', 'paid')->count(),
            'unpaid' => Order::where('payment_status', 'unpaid')->count(),
            'refunded' => Order::where('payment_status', 'refunded')->count(),
            'failed' => Order::where('payment_status', 'failed')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats', 'statusCounts', 'paymentStatusCounts'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'payment', 'cancelledBy']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the order.
     */
    public function edit(Order $order)
    {
        $order->load(['user', 'items.product']);
    
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        $paymentStatuses = ['unpaid', 'pending', 'paid', 'refunded', 'failed'];
        $paymentMethods = ['cod', 'gcash', 'paymaya', 'credit_card', 'debit_card'];
        
        return view('admin.orders.edit', compact('order', 'statuses', 'paymentStatuses', 'paymentMethods'));
    }

    /**
     * Update the order status.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'payment_status' => 'required|in:unpaid,pending,paid,refunded,failed',
            'payment_method' => 'sometimes|in:cod,gcash,paymaya,credit_card,debit_card',
            'shipping_status' => 'nullable|in:pending,processing,shipped,sorting_facility,out_for_delivery,delivered,failed',
            'courier_name' => 'nullable|string|max:255',
            'tracking_number' => 'nullable|string|max:100',
            'shipped_at' => 'nullable|date',
            'arrived_at_sorting_at' => 'nullable|date',
            'out_for_delivery_at' => 'nullable|date',
            'delivery_instructions' => 'nullable|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($request, $order) {
            $oldStatus = $order->status;
            $oldPaymentStatus = $order->payment_status;
            
            $updateData = [
                'status' => $request->status,
                'payment_status' => $request->payment_status,
                'notes' => $request->notes,
                'tracking_number' => $request->tracking_number,
                'shipping_status' => $request->shipping_status,
                'courier_name' => $request->courier_name,
                'shipped_at' => $request->shipped_at,
                'arrived_at_sorting_at' => $request->arrived_at_sorting_at,
                'out_for_delivery_at' => $request->out_for_delivery_at,
                'delivery_instructions' => $request->delivery_instructions,
            ];

            // Update payment method if provided
            if ($request->has('payment_method')) {
                $updateData['payment_method'] = $request->payment_method;
            }

            // Set paid_at if payment becomes paid
            if ($request->payment_status == 'paid' && !$order->paid_at) {
                $updateData['paid_at'] = now();
            }

            // Clear paid_at if payment is no longer paid
            if ($request->payment_status != 'paid' && $order->paid_at) {
                $updateData['paid_at'] = null;
            }

            $order->update($updateData);

            // Auto-sync shipping status when order is marked as shipped
            if ($request->status === 'shipped' && $oldStatus !== 'shipped') {
                if (empty($request->shipping_status)) {
                    $order->shipping_status = 'shipped';
                }
                if (empty($request->shipped_at)) {
                    $order->shipped_at = now();
                }
                $order->save();
            }

            // Auto-set sorting facility date when shipping status is sorting_facility
            if ($request->shipping_status === 'sorting_facility' && empty($request->arrived_at_sorting_at)) {
                $order->arrived_at_sorting_at = now();
                $order->save();
            }

            // Auto-set out for delivery date when shipping status is out_for_delivery
            if ($request->shipping_status === 'out_for_delivery' && empty($request->out_for_delivery_at)) {
                $order->out_for_delivery_at = now();
                $order->save();
            }

            // Auto-set delivered date when order is completed
            if ($request->status === 'completed' && $oldStatus !== 'completed') {
                if (empty($request->shipping_status)) {
                    $order->shipping_status = 'delivered';
                }
                if (empty($order->delivered_at)) {
                    $order->delivered_at = now();
                }
                $order->save();
            }

            // Log status change if needed
            if ($oldStatus != $request->status) {
               
            }

            if ($oldPaymentStatus != $request->payment_status) {
             
            }
        });

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Update order items (quantity, price, etc.)
     */
    public function updateItems(Request $request, Order $order)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:order_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $order) {
            foreach ($request->items as $itemData) {
                $item = $order->items()->find($itemData['id']);
                if ($item) {
                    $item->update([
                        'quantity' => $itemData['quantity'],
                        'price' => $itemData['price'],
                        'subtotal' => $itemData['quantity'] * $itemData['price'],
                    ]);
                }
            }

            // Recalculate order totals
            $order->recalculateTotals();
        });

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order items updated successfully.');
    }

    /**
     * Cancel order 
     */
    public function cancel(Request $request, Order $order)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($request, $order) {
            $order->update([
                'status' => 'cancelled',
                'shipping_status' => Order::SHIPPING_FAILED,
                'cancellation_reason' => $request->cancellation_reason,
                'cancelled_at' => now(),
                'cancelled_by' => auth()->id(),
            ]);

            // Restore stock if needed
            if ($order->payment_status == 'paid') {
            }

            // Restore product quantities
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        });

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order cancelled successfully. Stock has been restored.');
    }

    /**
     * Delete order 
     */
    public function destroy(Order $order)
    {
        try {
            DB::transaction(function () use ($order) {
                // Delete related records first
                $order->items()->delete();
                if ($order->payment) {
                    $order->payment()->delete();
                }
                
                // Delete the order
                $order->delete();
            });

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }

    /**
     * Export orders to CSV
     */
    public function export(Request $request)
    {
        $query = Order::with(['user', 'items']);

        // Apply filters similar to index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->get();

        // Generate CSV
        $filename = 'orders_export_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, [
                'Order Number',
                'Order Date',
                'Customer Name',
                'Email',
                'Phone',
                'Subtotal',
                'Discount',
                'Shipping Fee',
                'Total',
                'Status',
                'Shipping Status',
                'Payment Status',
                'Payment Method',
                'Items Count',
                'Shipping Address',
                'Tracking Number',
                'Courier Name',
                'Shipped Date',
                'Arrived at Sorting Facility Date',
                'Out for Delivery Date',
                'Delivered Date',
                'Notes',
                'Paid At'
            ]);

            // Data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->setTimezone('Asia/Manila')->format('Y-m-d H:i:s'),
                    $order->user ? $order->user->first_name . ' ' . $order->user->last_name : 'Guest',
                    $order->contact_email,
                    $order->contact_phone,
                    $order->subtotal,
                    $order->discount ?? 0,
                    $order->shipping_fee,
                    $order->total,
                    $order->status,
                    $order->shipping_status ?? 'pending',
                    $order->payment_status,
                    strtoupper($order->payment_method),
                    $order->items->count(),
                    $order->shipping_address,
                    $order->tracking_number ?? '',
                    $order->courier_name ?? '',
                    $order->shipped_at ? $order->shipped_at->setTimezone('Asia/Manila')->format('Y-m-d H:i:s') : '',
                    $order->arrived_at_sorting_at ? $order->arrived_at_sorting_at->setTimezone('Asia/Manila')->format('Y-m-d H:i:s') : '',
                    $order->out_for_delivery_at ? $order->out_for_delivery_at->setTimezone('Asia/Manila')->format('Y-m-d H:i:s') : '',
                    $order->delivered_at ? $order->delivered_at->setTimezone('Asia/Manila')->format('Y-m-d H:i:s') : '',
                    $order->notes,
                    $order->paid_at ? $order->paid_at->setTimezone('Asia/Manila')->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk update orders
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'action' => 'required|in:update_status,update_payment_status,delete',
            'status' => 'required_if:action,update_status|in:pending,processing,shipped,completed,cancelled',
            'payment_status' => 'required_if:action,update_payment_status|in:unpaid,pending,paid,refunded,failed',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $orders = Order::whereIn('id', $request->order_ids);
                $count = $orders->count();
                
                switch ($request->action) {
                    case 'update_status':
                        $orders->update(['status' => $request->status]);
                        $message = "{$count} order(s) status updated to " . ucfirst($request->status) . " successfully.";
                        break;
                        
                    case 'update_payment_status':
                        $updateData = ['payment_status' => $request->payment_status];
                        
                        // Set paid_at for paid orders
                        if ($request->payment_status == 'paid') {
                            $updateData['paid_at'] = now();
                        }
                        
                        $orders->update($updateData);
                        $message = "{$count} order(s) payment status updated to " . ucfirst($request->payment_status) . " successfully.";
                        break;
                        
                    case 'delete':
                        foreach ($orders->get() as $order) {
                            $order->items()->delete();
                            if ($order->payment) {
                                $order->payment()->delete();
                            }
                            $order->delete();
                        }
                        $message = "{$count} order(s) deleted successfully.";
                        break;
                }
            });

            return response()->json([
                'success' => true,
                'message' => $message ?? 'Bulk update completed successfully.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', Order::STATUS_SHIPPED)->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())->where('payment_status', 'paid')->sum('total'),
            'month_orders' => Order::whereMonth('created_at', now()->month)->count(),
            'month_revenue' => Order::whereMonth('created_at', now()->month)->where('payment_status', 'paid')->sum('total'),
        ];

        return response()->json($stats);
    }
}