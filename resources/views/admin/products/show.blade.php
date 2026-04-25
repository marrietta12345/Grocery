@extends('admin.layouts.admin')

@section('title', $product->name . ' - Product Details')
@section('page-title', 'Product Details: ' . $product->name)

@push('styles')
<style>
    .content-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--slate-200);
        margin-bottom: 1.5rem;
    }
    
    .badge-success {
        background: var(--primary);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-danger {
        background: var(--danger);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-warning {
        background: var(--warning);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    
    .btn-primary-custom {
        background: var(--dark);
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-primary-custom:hover {
        background: var(--primary);
        transform: translateY(-2px);
        color: white;
    }
    
    .btn-outline-custom {
        background: white;
        border: 1px solid var(--slate-200);
        color: var(--slate-600);
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-outline-custom:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .btn-danger-custom {
        background: white;
        border: 1px solid var(--danger);
        color: var(--danger);
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-danger-custom:hover {
        background: var(--danger);
        color: white;
    }
    
    .fw-600 {
        font-weight: 600;
    }
    
    .table-sm th,
    .table-sm td {
        padding: 0.5rem;
        font-size: 0.85rem;
    }
    
    @media (max-width: 768px) {
        .content-card {
            padding: 1rem;
        }
        
        .btn-primary-custom,
        .btn-outline-custom,
        .btn-danger-custom {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Action Buttons -->
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('admin.products.index') }}" class="btn-outline-custom">
                    <i class="bi bi-arrow-left"></i> Back to Products
                </a>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn-primary-custom">
                    <i class="bi bi-pencil"></i> Edit Product
                </a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" 
                      onsubmit="return confirmDelete(event, 'Are you sure you want to delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger-custom">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-4">
            <div class="content-card">
                <h5 class="mb-3">Product Images</h5>
                
                <!-- Main Image -->
                <div class="text-center mb-3">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             class="img-fluid rounded" style="max-height: 300px; width: 100%; object-fit: contain;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                            <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                        </div>
                    @endif
                </div>

                <!-- Gallery Images -->
                @if($product->gallery && count($product->gallery) > 0)
                    <h6 class="mt-3 mb-2">Gallery</h6>
                    <div class="row g-2">
                        @foreach($product->gallery as $image)
                            <div class="col-4">
                                <img src="{{ asset('storage/' . $image) }}" alt="Gallery" 
                                     class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-8">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4>{{ $product->name }}</h4>
                        <p class="text-muted mb-2">Brand: <strong>{{ $product->brand ?? 'N/A' }}</strong> | SKU: <strong>{{ $product->sku ?? 'N/A' }}</strong></p>
                    </div>
                    <div>
                        @if($product->is_active)
                            <span class="badge-success">Active</span>
                        @else
                            <span class="badge-danger">Inactive</span>
                        @endif
                        
                        @if($product->is_featured)
                            <span class="badge-warning ms-2">Featured</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="border rounded p-3 text-center">
                            <div class="text-muted small">Category</div>
                            <div class="fw-600">
                                @if($product->category)
                                    {{ is_object($product->category) ? $product->category->name : $product->category }}
                                @else
                                    Uncategorized
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3 text-center">
                            <div class="text-muted small">Price</div>
                            <div class="fw-600 text-primary">₱{{ number_format($product->price, 2) }}</div>
                            @if($product->old_price)
                                <small class="text-muted text-decoration-line-through">₱{{ number_format($product->old_price, 2) }}</small>
                                @php
                                    $discountPercentage = round((($product->old_price - $product->price) / $product->old_price) * 100);
                                @endphp
                                <span class="badge-danger ms-1">-{{ $discountPercentage }}%</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3 text-center">
                            <div class="text-muted small">Stock</div>
                            <div class="fw-600 {{ $product->stock > 10 ? 'text-success' : ($product->stock > 0 ? 'text-warning' : 'text-danger') }}">
                                {{ $product->stock }} units
                            </div>
                            <small class="text-muted">
                                @if($product->stock > 10)
                                    In Stock
                                @elseif($product->stock > 0)
                                    Low Stock
                                @else
                                    Out of Stock
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3 text-center">
                            <div class="text-muted small">Weight/Unit</div>
                            <div class="fw-600">
                                @if($product->weight)
                                    {{ $product->weight }} {{ $product->unit ?? 'g' }}
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <h6 class="mb-2">Description</h6>
                    <div class="bg-light p-3 rounded">
                        {{ $product->description ?? 'No description available.' }}
                    </div>
                </div>

                <!-- Meta Information -->
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-2">Meta Information</h6>
                        <table class="table table-sm">
                              <tr>
                                <th width="120">Created:</th>
                                <td>{{ $product->created_at ? $product->created_at->format('M d, Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Updated:</th>
                                <td>{{ $product->updated_at ? $product->updated_at->format('M d, Y H:i') : 'N/A' }}</td>
                            </tr>
                            @if($product->meta_title)
                            <tr>
                                <th>Meta Title:</th>
                                <td>{{ $product->meta_title }}</td>
                            </tr>
                            @endif
                            @if($product->meta_description)
                            <tr>
                                <th>Meta Desc:</th>
                                <td>{{ Str::limit($product->meta_description, 100) }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="mb-2">Quick Actions</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="btn-outline-custom" data-bs-toggle="modal" data-bs-target="#stockModal">
                                <i class="bi bi-box"></i> Update Stock
                            </button>
                            <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-outline-custom">
                                    <i class="bi bi-star{{ $product->is_featured ? '-fill' : '' }}"></i> 
                                    {{ $product->is_featured ? 'Remove Featured' : 'Mark Featured' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stock Update Modal -->
<div class="modal fade" id="stockModal" tabindex="-1">
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
                    <div class="alert alert-info small">
                        <i class="bi bi-info-circle me-2"></i>
                        Current stock value: ₱{{ number_format(($product->price ?? 0) * ($product->stock ?? 0), 2) }}
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

<script>
    function confirmDelete(event, message) {
        if (!confirm(message)) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>
@endsection