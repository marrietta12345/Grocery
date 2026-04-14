@extends('admin.layouts.admin')

@section('title', 'Dashboard - Grocery Mart Admin')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-box"></i>
            </div>
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ $stats['total_products'] }}</div>
            <div class="stat-change text-success">
                <i class="bi bi-check-circle"></i> {{ $stats['active_products'] }} active
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-tags"></i>
            </div>
            <div class="stat-label">Categories</div>
            <div class="stat-value">{{ $stats['total_categories'] }}</div>
            <div class="stat-change">
                <i class="bi bi-grid"></i> Product categories
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-label">Low Stock</div>
            <div class="stat-value">{{ $stats['low_stock_products'] }}</div>
            <div class="stat-change text-warning">
                <i class="bi bi-clock"></i> {{ $stats['out_of_stock'] }} out of stock
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-label">Total Customers</div>
            <div class="stat-value">{{ $stats['total_regular_users'] }}</div>
            <div class="stat-change text-info">
                <i class="bi bi-shield"></i> {{ $stats['total_admins'] }} admins
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Products by Category -->
        <div class="col-lg-6">
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="bi bi-pie-chart me-2" style="color: var(--primary);"></i>Products by Category</h3>
                    <a href="{{ route('admin.products.index') }}" class="btn-outline-custom">View All</a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Products</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productsByCategory as $categoryData)
                                @php
                                    $percentage = $stats['total_products'] > 0 ? round(($categoryData->total / $stats['total_products']) * 100) : 0;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @switch($categoryData->category_name ?? $categoryData->category)
                                                @case('Fresh Produce')
                                                    <i class="bi bi-apple me-2" style="color: var(--primary);"></i>
                                                    @break
                                                @case('Dairy')
                                                    <i class="bi bi-cup-straw me-2" style="color: var(--primary);"></i>
                                                    @break
                                                @case('Beverages')
                                                    <i class="bi bi-cup me-2" style="color: var(--primary);"></i>
                                                    @break
                                                @case('Snacks')
                                                    <i class="bi bi-basket me-2" style="color: var(--primary);"></i>
                                                    @break
                                                @case('Bakery')
                                                    <i class="bi bi-basket me-2" style="color: var(--primary);"></i>
                                                    @break
                                                @case('Meat & Seafood')
                                                    <i class="bi bi-basket me-2" style="color: var(--primary);"></i>
                                                    @break
                                                @default
                                                    <i class="bi bi-tag me-2" style="color: var(--primary);"></i>
                                            @endswitch
                                            {{ $categoryData->category_name ?? $categoryData->category }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $categoryData->total }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                     style="width: {{ $percentage }}%;" 
                                                     aria-valuenow="{{ $percentage }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100"></div>
                                            </div>
                                            <span class="text-muted small">{{ $percentage }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <i class="bi bi-inbox fs-1 d-block text-muted mb-2"></i>
                                        <span class="text-muted">No products found</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Recent Products -->
        <div class="col-lg-6">
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="bi bi-clock-history me-2" style="color: var(--primary);"></i>Recent Products</h3>
                    <a href="{{ route('admin.products.create') }}" class="btn-primary-custom">
                        <i class="bi bi-plus-lg"></i> Add Product
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProducts as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="product-img-thumb me-2" style="width: 40px; height: 40px; border-radius: 8px; overflow: hidden; background: var(--slate-100); display: flex; align-items: center; justify-content: center;">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <i class="bi bi-box" style="color: var(--primary);"></i>
                                                @endif
                                            </div>
                                            <div class="ms-2">
                                                <div class="fw-600">{{ $product->name }}</div>
                                                <small class="text-muted">{{ $product->brand }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($product->category)
                                            <span class="badge bg-light text-dark">{{ $product->category->name ?? $product->category }}</span>
                                        @else
                                            <span class="badge bg-secondary">No Category</span>
                                        @endif
                                    </td>
                                    <td>₱{{ number_format($product->price, 2) }}</td>
                                    <td>
                                        @php
                                            $stockClass = $product->stock_status['class'] ?? 'secondary';
                                            $stockLabel = $product->stock_status['label'] ?? 'Unknown';
                                        @endphp
                                        <span class="badge bg-{{ $stockClass }} text-white px-2 py-1">{{ $stockLabel }}</span>
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success text-white px-2 py-1">Active</span>
                                        @else
                                            <span class="badge bg-danger text-white px-2 py-1">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-inbox fs-1 d-block text-muted mb-2"></i>
                                        <span class="text-muted">No recent products</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="bi bi-exclamation-triangle me-2" style="color: var(--warning);"></i>Low Stock Alert</h3>
                    <a href="{{ route('admin.products.index', ['stock' => 'low_stock']) }}" class="btn-outline-custom">View All</a>
                </div>
                
                @if($lowStockProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Current Stock</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockProducts as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="product-img-thumb me-2" style="width: 40px; height: 40px; border-radius: 8px; overflow: hidden; background: var(--slate-100); display: flex; align-items: center; justify-content: center;">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <i class="bi bi-box" style="color: var(--primary);"></i>
                                                    @endif
                                                </div>
                                                <div class="ms-2">
                                                    <div class="fw-600">{{ $product->name }}</div>
                                                    <small class="text-muted">{{ $product->brand }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($product->category)
                                                <span class="badge bg-light text-dark">{{ $product->category->name ?? $product->category }}</span>
                                            @else
                                                <span class="badge bg-secondary">No Category</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $product->stock_status['class'] ?? 'warning' }} text-white px-3 py-2">
                                                {{ $product->stock }} units
                                            </span>
                                        </td>
                                        <td>
                                            @if($product->is_active)
                                                <span class="badge bg-success text-white px-3 py-2">Active</span>
                                            @else
                                                <span class="badge bg-danger text-white px-3 py-2">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-custom">
                                                <i class="bi bi-pencil"></i> Update Stock
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle fs-1 text-success mb-2 d-block"></i>
                        <p class="text-muted">All products have sufficient stock!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="bi bi-lightning-charge me-2" style="color: var(--primary);"></i>Quick Actions</h3>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-4 col-sm-6">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-custom w-100 py-3">
                            <i class="bi bi-plus-circle d-block fs-3 mb-2"></i>
                            <span>Add New Product</span>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-custom w-100 py-3">
                            <i class="bi bi-tag d-block fs-3 mb-2"></i>
                            <span>Add Category</span>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <a href="{{ route('admin.products.index', ['stock' => 'low_stock']) }}" class="btn btn-outline-custom w-100 py-3">
                            <i class="bi bi-exclamation-triangle d-block fs-3 mb-2"></i>
                            <span>Check Low Stock</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize any charts if needed
    $(document).ready(function() {
        // You can add charts here using Chart.js
    });
</script>
@endpush