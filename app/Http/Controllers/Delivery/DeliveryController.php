<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\DeliveryPersonnel;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('delivery.personnel')->except(['trackOrder']);
    }

    // Dashboard for delivery personnel
    public function dashboard()
    {
        $personnel = Auth::user()->deliveryPersonnel;
        
        if (!$personnel) {
            return redirect()->route('dashboard')->with('error', 'Delivery profile not found.');
        }
        
        $activeDeliveries = Delivery::where('delivery_personnel_id', $personnel->id)
            ->whereIn('status', ['assigned', 'picked_up', 'in_transit'])
            ->with('order', 'order.user', 'order.items')
            ->orderBy('assigned_at', 'desc')
            ->get();
        
        $availableOrders = Order::where(function($query) {
                $query->where('shipping_status', 'sorting_facility')
                      ->orWhere('shipping_status', Order::SHIPPING_ARRIVED_AT_SORTING);
            })
            ->whereDoesntHave('delivery')
            ->with('payment')
            ->latest()
            ->get();
        
        $completedToday = Delivery::where('delivery_personnel_id', $personnel->id)
            ->where('status', 'delivered')
            ->whereDate('delivered_at', today())
            ->count();
        
        $stats = [
            'total_deliveries' => $personnel->total_deliveries,
            'completed_today' => $completedToday,
            'active_deliveries' => $activeDeliveries->count(),
            'rating' => $personnel->rating ?? 5.0,
        ];
        
        return view('delivery.dashboard', compact('activeDeliveries', 'availableOrders', 'stats', 'personnel'));
    }

    // Assign and pickup order from sorting facility
    public function assignAndPickup(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);
        
        try {
            DB::transaction(function () use ($request) {
                $order = Order::findOrFail($request->order_id);
                $personnel = Auth::user()->deliveryPersonnel;
                
                // FIX: Check for BOTH status values
                $isAtSortingFacility = in_array($order->shipping_status, [
                    'sorting_facility', 
                    Order::SHIPPING_ARRIVED_AT_SORTING
                ]);
                
                if (!$isAtSortingFacility) {
                    throw new \Exception('This order is not available for pickup. Current status: ' . ($order->shipping_status_text ?? $order->shipping_status));
                }
                
                // Check if order already has a delivery assigned
                if ($order->delivery()->exists()) {
                    throw new \Exception('This order already has a delivery assigned.');
                }
                
                // Check if personnel is available
                if ($personnel->availability_status !== 'available') {
                    throw new \Exception('You are not available for delivery. Please set your status to available.');
                }
                
                // Create delivery record
                $delivery = Delivery::create([
                    'order_id' => $order->id,
                    'delivery_personnel_id' => $personnel->id,
                    'status' => 'picked_up',
                    'assigned_at' => now(),
                    'picked_up_at' => now(),
                    'delivery_notes' => 'Picked up from sorting facility'
                ]);
                
                // Update order shipping status to out_for_delivery
                $order->shipping_status = Order::SHIPPING_OUT_FOR_DELIVERY;
                $order->out_for_delivery_at = now();
                $order->save();
                
                // Update personnel availability to busy
                $personnel->availability_status = 'busy';
                $personnel->save();
                
                // Add tracking entry
                $delivery->addTracking('picked_up', 'Order picked up from sorting facility');
                
                Log::info('Delivery assigned to personnel #' . $personnel->id . ' for order #' . $order->order_number);
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Order picked up successfully! It is now out for delivery.'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Pickup failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Get available deliveries for assignment
    public function availableDeliveries()
    {
        $personnel = Auth::user()->deliveryPersonnel;
        
        $availableDeliveries = Delivery::whereNull('delivery_personnel_id')
            ->where('status', 'assigned')
            ->whereHas('order', function($query) {
                $query->where('status', 'processing')
                    ->orWhere('status', 'ready_for_delivery');
            })
            ->with('order', 'order.user', 'order.items')
            ->get();
        
        return view('delivery.available', compact('availableDeliveries'));
    }

    // Accept a delivery assignment
    public function acceptDelivery(Request $request, $deliveryId)
    {
        $delivery = Delivery::findOrFail($deliveryId);
        
        if ($delivery->delivery_personnel_id !== null) {
            return back()->with('error', 'This delivery has already been assigned.');
        }
        
        $personnel = Auth::user()->deliveryPersonnel;
        
        if ($personnel->availability_status !== 'available') {
            return back()->with('error', 'You are not available to accept deliveries. Please set your status to available.');
        }
        
        DB::transaction(function() use ($delivery, $personnel) {
            $delivery->update([
                'delivery_personnel_id' => $personnel->id,
                'assigned_at' => now(),
                'status' => 'assigned'
            ]);
            
            $delivery->addTracking('assigned', 'Delivery assigned to ' . $personnel->user->full_name);
            
            $personnel->updateAvailability();
        });
        
        return redirect()->route('delivery.dashboard')
            ->with('success', 'Delivery accepted successfully!');
    }

    // Update delivery status
    public function updateStatus(Request $request, $deliveryId)
    {
        $request->validate([
            'status' => 'required|in:picked_up,in_transit,delivered,failed',
            'notes' => 'nullable|string|max:500',
            'proof_image' => 'nullable|image|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ]);
        
        $delivery = Delivery::where('delivery_personnel_id', Auth::user()->deliveryPersonnel->id)
            ->findOrFail($deliveryId);
        
        $oldStatus = $delivery->status;
        $newStatus = $request->status;
        
        DB::transaction(function() use ($delivery, $request, $newStatus) {
            $updateData = ['status' => $newStatus];
            
            if ($newStatus == 'picked_up') {
                $updateData['picked_up_at'] = now();
            } elseif ($newStatus == 'delivered') {
                $updateData['delivered_at'] = now();
                
                if ($request->hasFile('proof_image')) {
                    $path = $request->file('proof_image')->store('delivery-proofs', 'public');
                    $updateData['proof_of_delivery'] = $path;
                }
            }
            
            $delivery->update($updateData);
            
            // Add tracking entry
            $delivery->addTracking(
                $newStatus,
                $request->notes,
                $request->latitude,
                $request->longitude
            );
            
            // Update order status if delivered
            if ($newStatus == 'delivered') {
                $delivery->order->update([
                    'status' => 'completed',
                    'shipping_status' => Order::SHIPPING_DELIVERED,
                    'delivered_at' => now()
                ]);
                
                // Update delivery personnel stats
                $personnel = $delivery->deliveryPersonnel;
                $personnel->increment('total_deliveries');
                $personnel->updateAvailability();
            }
            
            // Update order status if failed
            if ($newStatus == 'failed') {
                $delivery->order->update([
                    'status' => 'pending',
                    'shipping_status' => Order::SHIPPING_FAILED
                ]);
            }
            
            // If order is out for delivery, update shipping status
            if ($newStatus == 'in_transit') {
                $delivery->order->update([
                    'shipping_status' => Order::SHIPPING_OUT_FOR_DELIVERY
                ]);
            }
        });
        
        return redirect()->route('delivery.dashboard')
            ->with('success', 'Delivery status updated successfully!');
    }

    // View delivery details
    public function showDelivery($deliveryId)
    {
        $delivery = Delivery::where('delivery_personnel_id', Auth::user()->deliveryPersonnel->id)
            ->with(['order', 'order.user', 'order.items.product', 'tracking'])
            ->findOrFail($deliveryId);
        
        return view('delivery.show', compact('delivery'));
    }

    // Toggle availability status
    public function toggleAvailability(Request $request)
    {
        $personnel = Auth::user()->deliveryPersonnel;
        
        if (!$personnel) {
            return response()->json(['error' => 'Delivery profile not found'], 404);
        }
        
        $newStatus = $personnel->availability_status === 'available' ? 'busy' : 'available';
        
        // Check if has active deliveries before setting to available
        if ($newStatus === 'available') {
            $hasActiveDelivery = $personnel->activeDeliveries()->exists();
            if ($hasActiveDelivery) {
                return response()->json([
                    'available' => false,
                    'message' => 'Cannot set to available while you have active deliveries. Please complete your current deliveries first.'
                ]);
            }
        }
        
        $personnel->update(['availability_status' => $newStatus]);
        
        return response()->json([
            'available' => $newStatus === 'available',
            'status' => $newStatus
        ]);
    }

    // Update location (real-time tracking)
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'delivery_id' => 'required|exists:deliveries,id'
        ]);
        
        $personnel = Auth::user()->deliveryPersonnel;
        
        if (!$personnel) {
            return response()->json(['error' => 'Delivery profile not found'], 404);
        }
        
        // Update personnel location
        $personnel->update([
            'current_latitude' => $request->latitude,
            'current_longitude' => $request->longitude
        ]);
        
        // Add tracking for active delivery
        $delivery = Delivery::find($request->delivery_id);
        if ($delivery && $delivery->delivery_personnel_id == $personnel->id) {
            $delivery->addTracking(
                $delivery->status,
                'Location update',
                $request->latitude,
                $request->longitude
            );
        }
        
        return response()->json(['success' => true]);
    }

    // Track order for customer
    public function trackOrder($orderId)
    {
        $order = Order::with(['delivery', 'delivery.tracking', 'delivery.deliveryPersonnel.user'])
            ->findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('delivery.track', compact('order'));
    }
    
    // Mark order as out for delivery
    public function markAsOutForDelivery(Request $request, $orderId)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);
        
        try {
            DB::transaction(function () use ($request, $orderId) {
                $order = Order::findOrFail($orderId);
                $personnel = Auth::user()->deliveryPersonnel;
                
                // FIX: Check for BOTH status values
                $isAtSortingFacility = in_array($order->shipping_status, [
                    'sorting_facility', 
                    Order::SHIPPING_ARRIVED_AT_SORTING
                ]);
                
                if (!$isAtSortingFacility) {
                    throw new \Exception('Order is not ready for pickup. Current status: ' . ($order->shipping_status_text ?? $order->shipping_status));
                }
                
                // Check if personnel is available
                if ($personnel->availability_status !== 'available') {
                    throw new \Exception('You are not available. Please set your status to available.');
                }
                
                // Update order status
                $order->shipping_status = Order::SHIPPING_OUT_FOR_DELIVERY;
                $order->out_for_delivery_at = now();
                $order->save();
                
                // Create or update delivery record
                $delivery = $order->delivery;
                if (!$delivery) {
                    $delivery = Delivery::create([
                        'order_id' => $order->id,
                        'delivery_personnel_id' => $personnel->id,
                        'status' => 'picked_up',
                        'assigned_at' => now(),
                        'picked_up_at' => now(),
                        'delivery_notes' => $request->notes ?? 'Picked up from sorting facility'
                    ]);
                } else {
                    $delivery->update([
                        'delivery_personnel_id' => $personnel->id,
                        'status' => 'picked_up',
                        'picked_up_at' => now(),
                        'delivery_notes' => $request->notes ?? $delivery->delivery_notes
                    ]);
                }
                
                // Update personnel availability
                $personnel->availability_status = 'busy';
                $personnel->save();
                
                $delivery->addTracking('picked_up', $request->notes ?? 'Order picked up from sorting facility');
            });
            
            return redirect()->route('delivery.dashboard')
                ->with('success', 'Order marked as out for delivery!');
                
        } catch (\Exception $e) {
            Log::error('Failed to mark order as out for delivery: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }
    
    // Get available orders from sorting facility
    public function getAvailableOrders()
    {
        $personnel = Auth::user()->deliveryPersonnel;
        
        if (!$personnel) {
            return response()->json(['error' => 'Delivery profile not found'], 404);
        }
        
        // FIX: Check for BOTH status values
        $availableOrders = Order::where(function($query) {
                $query->where('shipping_status', 'sorting_facility')
                      ->orWhere('shipping_status', Order::SHIPPING_ARRIVED_AT_SORTING);
            })
            ->whereDoesntHave('delivery')
            ->with('payment')
            ->latest()
            ->get()
            ->map(function($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'created_at' => $order->created_at->setTimezone('Asia/Manila')->format('M d, Y h:i A'),
                    'shipping_address' => $order->shipping_address,
                    'total' => $order->total,
                    'payment_method' => $order->payment_method_text,
                    'items_count' => $order->items->count()
                ];
            });
        
        return response()->json([
            'success' => true,
            'orders' => $availableOrders
        ]);
    }

    public function showOrder($orderId)
    {
        $order = Order::with(['user', 'items.product', 'payment'])->findOrFail($orderId);
        
        return view('delivery.order-details', compact('order'));
    }
}