<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    /**
     * Display checkout page
     */
    public function checkout()
    {
        $cart = Cart::with('items.product.category')
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Get user's saved addresses from profile
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();

        return view('checkout', compact('cart', 'addresses'));
    }

    /**
     * Generate payment reference number
     */
    private function generatePaymentReference($prefix)
    {
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        return $prefix . '-' . $date . '-' . $random;
    }

    /**
     * Process order and payment
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'delivery_instructions' => 'nullable|string',
            'contact_email' => 'required|email',
            'payment_method' => 'required|in:cod,gcash,paymaya,credit_card,debit_card',
            'notes' => 'nullable|string',
            'save_address' => 'sometimes|boolean',
        ]);

        $cart = Cart::with('items.product')
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Format full shipping address
            $shippingAddress = $request->address_line1;
            if ($request->address_line2) {
                $shippingAddress .= ', ' . $request->address_line2;
            }
            $shippingAddress .= ', ' . $request->barangay;
            $shippingAddress .= ', ' . $request->city;
            $shippingAddress .= ', ' . $request->province;
            $shippingAddress .= ' ' . $request->postal_code;

            // Calculate totals
            $subtotal = $cart->subtotal;
            $discount = $cart->discount ?? 0;
            $shippingFee = 50;
            $total = $subtotal - $discount + $shippingFee;

            // Set payment status based on method
            $paymentStatus = $request->payment_method === 'cod' ? 'unpaid' : 'pending';

            // Set order status based on payment method
            // For COD, keep as pending; for online payments, keep as pending until payment is confirmed
            $orderStatus = 'pending';

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_fee' => $shippingFee,
                'total' => $total,
                'promo_code' => $cart->promo_code,
                'status' => $orderStatus,
                'payment_status' => $paymentStatus,
                'payment_method' => $request->payment_method,
                'shipping_address' => $shippingAddress,
                'billing_address' => $shippingAddress,
                'contact_phone' => $request->recipient_phone,
                'contact_email' => $request->contact_email,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_sku' => $item->product->sku,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Update promo code usage if applied
            if ($cart->promo_code) {
                $promotion = Promotion::where('code', $cart->promo_code)->first();
                if ($promotion) {
                    $promotion->increment('used_count');
                }
            }

            // Save address to user's profile if requested
            if ($request->has('save_address') && $request->save_address) {
                // Check if address already exists to avoid duplicates
                $existingAddress = Address::where('user_id', Auth::id())
                    ->where('address_line1', $request->address_line1)
                    ->where('barangay', $request->barangay)
                    ->where('city', $request->city)
                    ->first();

                if (!$existingAddress) {
                    Address::create([
                        'user_id' => Auth::id(),
                        'address_type' => 'home',
                        'recipient_name' => $request->recipient_name,
                        'recipient_phone' => $request->recipient_phone,
                        'address_line1' => $request->address_line1,
                        'address_line2' => $request->address_line2,
                        'barangay' => $request->barangay,
                        'city' => $request->city,
                        'province' => $request->province,
                        'postal_code' => $request->postal_code,
                        'delivery_instructions' => $request->delivery_instructions,
                        'is_default' => Auth::user()->addresses()->count() == 0, // Make default if first address
                    ]);
                }
            }

            // Process payment based on method - WITH PROPER REFERENCES
            $payment = $this->processPayment($order, $request->payment_method);

            // Clear the cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            // Redirect based on payment method
            if ($request->payment_method === 'cod') {
                return redirect()->route('order.confirmation', $order->id)
                    ->with('success', 'Order placed successfully! Your order reference is: ' . $payment->payment_reference);
            } else {
                // For online payments, redirect to payment processing page
                return redirect()->route('payment.process', [
                    'order' => $order->id, 
                    'method' => $request->payment_method
                ])->with('success', 'Please complete your payment. Reference: ' . $payment->payment_reference);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order placement error: ' . $e->getMessage());
            return back()->with('error', 'Failed to place order: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Process payment based on method - WITH PROPER REFERENCES
     */
    private function processPayment($order, $paymentMethod)
    {
        // Generate payment reference based on method
        $prefix = match($paymentMethod) {
            'cod' => 'COD',
            'gcash' => 'GCS',
            'paymaya' => 'MAY',
            'credit_card' => 'CRC',
            'debit_card' => 'DBT',
            default => 'PAY'
        };
        
        $paymentReference = $this->generatePaymentReference($prefix);

        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => $paymentMethod,
            'amount' => $order->total,
            'status' => $paymentMethod === 'cod' ? 'pending' : 'pending',
            'payment_reference' => $paymentReference,
            'payment_details' => json_encode([
                'method' => $paymentMethod,
                'reference' => $paymentReference,
                'timestamp' => now()->toDateTimeString(),
            ]),
        ]);

        // Handle different payment methods
        switch ($paymentMethod) {
            case 'cod':
                // Cash on Delivery - no immediate payment
                $payment->update([
                    'status' => 'pending',
                    'payment_details' => json_encode(array_merge(
                        json_decode($payment->payment_details, true) ?? [],
                        [
                            'message' => 'Pay upon delivery',
                            'reference' => $paymentReference,
                        ]
                    )),
                ]);
                break;

            case 'gcash':
            case 'paymaya':
                // For e-wallets, generate payment link or QR code
                $payment->update([
                    'status' => 'pending',
                    'payment_details' => json_encode(array_merge(
                        json_decode($payment->payment_details, true) ?? [],
                        [
                            'payment_link' => $this->generateEwalletPaymentLink($order, $paymentMethod),
                            'qr_code' => $this->generateQRCode($order, $paymentMethod),
                            'reference' => $paymentReference,
                        ]
                    )),
                ]);
                break;

            case 'credit_card':
            case 'debit_card':
                // For card payments, integrate with payment gateway
                $payment->update([
                    'status' => 'pending',
                    'payment_details' => json_encode(array_merge(
                        json_decode($payment->payment_details, true) ?? [],
                        [
                            'gateway_url' => $this->getPaymentGatewayUrl($order),
                            'reference' => $paymentReference,
                        ]
                    )),
                ]);
                break;
        }

        return $payment;
    }

    /**
     * Generate e-wallet payment link (mock)
     */
    private function generateEwalletPaymentLink($order, $method)
    {
        // This would integrate with actual payment gateway
        return route('payment.process', ['order' => $order->id, 'method' => $method]);
    }

    /**
     * Generate QR code for payment (mock)
     */
    private function generateQRCode($order, $method)
    {
        // This would generate actual QR code
        return 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . $order->order_number;
    }

    /**
     * Get payment gateway URL (mock)
     */
    private function getPaymentGatewayUrl($order)
    {
        // This would integrate with actual payment gateway
        return route('payment.gateway', ['order' => $order->id]);
    }

    /**
     * Display order confirmation
     */
    public function confirmation(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items', 'payment');

        return view('order-confirmation', compact('order'));
    }

    /**
     * Display order history
     */
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->withCount('items')
            ->latest()
            ->paginate(10);

        // Calculate statistics for the view
        $totalOrders = $orders->total();
        $completedOrders = $orders->where('status', 'completed')->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $cancelledOrders = $orders->where('status', 'cancelled')->count();

        return view('order-history', compact('orders', 'totalOrders', 'completedOrders', 'pendingOrders', 'cancelledOrders'));
    }

    /**
     * Display order details
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product', 'payment');

        return view('order-details', compact('order'));
    }

    /**
     * Check if order can be cancelled
     */
    private function canBeCancelled(Order $order)
    {
        // Order can be cancelled if:
        // 1. Status is pending
        // 2. Payment method is COD (unpaid) OR
        // 3. Payment method is GCash/PayMaya and payment status is unpaid/pending
        // 4. Payment method is card and payment status is pending
        
        if ($order->status !== 'pending') {
            return false;
        }

        if ($order->payment_method === 'cod') {
            return true; // COD orders can always be cancelled while pending
        }

        // For online payments, can cancel if not yet paid
        return in_array($order->payment_status, ['unpaid', 'pending']);
    }

    /**
     * Cancel order - UPDATED to accept Request and handle reason
     */
    public function cancel(Request $request, Order $order)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        // Check if order can be cancelled
        if (!$this->canBeCancelled($order)) {
            return response()->json([
                'success' => false,
                'message' => 'This order cannot be cancelled at this time.'
            ], 400);
        }

        // Validate the request
        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        try {
            DB::transaction(function () use ($request, $order) {
                // Restore stock
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                        Log::info('Stock restored for product ID: ' . $item->product_id . ' - Quantity: ' . $item->quantity);
                    }
                }

                // Update order with cancellation details
                $order->status = 'cancelled';
                $order->cancellation_reason = $request->cancellation_reason;
                $order->cancelled_at = now();
                $order->cancelled_by = Auth::id();
                $order->save();

                // If there's a payment record, update its status
                if ($order->payment) {
                    $order->payment->update([
                        'status' => 'cancelled',
                    ]);
                }

                Log::info('Order #' . $order->order_number . ' cancelled by user #' . Auth::id() . ' - Reason: ' . $request->cancellation_reason);
            });

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Order cancellation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order statistics for dashboard
     */
    public function getStats()
    {
        $userId = Auth::id();
        
        $stats = [
            'total_orders' => Order::where('user_id', $userId)->count(),
            'pending_orders' => Order::where('user_id', $userId)->where('status', 'pending')->count(),
            'processing_orders' => Order::where('user_id', $userId)->where('status', 'processing')->count(),
            'completed_orders' => Order::where('user_id', $userId)->where('status', 'completed')->count(),
            'cancelled_orders' => Order::where('user_id', $userId)->where('status', 'cancelled')->count(),
            'total_spent' => Order::where('user_id', $userId)->where('payment_status', 'paid')->sum('total'),
        ];

        return response()->json($stats);
    }

    /**
     * Get tracking data for order details page
     */
    public function getTrackingData($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        return response()->json([
            'tracking_number' => $order->tracking_number,
            'courier_name' => $order->courier_name,
            'shipped_date' => $order->shipped_at ? $order->shipped_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') : null,
            'shipped_at' => $order->shipped_at ? $order->shipped_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') : null,
            'arrived_at_sorting_at' => $order->arrived_at_sorting_at ? $order->arrived_at_sorting_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') : null,
            'out_for_delivery_at' => $order->out_for_delivery_at ? $order->out_for_delivery_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') : null,
            'delivered_at' => $order->delivered_at ? $order->delivered_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') : null,
            'created_at' => $order->created_at->setTimezone('Asia/Manila')->format('M d, Y h:i A'),
            'paid_at' => $order->paid_at ? $order->paid_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') : null,
            'order_status' => ucfirst($order->status),
            'shipping_status' => $order->shipping_status,
            'shipping_status_text' => $order->shipping_status_text,
        ]);
    }
    public function confirmReceived(Request $request, Order $order)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }
        
        // Check if this is a COD order
        if ($order->payment_method !== 'cod') {
            return response()->json([
                'success' => false,
                'message' => 'This action is only available for COD orders.'
            ], 400);
        }
        
        // Check if order is delivered
        if ($order->shipping_status !== 'delivered') {
            return response()->json([
                'success' => false,
                'message' => 'Order must be delivered before confirming receipt.'
            ], 400);
        }
        
        // Check if already paid
        if ($order->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'This order has already been marked as paid.'
            ], 400);
        }
        
        try {
            DB::transaction(function () use ($order) {
                // Update payment status to paid
                $order->payment_status = 'paid';
                $order->paid_at = now();
                $order->save();
                
                // Update payment record if exists
                if ($order->payment) {
                    $order->payment->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);
                }
                
                // Update order status to completed
                $order->status = 'completed';
                $order->save();
                
                Log::info('COD order #' . $order->order_number . ' confirmed received by user #' . Auth::id());
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Order confirmed as received! Payment has been marked as paid.'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to confirm order receipt: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to confirm order receipt. Please try again.'
            ], 500);
        }
    }
}