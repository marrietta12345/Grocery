<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Get or create cart for current user/session
     */
    private function getCart()
    {
        try {
            if (Auth::check()) {
                $cart = Cart::firstOrCreate(
                    ['user_id' => Auth::id()],
                    [
                        'session_id' => session()->getId(),
                        'subtotal' => 0,
                        'discount' => 0,
                        'total' => 0
                    ]
                );
            } else {
                $cart = Cart::firstOrCreate(
                    ['session_id' => session()->getId()],
                    [
                        'user_id' => null,
                        'subtotal' => 0,
                        'discount' => 0,
                        'total' => 0
                    ]
                );
            }
            
            return $cart;
        } catch (\Exception $e) {
            Log::error('Cart creation error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Display cart page
     */
    public function index()
    {
        $cart = $this->getCart();
        
        if (!$cart) {
            return view('cart', ['cart' => null]);
        }
        
        $cart->load('items.product.category');
        
        return view('cart', compact('cart'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('Cart add request received', [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'ajax' => $request->ajax(),
            'wants_json' => $request->wantsJson()
        ]);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();
            
            $product = Product::findOrFail($request->product_id);
            
            if ($product->stock < $request->quantity) {
                DB::rollBack();
                return $this->jsonResponse(false, 'Insufficient stock available. Only ' . $product->stock . ' units left.', $request);
            }

            $cart = $this->getCart();
            
            if (!$cart) {
                DB::rollBack();
                return $this->jsonResponse(false, 'Unable to create or retrieve cart.', $request);
            }

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                // Update existing item
                $newQuantity = $cartItem->quantity + $request->quantity;
                if ($product->stock < $newQuantity) {
                    DB::rollBack();
                    return $this->jsonResponse(false, 'Insufficient stock available. Only ' . $product->stock . ' units left.', $request);
                }
                
                $cartItem->quantity = $newQuantity;
                $cartItem->subtotal = $cartItem->price * $cartItem->quantity;
                $cartItem->save();
                
                $message = 'Cart updated successfully!';
            } else {
                // Create new item
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'price' => $product->price,
                    'subtotal' => $product->price * $request->quantity,
                ]);
                
                $message = 'Product added to cart successfully!';
            }

            // Update cart totals
            $cart->load('items');
            $this->updateCartTotals($cart);
            
            // Get updated cart count
            $cartCount = $cart->items->sum('quantity');
            
            DB::commit();

            Log::info('Cart add successful', [
                'cart_id' => $cart->id,
                'cart_count' => $cartCount,
                'message' => $message
            ]);

            return $this->jsonResponse(true, $message, $request, [
                'cart_count' => $cartCount,
                'cart_total' => number_format($cart->total, 2),
                'cart_subtotal' => number_format($cart->subtotal, 2),
                'cart_discount' => number_format($cart->discount, 2)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Cart add error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return $this->jsonResponse(false, 'Failed to add product to cart. Please try again.', $request, [], 500);
        }
    }

    /**
     * Helper method to handle JSON responses
     */
    private function jsonResponse($success, $message, $request, $extra = [], $status = 200)
    {
        $response = array_merge([
            'success' => $success,
            'message' => $message
        ], $extra);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($response, $status);
        }

        if ($success) {
            return redirect()->route('cart.index')->with('success', $message);
        } else {
            return back()->with('error', $message);
        }
    }

    /**
     * Update cart totals
     */
    private function updateCartTotals(Cart $cart)
    {
        $subtotal = $cart->items->sum('subtotal');
        $discount = $cart->discount ?? 0;
        $total = $subtotal - $discount;
        
        $cart->subtotal = $subtotal;
        $cart->total = $total;
        $cart->save();
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();
            
            $product = $cartItem->product;
            
            if ($product->stock < $request->quantity) {
                DB::rollBack();
                return back()->with('error', 'Insufficient stock available. Only ' . $product->stock . ' units left.');
            }

            $cartItem->quantity = $request->quantity;
            $cartItem->subtotal = $cartItem->price * $cartItem->quantity;
            $cartItem->save();

            $cartItem->cart->load('items');
            $this->updateCartTotals($cartItem->cart);
            
            DB::commit();

            return back()->with('success', 'Cart updated successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Cart update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update cart. Please try again.');
        }
    }

    /**
     * Remove item from cart
     */
    public function remove(CartItem $cartItem)
    {
        try {
            DB::beginTransaction();
            
            $cart = $cartItem->cart;
            $cartItem->delete();

            $cart->load('items');
            $this->updateCartTotals($cart);
            
            DB::commit();

            return back()->with('success', 'Item removed from cart.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Cart remove error: ' . $e->getMessage());
            return back()->with('error', 'Failed to remove item. Please try again.');
        }
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        try {
            DB::beginTransaction();
            
            $cart = $this->getCart();
            
            if ($cart) {
                $cart->items()->delete();
                $cart->subtotal = 0;
                $cart->discount = 0;
                $cart->total = 0;
                $cart->promo_code = null;
                $cart->save();
            }
            
            DB::commit();

            return back()->with('success', 'Cart cleared successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Cart clear error: ' . $e->getMessage());
            return back()->with('error', 'Failed to clear cart. Please try again.');
        }
    }

    /**
     * Apply promo code - UPDATED with better validation
     */
    public function applyPromo(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string',
        ]);

        try {
            DB::beginTransaction();
            
            $cart = $this->getCart();
            
            if (!$cart) {
                DB::rollBack();
                return back()->with('error', 'Unable to retrieve cart.');
            }
            
            // Case-insensitive search for the promo code
            $promotion = Promotion::whereRaw('UPPER(code) = ?', [strtoupper($request->promo_code)])
                ->where('is_active', true)
                ->first();

            if (!$promotion) {
                DB::rollBack();
                Log::info('Promo code not found: ' . $request->promo_code);
                return back()->with('error', 'Invalid promo code. Code "' . $request->promo_code . '" not found.');
            }

            // Check if promotion is valid with detailed error messages
            if (!$promotion->is_active) {
                DB::rollBack();
                return back()->with('error', 'This promo code is currently inactive.');
            }

            // Check start date
            if ($promotion->starts_at && now()->lt($promotion->starts_at)) {
                DB::rollBack();
                return back()->with('error', 'This promo code starts on ' . $promotion->starts_at->format('M d, Y'));
            }

            // Check expiry date
            if ($promotion->expires_at && now()->gt($promotion->expires_at)) {
                DB::rollBack();
                return back()->with('error', 'This promo code expired on ' . $promotion->expires_at->format('M d, Y'));
            }

            // Check usage limit
            if ($promotion->usage_limit && $promotion->used_count >= $promotion->usage_limit) {
                DB::rollBack();
                return back()->with('error', 'This promo code has reached its usage limit.');
            }

            // Check minimum order amount
            if ($promotion->min_order_amount && $cart->subtotal < $promotion->min_order_amount) {
                DB::rollBack();
                return back()->with('error', 'This promo requires a minimum order of ₱' . number_format($promotion->min_order_amount, 2));
            }

            // Calculate discount
            $discount = 0;
            if ($promotion->type === 'percentage') {
                $discount = ($cart->subtotal * $promotion->value) / 100;
                $discountMessage = $promotion->value . '% off';
            } else {
                // fixed amount
                $discount = min($promotion->value, $cart->subtotal);
                $discountMessage = '₱' . number_format($promotion->value, 2) . ' off';
            }
            
            $cart->discount = $discount;
            $cart->promo_code = $promotion->code;
            $cart->total = $cart->subtotal - $discount;
            $cart->save();
            
            // Increment usage count
            $promotion->increment('used_count');
            
            DB::commit();

            return back()->with('success', 'Promo code applied successfully! You saved ₱' . number_format($discount, 2) . ' (' . $discountMessage . ')');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Promo code error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return back()->with('error', 'Failed to apply promo code. Please try again.');
        }
    }

    /**
     * Remove promo code
     */
    public function removePromo()
    {
        try {
            DB::beginTransaction();
            
            $cart = $this->getCart();
            
            if ($cart) {
                // Decrement usage count for the promo code
                if ($cart->promo_code) {
                    $promotion = Promotion::where('code', $cart->promo_code)->first();
                    if ($promotion && $promotion->used_count > 0) {
                        $promotion->decrement('used_count');
                    }
                }
                
                $cart->discount = 0;
                $cart->promo_code = null;
                $cart->total = $cart->subtotal;
                $cart->save();
            }
            
            DB::commit();

            return back()->with('success', 'Promo code removed.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Remove promo error: ' . $e->getMessage());
            return back()->with('error', 'Failed to remove promo code. Please try again.');
        }
    }

    /**
     * Get cart count for AJAX
     */
    public function getCartCount()
    {
        try {
            $cart = $this->getCart();
            
            if (!$cart) {
                return response()->json([
                    'success' => false,
                    'count' => 0,
                    'total' => '0.00',
                    'message' => 'Unable to retrieve cart'
                ]);
            }
            
            $cart->load('items');
            
            return response()->json([
                'success' => true,
                'count' => $cart->items->sum('quantity'),
                'total' => number_format($cart->total, 2),
                'subtotal' => number_format($cart->subtotal, 2),
                'discount' => number_format($cart->discount, 2)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get cart count error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'count' => 0,
                'total' => '0.00',
                'message' => 'Error retrieving cart'
            ], 500);
        }
    }

    /**
     * Debug method to check cart status
     */
    public function debug()
    {
        $cart = $this->getCart();
        $cart->load('items.product');
        
        return response()->json([
            'cart' => $cart,
            'items_count' => $cart->items->count(),
            'total_quantity' => $cart->items->sum('quantity'),
            'session_id' => session()->getId(),
            'user_id' => Auth::id(),
            'authenticated' => Auth::check()
        ]);
    }
}