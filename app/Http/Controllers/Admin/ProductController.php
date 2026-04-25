<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhereHas('category', function($catQuery) use ($search) {
                      $catQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            if (is_numeric($request->category)) {
                // Filter by category ID
                $query->where('category_id', $request->category);
            } else {
                // Filter by category name 
                $query->whereHas('category', function($q) use ($request) {
                    $q->where('name', $request->category);
                });
            }
        }

        // Filter by stock status
        if ($request->has('stock') && $request->stock != 'all') {
            switch ($request->stock) {
                case 'in_stock':
                    $query->where('stock', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('stock', '<=', 0);
                    break;
                case 'low_stock':
                    $query->where('stock', '<', 10)->where('stock', '>', 0);
                    break;
            }
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured != 'all') {
            $query->where('is_featured', $request->featured === 'yes');
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('is_active', $request->status === 'active');
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $products = $query->paginate(15)->withQueryString();
        
        // Get categories for filter dropdown
        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show form to create new product
     */
    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->get();
            
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store new product with image upload
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', 
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'weight' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:20',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp', 
        ]);

        $data = $request->except('image');
        
        // Handle main image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $imageName, 'public');
            $data['image'] = $path;
        }

        // Set boolean fields
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show form to edit product
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->get();
            
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', 
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'weight' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:20',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp', 
        ]);

        $data = $request->except('image');
        
        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $imageName, 'public');
            $data['image'] = $path;
        }

        // Set boolean fields
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Delete product
     */
    public function destroy(Product $product)
    {
        // Delete product image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Bulk delete products
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|string',
        ]);

        $ids = explode(',', $request->ids);
        
        $products = Product::whereIn('id', $ids)->get();
        
        foreach ($products as $product) {
            // Delete product image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $product->delete();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Selected products deleted successfully.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);

        return back()->with('success', 'Product featured status updated.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'Product visibility updated.');
    }

    /**
     * Update stock level
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->update(['stock' => $request->stock]);

        return back()->with('success', 'Stock updated successfully.');
    }

    /**
     * Get products by category 
     */
    public function byCategory(Category $category)
    {
        $products = $category->products()
            ->where('is_active', true)
            ->paginate(12);
            
        return response()->json($products);
    }
}