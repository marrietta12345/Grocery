@extends('admin.layouts.admin')

@section('title', 'Manage Orders')
@section('page-title', 'Manage Orders')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-bag"></i>
            </div>
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ $stats['total_orders'] ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-label">Pending Orders</div>
            <div class="stat-value">{{ $stats['pending_orders'] ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-label">Completed</div>
            <div class="stat-value">{{ $stats['completed_orders'] ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-cash"></i>
            </div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₱{{ number_format($stats['total_revenue'] ?? 0, 2) }}</div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="content-card">
        <div class="card-header">
            <h3>Filter Orders</h3>
        </div>
        
        <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Order #, Email, Phone..." value="{{ request('search') }}">
            </div>
            
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label">Payment Status</label>
                <select name="payment_status" class="form-select">
                    <option value="">All</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label">Date From</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            
            <div class="col-md-2">
                <label class="form-label">Date To</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary-custom w-100">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            
            <div class="col-12 text-end">
                <a href="{{ route('admin.orders.export') }}?{{ http_build_query(request()->query()) }}" class="btn btn-outline-custom">
                    <i class="bi bi-download"></i> Export
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-custom">
                    <i class="bi bi-x"></i> Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="content-card">
        <div class="card-header">
            <h3>Orders List</h3>
            <span class="badge-success">Total: {{ $orders->total() }}</span>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="40">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <input type="checkbox" class="order-checkbox" value="{{ $order->id }}">
                        </td>
                        <td>
                            <strong>{{ $order->order_number }}</strong>
                        </td>
                        <td>
                            {{ $order->created_at->setTimezone('Asia/Manila')->format('M d, Y') }}<br>
                            <small class="text-muted">{{ $order->created_at->setTimezone('Asia/Manila')->format('h:i A') }}</small>
                        </td>
                        <td>
                            {{ $order->user ? $order->user->first_name . ' ' . $order->user->last_name : 'Guest' }}<br>
                            <small class="text-muted">{{ $order->contact_email }}</small>
                        </td>
                        <td>
                            <strong>₱{{ number_format($order->total, 2) }}</strong>
                        </td>
                        <td>
                            @php
                                $statusClass = match($order->status) {
                                    'pending' => 'badge-warning',
                                    'processing' => 'badge-info',
                                    'completed' => 'badge-success',
                                    'cancelled' => 'badge-danger',
                                    default => 'badge-warning'
                                };
                            @endphp
                            <span class="{{ $statusClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $paymentClass = match($order->payment_status) {
                                    'paid' => 'badge-success',
                                    'unpaid' => 'badge-warning',
                                    'refunded' => 'badge-info',
                                    default => 'badge-warning'
                                };
                            @endphp
                            <span class="{{ $paymentClass }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                            <br>
                            <small class="text-muted">{{ strtoupper($order->payment_method) }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-custom" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-outline-custom" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('payment.receipt', $order) }}" class="btn btn-sm btn-outline-custom" title="Receipt" target="_blank">
                                    <i class="bi bi-receipt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 2rem; color: var(--slate-300);"></i>
                            <p class="mt-2 text-muted">No orders found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Custom Pagination -->
        @if($orders->hasPages())
        <div class="pagination-wrapper">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="pagination-info">
                        Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
                    </div>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            {{-- Previous Page Link --}}
                            @if ($orders->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo; Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                @if ($page == $orders->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($orders->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">Next &raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next &raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        @else
        <div class="pagination-info text-center mt-3">
            Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
        </div>
        @endif
    </div>
</div>

<!-- Bulk Actions -->
<div class="bulk-actions" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
    <div class="content-card" style="width: 320px; padding: 1rem;">
        <h6 class="mb-3">Bulk Actions</h6>
        <select class="form-select mb-2" id="bulkAction">
            <option value="">Select Action</option>
            <option value="update_status">Update Status</option>
            <option value="update_payment_status">Update Payment Status</option>
        </select>
        
        <select class="form-select mb-2" id="bulkStatus" style="display: none;">
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
        
        <select class="form-select mb-2" id="bulkPaymentStatus" style="display: none;">
            <option value="paid">Paid</option>
            <option value="unpaid">Unpaid</option>
            <option value="refunded">Refunded</option>
        </select>
        
        <div class="d-flex gap-2">
            <button class="btn btn-primary-custom flex-grow-1" id="applyBulkAction">Apply</button>
            <button class="btn btn-outline-custom" id="closeBulkActions">Cancel</button>
        </div>
    </div>
</div>

<style>
    /* Admin Orders Styles */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
        border: 1px solid var(--slate-200);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(40, 167, 69, 0.1);
        border-color: var(--primary);
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
    }
    
    .stat-icon i {
        font-size: 1.8rem;
        color: var(--primary);
    }
    
    .stat-label {
        color: var(--slate-500);
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.3rem;
    }
    
    .stat-value {
        font-family: 'Outfit', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--slate-800);
        margin-bottom: 0.2rem;
    }
    
    .content-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--slate-200);
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--slate-200);
    }
    
    .card-header h3 {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--slate-800);
        margin: 0;
    }
    
    .badge-success {
        background: var(--primary);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .badge-warning {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning);
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .badge-info {
        background: rgba(59, 130, 246, 0.1);
        color: var(--info);
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .badge-danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .btn-primary-custom {
        background: var(--dark);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-primary-custom:hover {
        background: var(--primary);
        color: white;
    }
    
    .btn-outline-custom {
        background: white;
        border: 1.5px solid var(--slate-200);
        color: var(--slate-600);
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-outline-custom:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        font-weight: 600;
        color: var(--slate-600);
        border-bottom: 1px solid var(--slate-200);
        padding: 1rem;
    }
    
    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--slate-200);
    }
    
    .table tbody tr:hover {
        background-color: var(--slate-50);
    }
    
    .pagination-wrapper {
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--slate-200);
    }
    
    .pagination-info {
        color: var(--slate-500);
        font-size: 0.9rem;
    }
    
    .pagination {
        margin-bottom: 0;
        justify-content: flex-end;
    }
    
    .page-link {
        color: var(--primary);
        border: 1px solid var(--slate-200);
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    
    .page-link:hover {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }
    
    .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }
    
    .page-item.disabled .page-link {
        color: var(--slate-400);
        background-color: white;
        border-color: var(--slate-200);
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .pagination-info,
        .pagination {
            text-align: center;
            justify-content: center;
            margin-top: 0.5rem;
        }
        
        .bulk-actions .content-card {
            width: calc(100vw - 40px) !important;
        }
        
        .table-responsive {
            font-size: 0.85rem;
        }
        
        .btn-group-sm .btn {
            padding: 0.2rem 0.4rem;
        }
    }
</style>
@endsection

@push('scripts')
<script>
    // Select All Checkboxes
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.getElementsByClassName('order-checkbox');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
            toggleBulkActions();
        });
    }
    
    // Toggle Bulk Actions
    function toggleBulkActions() {
        const checkboxes = document.getElementsByClassName('order-checkbox');
        let anyChecked = false;
        for (let checkbox of checkboxes) {
            if (checkbox.checked) {
                anyChecked = true;
                break;
            }
        }
        
        const bulkActionsDiv = document.querySelector('.bulk-actions');
        if (bulkActionsDiv) {
            bulkActionsDiv.style.display = anyChecked ? 'block' : 'none';
        }
    }
    
    // Add event listeners to all checkboxes
    document.querySelectorAll('.order-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkActions);
    });
    
    // Bulk Action Select
    const bulkActionSelect = document.getElementById('bulkAction');
    if (bulkActionSelect) {
        bulkActionSelect.addEventListener('change', function() {
            const bulkStatus = document.getElementById('bulkStatus');
            const bulkPaymentStatus = document.getElementById('bulkPaymentStatus');
            
            if (bulkStatus) bulkStatus.style.display = 'none';
            if (bulkPaymentStatus) bulkPaymentStatus.style.display = 'none';
            
            if (this.value === 'update_status' && bulkStatus) {
                bulkStatus.style.display = 'block';
            } else if (this.value === 'update_payment_status' && bulkPaymentStatus) {
                bulkPaymentStatus.style.display = 'block';
            }
        });
    }
    
    // Apply Bulk Action
    const applyBulkActionBtn = document.getElementById('applyBulkAction');
    if (applyBulkActionBtn) {
        applyBulkActionBtn.addEventListener('click', function() {
            const action = document.getElementById('bulkAction').value;
            if (!action) {
                alert('Please select an action');
                return;
            }
            
            const selectedOrders = [];
            document.querySelectorAll('.order-checkbox:checked').forEach(checkbox => {
                selectedOrders.push(checkbox.value);
            });
            
            if (selectedOrders.length === 0) {
                alert('Please select orders');
                return;
            }
            
            let formData = new FormData();
            formData.append('action', action);
            formData.append('order_ids', JSON.stringify(selectedOrders));
            
            if (action === 'update_status') {
                const status = document.getElementById('bulkStatus').value;
                if (!status) {
                    alert('Please select a status');
                    return;
                }
                formData.append('status', status);
            } else if (action === 'update_payment_status') {
                const paymentStatus = document.getElementById('bulkPaymentStatus').value;
                if (!paymentStatus) {
                    alert('Please select a payment status');
                    return;
                }
                formData.append('payment_status', paymentStatus);
            }
            
            if (confirm(`Are you sure you want to perform this action on ${selectedOrders.length} order(s)?`)) {
                fetch('{{ route("admin.orders.bulk-update") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Something went wrong'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + (error.message || 'Something went wrong'));
                });
            }
        });
    }
    
    // Close Bulk Actions
    const closeBulkActionsBtn = document.getElementById('closeBulkActions');
    if (closeBulkActionsBtn) {
        closeBulkActionsBtn.addEventListener('click', function() {
            document.querySelectorAll('.order-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            const selectAll = document.getElementById('selectAll');
            if (selectAll) selectAll.checked = false;
            toggleBulkActions();
        });
    }
</script>
@endpush