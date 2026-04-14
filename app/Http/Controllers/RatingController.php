<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RatingController extends Controller
{
    /**
     * Show the rating form for a product.
     */
    public function create(Order $order, Product $product)
    {
        // Check if order belongs to user and product is in order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if product is in the order
        $orderItem = $order->items()->where('product_id', $product->id)->first();
        if (!$orderItem) {
            abort(404);
        }

        // Check if already rated
        $existingRating = Rating::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingRating) {
            return redirect()->route('order.details', $order)
                ->with('info', 'You have already rated this product.');
        }

        return view('ratings.create', compact('order', 'product'));
    }

    /**
     * Store a new rating.
     */
    public function store(Request $request, $order, $product)
    {
        try {
            // Find the order and product models
            $orderModel = Order::findOrFail($order);
            $productModel = Product::findOrFail($product);
            
            // Check if order belongs to user
            if ($orderModel->user_id !== Auth::id()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized access'
                    ], 403);
                }
                abort(403);
            }

            // Check if product is in the order
            $orderItem = $orderModel->items()->where('product_id', $productModel->id)->first();
            if (!$orderItem) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found in this order'
                    ], 404);
                }
                abort(404);
            }

            // Check if already rated
            $existingRating = Rating::where('order_id', $orderModel->id)
                ->where('product_id', $productModel->id)
                ->first();

            if ($existingRating) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already rated this product'
                    ], 400);
                }
                return redirect()->route('order.details', $orderModel)
                    ->with('info', 'You have already rated this product.');
            }

            // Validate request
            $validator = validator($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'title' => 'nullable|string|max:100',
                'review' => 'nullable|string|max:1000',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }
                return back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            // Upload images if any
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('reviews', 'public');
                    $imagePaths[] = $path;
                }
            }

            // Create rating
            $rating = Rating::create([
                'order_id' => $orderModel->id,
                'user_id' => Auth::id(),
                'product_id' => $productModel->id,
                'rating' => $request->rating,
                'title' => $request->title,
                'review' => $request->review,
                'images' => $imagePaths,
                'is_verified_purchase' => true,
                'reviewed_at' => now(),
            ]);

            DB::commit();

            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your feedback! Your review has been submitted.',
                    'rating' => $rating,
                    'redirect' => route('order.details', $orderModel)
                ]);
            }

            return redirect()->route('order.details', $orderModel)
                ->with('success', 'Thank you for your feedback! Your review has been submitted.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Rating submission error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to submit review. Please try again.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
            
            return back()->with('error', 'Failed to submit review. Please try again.');
        }
    }

    /**
     * Display product ratings page.
     */
    public function productRatings(Product $product)
    {
        $ratings = $product->ratings()
            ->with('user')
            ->latest()
            ->paginate(10);

        $averageRating = $product->ratings()->avg('rating');
        $ratingCount = $product->ratings()->count();
        $ratingDistribution = [
            1 => $product->ratings()->where('rating', 1)->count(),
            2 => $product->ratings()->where('rating', 2)->count(),
            3 => $product->ratings()->where('rating', 3)->count(),
            4 => $product->ratings()->where('rating', 4)->count(),
            5 => $product->ratings()->where('rating', 5)->count(),
        ];

        return view('ratings.product', compact(
            'product', 'ratings', 'averageRating', 'ratingCount', 'ratingDistribution'
        ));
    }

    /**
     * Show all user ratings.
     */
    public function myRatings()
    {
        $ratings = Rating::where('user_id', Auth::id())
            ->with('product', 'order')
            ->latest()
            ->paginate(10);

        return view('ratings.my-ratings', compact('ratings'));
    }

    /**
     * Get user's rating for a specific order product (AJAX).
     */
    public function getUserRating($order, $product)
    {
        try {
            $orderModel = Order::findOrFail($order);
            $productModel = Product::findOrFail($product);
            
            if ($orderModel->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $rating = Rating::where('order_id', $orderModel->id)
                ->where('product_id', $productModel->id)
                ->first();
            
            return response()->json([
                'success' => true,
                'has_rated' => $rating ? true : false,
                'rating' => $rating
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get user rating error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve rating'
            ], 500);
        }
    }

    /**
     * Delete a rating 
     */
    public function destroy($rating)
    {
        try {
            $ratingModel = Rating::findOrFail($rating);
            
            if ($ratingModel->user_id !== Auth::id()) {
                abort(403);
            }
            
            // Delete associated images
            if ($ratingModel->images && is_array($ratingModel->images)) {
                foreach ($ratingModel->images as $image) {
                    if ($image && Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
            
            $ratingModel->delete();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Review deleted successfully.'
                ]);
            }
            
            return redirect()->route('ratings.my-ratings')
                ->with('success', 'Review deleted successfully.');
                
        } catch (\Exception $e) {
            Log::error('Rating deletion error: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete review. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to delete review. Please try again.');
        }
    }

    /**
     * Update a rating.
     */
    public function update(Request $request, $rating)
    {
        try {
            $ratingModel = Rating::findOrFail($rating);
            
            if ($ratingModel->user_id !== Auth::id()) {
                abort(403);
            }
            
            $validator = validator($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'title' => 'nullable|string|max:100',
                'review' => 'nullable|string|max:1000',
            ]);
            
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }
                return back()->withErrors($validator)->withInput();
            }
            
            $ratingModel->update([
                'rating' => $request->rating,
                'title' => $request->title,
                'review' => $request->review,
                'updated_at' => now(),
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Review updated successfully.',
                    'rating' => $ratingModel
                ]);
            }
            
            return redirect()->route('ratings.my-ratings')
                ->with('success', 'Review updated successfully.');
                
        } catch (\Exception $e) {
            Log::error('Rating update error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update review. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to update review. Please try again.');
        }
    }

    /**
     * Get rating summary for a product
     */
    public function getRatingSummary(Product $product)
    {
        try {
            $averageRating = $product->ratings()->avg('rating');
            $ratingCount = $product->ratings()->count();
            $ratingDistribution = [
                1 => $product->ratings()->where('rating', 1)->count(),
                2 => $product->ratings()->where('rating', 2)->count(),
                3 => $product->ratings()->where('rating', 3)->count(),
                4 => $product->ratings()->where('rating', 4)->count(),
                5 => $product->ratings()->where('rating', 5)->count(),
            ];
            
            return response()->json([
                'success' => true,
                'average_rating' => round($averageRating, 1),
                'rating_count' => $ratingCount,
                'distribution' => $ratingDistribution
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get rating summary error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve rating summary'
            ], 500);
        }
    }
}