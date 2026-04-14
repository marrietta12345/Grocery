@extends('admin.layouts.admin')

@section('title', 'Manage Products - Grocery Mart Admin')
@section('page-title', 'Manage Products')

@section('content')
<div class="container-fluid">
    <!-- Filters and Search -->
    <div class="content-card mb-4">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small mb-1">Search</label>
                <div class="search-box position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3" style="color: var(--slate-400); z-index: 10;"></i>
                    <input type="text" name="search" class="form-control ps-5" placeholder="Search products..." value="{{ request('search') }}" style="padding-left: 2.8rem !important;">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Category</label>
                <select name="category" class="form-select">
                    <option value="all">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Stock Status</label>
                <select name="stock" class="form-select">
                    <option value="all">All Stock</option>
                    <option value="in_stock" {{ request('stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="low_stock" {{ request('stock') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out_of_stock" {{ request('stock') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="all">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn-primary-custom flex-fill">Filter</button>
                <a href="{{ route('admin.products.index') }}" class="btn-outline-custom flex-fill">Reset</a>
                <a href="{{ route('admin.products.create') }}" class="btn-primary-custom flex-fill">
                    <i class="bi bi-plus-lg"></i> Add
                </a>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="content-card">
        <div class="card-header d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0"><i class="bi bi-box me-2" style="color: var(--primary);"></i>Products List</h3>
            <span class="badge-success px-3 py-2">{{ $products->total() }} Total Products</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="40" class="text-center">
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                        <th width="60">ID</th>
                        <th>Product</th>
                        <th width="120">Category</th>
                        <th width="100">Price</th>
                        <th width="100">Stock</th>
                        <th width="90">Status</th>
                        <th width="90">Featured</th>
                        <th width="200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="product-checkbox form-check-input" value="{{ $product->id }}">
                            </td>
                            <td><span class="fw-600">#{{ $product->id }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-img-thumb me-3" style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; background: var(--slate-100); display: flex; align-items: center; justify-content: center;">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-image text-muted" style="font-size: 1.5rem;"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-600">{{ $product->name }}</div>
                                        <small class="text-muted">{{ $product->brand }} | SKU: {{ $product->sku ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($product->category)
                                    <span class="badge bg-light text-dark px-3 py-2">{{ $product->category->name ?? $product->category }}</span>
                                @else
                                    <span class="badge bg-secondary text-white px-3 py-2">No Category</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-600">₱{{ number_format($product->price, 2) }}</span>
                            </td>
                            <td>
                                @php
                                    $stockClass = $product->stock_status['class'] ?? 'secondary';
                                    $stockLabel = $product->stock_status['label'] ?? 'Unknown';
                                @endphp
                                <span class="badge bg-{{ $stockClass }} text-white px-3 py-2">{{ $stockLabel }} ({{ $product->stock }})</span>
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success text-white px-3 py-2">Active</span>
                                @else
                                    <span class="badge bg-danger text-white px-3 py-2">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $product->is_featured ? 'btn-warning' : 'btn-outline-secondary' }}" 
                                            title="{{ $product->is_featured ? 'Remove Featured' : 'Mark Featured' }}"
                                            style="width: 36px; height: 36px; border-radius: 8px;">
                                        <i class="bi bi-star{{ $product->is_featured ? '-fill' : '' }}"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-info" title="View" style="width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary" title="Edit" style="width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirmDelete(event, 'Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" style="width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-warning" title="Update Stock" 
                                            data-bs-toggle="modal" data-bs-target="#stockModal{{ $product->id }}"
                                            style="width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-box"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Stock Update Modal -->
                        <div class="modal fade" id="stockModal{{ $product->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Stock - {{ $product->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.products.update-stock', $product) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Current Stock</label>
                                                <input type="number" class="form-control" value="{{ $product->stock }}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">New Stock Quantity</label>
                                                <input type="number" name="stock" class="form-control" min="0" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn-primary-custom">Update Stock</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="bi bi-box" style="font-size: 4rem; color: var(--slate-300);"></i>
                                <h5 class="mt-3 text-muted">No Products Found</h5>
                                <p class="text-muted">Get started by adding your first product</p>
                                <a href="{{ route('admin.products.create') }}" class="btn-primary-custom">
                                    <i class="bi bi-plus-lg"></i> Add Product
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-end">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="fixed-bottom mb-4 me-4" style="left: auto; z-index: 999;">
        <div class="card shadow-lg border-0" id="bulkActions" style="display: none; border-radius: 12px;">
            <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-600" id="selectedCount">0</span>
                    <span class="text-muted">products selected</span>
                    <button type="button" class="btn btn-danger btn-sm px-4" onclick="bulkDelete()">
                        <i class="bi bi-trash me-2"></i>Delete
                    </button>
                    <button type="button" class="btn btn-light btn-sm px-4" onclick="clearSelection()">
                        <i class="bi bi-x me-2"></i>Clear
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form id="bulkDeleteForm" action="{{ route('admin.products.bulk-delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="ids" id="bulkIds">
    </form>
</div>
@endsection

@push('styles')
<style>
    /* Table Styles */
    .table th {
        font-weight: 600;
        color: var(--slate-700);
        border-bottom-width: 2px;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    
    /* Product Image Thumbnail */
    .product-img-thumb {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }
    
    .product-img-thumb:hover {
        transform: scale(1.1);
    }
    
    /* Badge Styles */
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    
    /* Button Styles */
    .btn-sm {
        padding: 0;
        line-height: 1;
    }
    
    .btn-outline-info:hover,
    .btn-outline-primary:hover,
    .btn-outline-danger:hover,
    .btn-outline-warning:hover {
        transform: translateY(-2px);
        transition: transform 0.2s;
    }
    
    /* Bulk Actions */
    #bulkActions .card {
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Checkbox Styles */
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    /* Search Box Styles */
    .search-box .bi-search {
        left: 1rem;
        pointer-events: none;
    }
    
    .search-box input {
        padding-left: 2.8rem !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Select All functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    // Individual checkboxes
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        const checked = document.querySelectorAll('.product-checkbox:checked');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');

        if (checked.length > 0) {
            bulkActions.style.display = 'block';
            selectedCount.textContent = checked.length;
        } else {
            bulkActions.style.display = 'none';
            document.getElementById('selectAll').checked = false;
        }
    }

    function clearSelection() {
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
        updateBulkActions();
    }

    function bulkDelete() {
        const checked = document.querySelectorAll('.product-checkbox:checked');
        const ids = Array.from(checked).map(cb => cb.value).join(',');

        if (confirm(`Are you sure you want to delete ${checked.length} products?`)) {
            document.getElementById('bulkIds').value = ids;
            document.getElementById('bulkDeleteForm').submit();
        }
    }

    // Confirm delete function
    function confirmDelete(event, message) {
        if (!confirm(message)) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>
@endpush