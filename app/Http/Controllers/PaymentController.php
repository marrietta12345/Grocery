<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Process payment via gateway (mock)
     */
    public function process(Order $order, $method)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Load payment relationship
        $order->load('payment');

        // Check if payment already exists
        if (!$order->payment) {
            abort(404, 'Payment record not found');
        }

        return view('payment-process', compact('order', 'method'));
    }

    /**
     * Handle payment callback from gateway
     */
    public function callback(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string',
            'payment_reference' => 'required|string',
            'status' => 'required|in:success,failed',
        ]);

        $order = Order::findOrFail($request->order_id);
        
        // Verify order belongs to authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $payment = $order->payment;

        if (!$payment) {
            return redirect()->route('order.details', $order)
                ->with('error', 'Payment record not found');
        }

        DB::beginTransaction();

        try {
            if ($request->status === 'success') {
                // Update payment record
                $payment->update([
                    'status' => 'completed',
                    'payment_reference' => $request->payment_reference,
                    'paid_at' => now(),
                ]);

                // Update order 
                $order->update([
                    'status' => 'processing', 
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                ]);

                Log::info('Payment successful - Order now processing', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'payment_reference' => $request->payment_reference,
                    'amount' => $order->total
                ]);

                DB::commit();

                // Redirect to order details instead of confirmation to show processing status
                return redirect()->route('order.details', $order)
                    ->with('success', 'Payment completed successfully! Your order is now being processed. Payment reference: ' . $request->payment_reference);
            } else {
                // Update payment record for failed payment
                $payment->update([
                    'status' => 'failed',
                    'payment_reference' => $request->payment_reference,
                ]);

                Log::warning('Payment failed', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'payment_reference' => $request->payment_reference
                ]);

                DB::commit();

                return redirect()->route('order.details', $order)
                    ->with('error', 'Payment failed. Please try again or choose another payment method.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment callback error: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('order.details', $order)
                ->with('error', 'Payment processing error. Please contact support.');
        }
    }

    /**
     * Handle webhook from payment gateway (for production)
     */
    public function webhook(Request $request)
    {
    
        Log::info('Payment webhook received', $request->all());

        try {
            // Validate webhook data
            $request->validate([
                'order_id' => 'required|exists:orders,id',
                'payment_reference' => 'required|string',
                'status' => 'required|in:success,failed',
                'transaction_id' => 'sometimes|string',
            ]);

            $order = Order::findOrFail($request->order_id);
            $payment = $order->payment;

            if (!$payment) {
                Log::error('Webhook: Payment record not found', ['order_id' => $request->order_id]);
                return response()->json(['error' => 'Payment record not found'], 404);
            }

            DB::transaction(function () use ($order, $payment, $request) {
                if ($request->status === 'success') {
                    $payment->update([
                        'status' => 'completed',
                        'payment_reference' => $request->payment_reference,
                        'paid_at' => now(),
                        'payment_details' => json_encode(array_merge(
                            json_decode($payment->payment_details, true) ?? [],
                            [
                                'webhook_received' => now()->toDateTimeString(),
                                'transaction_id' => $request->transaction_id,
                            ]
                        )),
                    ]);

                    $order->update([
                        'status' => 'processing', 
                        'payment_status' => 'paid',
                        'paid_at' => now(),
                    ]);

                    Log::info('Webhook: Payment successful - Order now processing', [
                        'order_number' => $order->order_number,
                        'payment_reference' => $request->payment_reference
                    ]);
                } else {
                    $payment->update([
                        'status' => 'failed',
                        'payment_details' => json_encode(array_merge(
                            json_decode($payment->payment_details, true) ?? [],
                            [
                                'webhook_received' => now()->toDateTimeString(),
                                'failure_reason' => $request->failure_reason ?? 'Unknown',
                            ]
                        )),
                    ]);

                    Log::warning('Webhook: Payment failed', [
                        'order_number' => $order->order_number,
                        'payment_reference' => $request->payment_reference
                    ]);
                }
            });

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Webhook processing error: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Generate receipt
     */
    public function receipt(Order $order)
    {
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $order->load('items', 'payment', 'user');

        // Check if payment is completed
        if ($order->payment_status !== 'paid' && !auth()->user()->isAdmin()) {
            return redirect()->route('order.details', $order)
                ->with('error', 'Receipt is only available for paid orders.');
        }

        return view('receipt', compact('order'));
    }

    /**
     * Retry payment for failed orders
     */
    public function retry(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if order can be retried
        if ($order->payment_status !== 'failed' && $order->payment_status !== 'pending') {
            return redirect()->route('order.details', $order)
                ->with('error', 'This order cannot be retried.');
        }

        $payment = $order->payment;

        // Reset payment status
        DB::transaction(function () use ($payment, $order) {
            $payment->update([
                'status' => 'pending',
            ]);
            
        });

        // Redirect to payment process with the original method
        return redirect()->route('payment.process', [
            'order' => $order->id,
            'method' => $order->payment_method
        ])->with('info', 'Please complete your payment.');
    }

    /**
     * Verify payment status (AJAX endpoint)
     */
    public function verify(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order->load('payment');

        return response()->json([
            'order_number' => $order->order_number,
            'order_status' => $order->status, 
            'payment_status' => $order->payment_status,
            'payment_reference' => $order->payment?->payment_reference,
            'payment_status_detail' => $order->payment?->status,
        ]);
    }

    /**
     * Mark order as processing 
     * This is a helper method if needed
     */
    public function markAsProcessing(Order $order)
    {
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending orders can be marked as processing.'
            ], 400);
        }

        $order->update([
            'status' => 'processing',
        ]);

        Log::info('Order marked as processing', [
            'order_id' => $order->id,
            'order_number' => $order->order_number
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order is now processing.'
        ]);
    }
}