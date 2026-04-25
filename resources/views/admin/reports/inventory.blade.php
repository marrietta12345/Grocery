@extends('admin.layouts.admin')

@section('title', 'Inventory Report - Grocery Mart Admin')
@section('page-title', 'Inventory Report')

@section('content')
<div class="container-fluid">
    <!-- Summary Stats -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-box"></i>
            </div>
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ number_format($summary['total_products'] ?? 0) }}</div>
            <div class="stat-change">Active: {{ number_format(($summary['total_products'] ?? 0) - ($summary['inactive_count'] ?? 0)) }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-calculator"></i>
            </div>
            <div class="stat-label">Total Inventory Value</div>
            <div class="stat-value">₱{{ number_format($summary['total_value'] ?? 0, 2) }}</div>
            <div class="stat-change positive">Total asset value</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-label">Low Stock Items</div>
            <div class="stat-value {{ ($summary['low_stock_count'] ?? 0) > 0 ? 'text-warning' : '' }}">
                {{ number_format($summary['low_stock_count'] ?? 0) }}
            </div>
            <div class="stat-change">Need reorder soon</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="stat-label">Out of Stock</div>
            <div class="stat-value {{ ($summary['out_of_stock_count'] ?? 0) > 0 ? 'text-danger' : '' }}">
                {{ number_format($summary['out_of_stock_count'] ?? 0) }}
            </div>
            <div class="stat-change">Critical stock</div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-label">In Stock (>10 units)</div>
                <div class="stat-value">{{ number_format($summary['in_stock_count'] ?? 0) }}</div>
                <div class="stat-change">Well stocked items</div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-tags"></i>
                </div>
                <div class="stat-label">Total Categories</div>
                <div class="stat-value">{{ number_format($summary['total_categories'] ?? 0) }}</div>
                <div class="stat-change">Product categories</div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="stat-label">Featured Products</div>
                <div class="stat-value">{{ number_format($featuredCount ?? 0) }}</div>
                <div class="stat-change">Promoted items</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="content-card mb-4">
        <div class="card-header">
            <h3><i class="bi bi-funnel me-2" style="color: var(--primary);"></i>Filter Inventory</h3>
            <div>
                <span class="badge-info px-3 py-2">
                    <i class="bi bi-info-circle"></i> {{ $products->total() ?? 0 }} products found
                </span>
            </div>
        </div>
        <form method="GET" action="{{ route('admin.reports.inventory') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small mb-1">Search</label>
                <div class="search-box position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3" style="color: var(--slate-400); z-index: 10;"></i>
                    <input type="text" name="search" class="form-control ps-5" placeholder="Search by name, SKU, brand..." value="{{ request('search', '') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} ({{ $category->products_count ?? 0 }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Stock Status</label>
                <select name="stock_status" class="form-select">
                    <option value="">All Stock</option>
                    <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>✅ In Stock (>10)</option>
                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>⚠️ Low Stock (1-10)</option>
                    <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>❌ Out of Stock (0)</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">&nbsp;</label>
                <button type="submit" class="btn-primary-custom w-100">
                    <i class="bi bi-search"></i> Apply
                </button>
            </div>
            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.reports.inventory.export') }}?{{ http_build_query(request()->query()) }}" 
                   class="btn-outline-custom">
                    <i class="bi bi-download me-2"></i> Export Report
                </a>
                <a href="{{ route('admin.reports.inventory') }}" class="btn-outline-custom">
                    <i class="bi bi-x me-2"></i> Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Charts Row -->
    <div class="row g-4">
        <!-- Stock by Category Chart -->
        <div class="col-md-6">
            <div class="content-card h-100">
                <div class="card-header">
                    <h3><i class="bi bi-pie-chart me-2" style="color: var(--primary);"></i>Stock Distribution by Category</h3>
                </div>
                <div style="position: relative; height: 350px; width: 100%;">
                    <canvas id="stockByCategoryChart"></canvas>
                </div>
                <div class="mt-3">
                    @if(isset($stockByCategory) && $stockByCategory->count())
                        @foreach($stockByCategory->take(5) as $category)
                            @php
                                $percentage = ($category->total_stock / max(1, $stockByCategory->sum('total_stock'))) * 100;
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small">{{ $category->category->name ?? 'Uncategorized' }}</span>
                                <div class="d-flex gap-3">
                                    <span class="small">{{ number_format($category->total_stock) }} units</span>
                                    <span class="small text-muted">{{ number_format($percentage, 1) }}%</span>
                                </div>
                            </div>
                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-bar-chart"></i>
                            <p class="mt-2">No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Inventory Value by Category -->
        <div class="col-md-6">
            <div class="content-card h-100">
                <div class="card-header">
                    <h3><i class="bi bi-bar-chart me-2" style="color: var(--primary);"></i>Inventory Value by Category</h3>
                </div>
                <div style="position: relative; height: 350px; width: 100%;">
                    <canvas id="valueByCategoryChart"></canvas>
                </div>
                <div class="mt-3">
                    @if(isset($stockByCategory) && $stockByCategory->count())
                        @foreach($stockByCategory->sortByDesc('total_value')->take(5) as $category)
                            @php
                                $percentage = ($category->total_value / max(1, $stockByCategory->sum('total_value'))) * 100;
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small">{{ $category->category->name ?? 'Uncategorized' }}</span>
                                <div class="d-flex gap-3">
                                    <span class="small">₱{{ number_format($category->total_value, 2) }}</span>
                                    <span class="small text-muted">{{ number_format($percentage, 1) }}%</span>
                                </div>
                            </div>
                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-bar-chart"></i>
                            <p class="mt-2">No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Health Dashboard -->
    <div class="row g-4 mt-2">
        <div class="col-md-12">
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="bi bi-heart-pulse me-2" style="color: var(--primary);"></i>Stock Health Dashboard</h3>
                    <span class="badge-success px-3 py-2">Inventory Status Overview</span>
                </div>
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="p-3">
                            <div class="display-4 text-success">{{ number_format($summary['in_stock_count'] ?? 0) }}</div>
                            <div class="text-muted">Healthy Stock (>10 units)</div>
                            <div class="small text-success">✓ Well stocked</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3">
                            <div class="display-4 text-warning">{{ number_format($summary['low_stock_count'] ?? 0) }}</div>
                            <div class="text-muted">Low Stock (1-10 units)</div>
                            <div class="small text-warning">⚠️ Reorder soon</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3">
                            <div class="display-4 text-danger">{{ number_format($summary['out_of_stock_count'] ?? 0) }}</div>
                            <div class="text-muted">Out of Stock (0 units)</div>
                            <div class="small text-danger">❌ Critical - Reorder now</div>
                        </div>
                    </div>
                </div>
                
                @if(($summary['low_stock_count'] ?? 0) > 0 || ($summary['out_of_stock_count'] ?? 0) > 0)
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Action Required:</strong> 
                    @if(($summary['low_stock_count'] ?? 0) > 0)
                        {{ number_format($summary['low_stock_count']) }} product(s) are running low on stock. 
                    @endif
                    @if(($summary['out_of_stock_count'] ?? 0) > 0)
                        {{ number_format($summary['out_of_stock_count']) }} product(s) are out of stock and need immediate reordering.
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="content-card mt-4">
        <div class="card-header">
            <h3><i class="bi bi-table me-2" style="color: var(--primary);"></i>Product Inventory List</h3>
            <div class="d-flex gap-2">
                <span class="badge-success px-3 py-2">Total: {{ $products->total() ?? 0 }} Products</span>
                <span class="badge-info px-3 py-2">Value: ₱{{ number_format($products->sum(function($p) { return ($p->price ?? 0) * ($p->stock ?? 0); }), 2) }}</span>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">ID</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Stock Value</th>
                        <th>Status</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products ?? [] as $product)
                    @php
                        $stockValue = ($product->price ?? 0) * ($product->stock ?? 0);
                        $stockClass = ($product->stock ?? 0) > 10 ? 'success' : (($product->stock ?? 0) > 0 ? 'warning' : 'danger');
                        $stockIcon = ($product->stock ?? 0) > 10 ? '✓' : (($product->stock ?? 0) > 0 ? '⚠️' : '❌');
                        $stockText = ($product->stock ?? 0) > 0 ? number_format($product->stock) : 'Out of Stock';
                    @endphp
                    <tr>
                        <td class="fw-600">#{{ $product->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="product-img-thumb me-2" style="width: 45px; height: 45px;">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <i class="bi bi-box text-muted" style="font-size: 1.5rem;"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-600">{{ Str::limit($product->name ?? 'N/A', 40) }}</div>
                                    <small class="text-muted">{{ $product->brand ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td><code>{{ $product->sku ?? 'N/A' }}</code></td>
                        <td>{{ $product->category ? $product->category->name : 'Uncategorized' }}</td>
                        <td class="fw-600">₱{{ number_format($product->price ?? 0, 2) }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-{{ $stockClass }} text-white px-3 py-2">
                                    {{ $stockIcon }} {{ $stockText }}
                                </span>
                                @if(($product->stock ?? 0) <= 10 && ($product->stock ?? 0) > 0)
                                    <div class="progress" style="width: 60px; height: 4px;">
                                        <div class="progress-bar bg-warning" style="width: {{ (($product->stock ?? 0) / 10) * 100 }}%"></div>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="fw-600">₱{{ number_format($stockValue, 2) }}</td>
                        <td>
                            @if($product->is_active ?? true)
                                <span class="badge bg-success text-white px-3 py-2">Active</span>
                            @else
                                <span class="badge bg-danger text-white px-3 py-2">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-warning" title="Update Stock" 
                                        data-bs-toggle="modal" data-bs-target="#stockModal{{ $product->id }}">
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
                                            <input type="number" class="form-control" value="{{ $product->stock ?? 0 }}" disabled>
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
                                        <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary-custom">Update Stock</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="mt-2 text-muted">No products found matching the filters.</p>
                            <a href="{{ route('admin.reports.inventory') }}" class="btn-primary-custom mt-2">
                                <i class="bi bi-x"></i> Clear Filters
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if(($products->count() ?? 0) > 0)
                <tfoot class="table-light">
                    <tr>
                        <th colspan="6" class="text-end fw-600">Total Value:</th>
                        <th class="fw-600">₱{{ number_format($products->sum(function($p) { return ($p->price ?? 0) * ($p->stock ?? 0); }), 2) }}</th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }} products
            </div>
            <div>
                {{ $products->withQueryString()->links() ?? '' }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Stock by Category Chart
        @if(isset($stockByCategory) && $stockByCategory->count())
        const stockCtx = document.getElementById('stockByCategoryChart').getContext('2d');
        new Chart(stockCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($stockByCategory->pluck('category.name')) !!},
                datasets: [{
                    label: 'Total Stock Quantity',
                    data: {!! json_encode($stockByCategory->pluck('total_stock')) !!},
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgb(40, 167, 69)',
                    borderWidth: 2,
                    borderRadius: 8,
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.raw;
                                let total = {!! json_encode($stockByCategory->sum('total_stock')) !!};
                                let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return [
                                    label + ': ' + value.toLocaleString() + ' units',
                                    `Percentage: ${percentage}% of total stock`
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Stock Quantity',
                            font: {
                                weight: 'bold',
                                size: 12
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Category',
                            font: {
                                weight: 'bold',
                                size: 12
                            }
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Value by Category Chart
        const valueCtx = document.getElementById('valueByCategoryChart').getContext('2d');
        new Chart(valueCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($stockByCategory->pluck('category.name')) !!},
                datasets: [{
                    label: 'Inventory Value (₱)',
                    data: {!! json_encode($stockByCategory->pluck('total_value')) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 2,
                    borderRadius: 8,
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.raw;
                                let total = {!! json_encode($stockByCategory->sum('total_value')) !!};
                                let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return [
                                    label + ': ₱' + value.toLocaleString(),
                                    `Percentage: ${percentage}% of total value`
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Value (₱)',
                            font: {
                                weight: 'bold',
                                size: 12
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Category',
                            font: {
                                weight: 'bold',
                                size: 12
                            }
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        @else
        // Show placeholder when no data
        document.getElementById('stockByCategoryChart')?.remove();
        document.getElementById('valueByCategoryChart')?.remove();
        @endif
    });
</script>
@endpush

@push('styles')
<style>
    .product-img-thumb {
        width: 45px;
        height: 45px;
        background: var(--slate-100);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transition: transform 0.2s;
    }
    
    .product-img-thumb:hover {
        transform: scale(1.1);
    }
    
    .product-img-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    
    .badge-success {
        background: var(--primary);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-info {
        background: var(--info);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .search-box .bi-search {
        left: 1rem;
        pointer-events: none;
    }
    
    .search-box input {
        padding-left: 2.8rem !important;
    }
    
    .progress {
        background-color: var(--slate-200);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .progress-bar {
        transition: width 0.6s ease;
    }
    
    .display-4 {
        font-size: 2.5rem;
        font-weight: 700;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--slate-200);
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary);
        box-shadow: 0 15px 30px rgba(40, 167, 69, 0.1);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        background: rgba(40, 167, 69, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.8rem;
        color: var(--primary);
    }
    
    .stat-label {
        color: var(--slate-500);
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }
    
    .stat-value {
        font-family: 'Outfit', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--slate-800);
    }
    
    .stat-change {
        font-size: 0.8rem;
        color: var(--slate-500);
        margin-top: 0.5rem;
    }
    
    .stat-change.positive {
        color: var(--success);
    }
    
    .content-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--slate-200);
        margin-bottom: 1.5rem;
    }
    
    .content-card.h-100 {
        margin-bottom: 0;
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--slate-200);
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .card-header h3 {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        margin: 0;
        font-size: 1.2rem;
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
    
    .table th {
        font-weight: 600;
        color: var(--slate-700);
        border-bottom-width: 2px;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    
    .fw-600 {
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
        
        .content-card {
            padding: 1rem;
        }
        
        .display-4 {
            font-size: 1.8rem;
        }
        
        .btn-primary-custom,
        .btn-outline-custom {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        
        .table-responsive {
            font-size: 0.85rem;
        }
        
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush