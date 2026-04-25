@extends('admin.layouts.admin')

@section('title', 'Manage Categories - Grocery Mart Admin')
@section('page-title', 'Manage Categories')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-tags me-2" style="color: var(--primary);"></i>Product Categories</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn-primary-custom">
                <i class="bi bi-plus-lg"></i> Add Category
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Categories Statistics -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card p-3 bg-white rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="stat-icon me-3" style="width: 50px; height: 50px; background: rgba(40, 167, 69, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-tags" style="color: var(--primary); font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Categories</div>
                        <div class="fw-bold fs-4">{{ $categories->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-3 bg-white rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="stat-icon me-3" style="width: 50px; height: 50px; background: rgba(40, 167, 69, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-box" style="color: var(--primary); font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Products</div>
                        <div class="fw-bold fs-4">{{ $totalProducts ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-3 bg-white rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="stat-icon me-3" style="width: 50px; height: 50px; background: rgba(40, 167, 69, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-check-circle" style="color: var(--primary); font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Active Categories</div>
                        <div class="fw-bold fs-4">{{ $activeCategories ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="row" id="categories-container">
        @forelse($categories as $category)
            <div class="col-md-4 col-lg-3 mb-4 category-item" data-id="{{ $category->id }}">
                <div class="content-card h-100 p-0 overflow-hidden">
                    <!-- Category Image - Now full width at top -->
                    <div class="position-relative" style="height: 180px; overflow: hidden;">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <!-- Default image based on category name -->
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--primary), var(--dark)); display: flex; align-items: center; justify-content: center;">
                                @php
                                    $defaultImages = [
                                        'Fresh Produce' => '🥬',
                                        'Dairy' => '🥛',
                                        'Beverages' => '🧃',
                                        'Snacks' => '🍪',
                                        'Bakery' => '🥖',
                                        'Meat & Seafood' => '🥩',
                                        'Frozen Foods' => '❄️',
                                        'Pantry Staples' => '🍚',
                                        'Household' => '🧹',
                                        'Personal Care' => '🧴',
                                    ];
                                    $emoji = $defaultImages[$category->name] ?? '📦';
                                @endphp
                                <span style="font-size: 4rem;">{{ $emoji }}</span>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="position-absolute top-0 end-0 m-2">
                            @if($category->is_active)
                                <span class="badge-success px-3 py-1">Active</span>
                            @else
                                <span class="badge-danger px-3 py-1">Inactive</span>
                            @endif
                        </div>
                        
                        <!-- Drag Handle -->
                        <div class="position-absolute top-0 start-0 m-2 cursor-move bg-white bg-opacity-75 rounded p-1" 
                             style="cursor: move; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-grip-vertical text-dark"></i>
                        </div>
                    </div>
                    
                    <!-- Category Info -->
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="mb-0 fw-bold">{{ $category->name }}</h5>
                            <span class="badge bg-primary text-white px-3 py-2">{{ $category->products_count ?? 0 }} products</span>
                        </div>
                        
                        @if($category->description)
                            <p class="small text-muted mb-3">{{ Str::limit($category->description, 60) }}</p>
                        @endif
                        
                        <!-- Quick Stats -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="bg-light rounded p-2 text-center">
                                    <small class="text-muted d-block">Featured</small>
                                    <span class="fw-600">{{ $category->featured_products_count ?? 0 }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded p-2 text-center">
                                    <small class="text-muted d-block">In Stock</small>
                                    <span class="fw-600">{{ $category->in_stock_products_count ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end mt-2">
                            <a href="{{ route('admin.products.index', ['category' => $category->name]) }}" 
                               class="btn btn-sm btn-outline-info" 
                               title="View Products">
                                <i class="bi bi-eye"></i> View Products
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="btn btn-sm btn-outline-primary" 
                               title="Edit Category">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirmDelete(event, 'Are you sure you want to delete this category? All products in this category will need to be reassigned.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Category" 
                                        {{ ($category->products_count ?? 0) > 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                        
                        @if(($category->products_count ?? 0) > 0)
                            <small class="text-danger d-block mt-2">
                                <i class="bi bi-exclamation-triangle"></i> 
                                Cannot delete category with products
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="content-card text-center py-5">
                    <i class="bi bi-tags" style="font-size: 4rem; color: var(--slate-300);"></i>
                    <h5 class="mt-3 text-muted">No Categories Found</h5>
                    <p class="text-muted">Get started by creating your first category</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn-primary-custom">
                        <i class="bi bi-plus-lg"></i> Add Category
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Category Preview Modal -->
<div class="modal fade" id="categoryPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Category Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="categoryPreviewContent">
                <!-- Content will be loaded via JavaScript -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .cursor-move {
        cursor: move;
    }
    .category-item.dragging {
        opacity: 0.5;
    }
    .content-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .badge-success {
        background: rgba(40, 167, 69, 0.9);
        color: white;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .badge-danger {
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .stat-card {
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Initialize sortable for drag-and-drop reordering
    const container = document.getElementById('categories-container');
    if (container) {
        const sortable = new Sortable(container, {
            animation: 150,
            handle: '.cursor-move',
            draggable: '.category-item',
            onEnd: function(evt) {
                // Get the new order
                const categories = [];
                document.querySelectorAll('.category-item').forEach(item => {
                    categories.push({
                        id: item.dataset.id,
                        order: Array.from(item.parentNode.children).indexOf(item)
                    });
                });
                
                // Save the new order via AJAX
                fetch('{{ route("admin.categories.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ categories: categories })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        // Show a subtle success notification
                        const toast = document.createElement('div');
                        toast.className = 'alert alert-success alert-custom position-fixed bottom-0 end-0 m-3';
                        toast.style.zIndex = '9999';
                        toast.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i> Category order saved!';
                        document.body.appendChild(toast);
                        
                        setTimeout(() => {
                            toast.remove();
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error saving order:', error);
                });
            }
        });
    }
    
    // Function to preview category products
    function previewCategory(categoryId, categoryName) {
        // You can implement AJAX loading of category products here
        window.location.href = `{{ route('admin.products.index') }}?category=${encodeURIComponent(categoryName)}`;
    }
</script>
@endpush