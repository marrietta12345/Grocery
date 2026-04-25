@extends('admin.layouts.admin')

@section('title', 'Order #' . $order->order_number)
@section('page-title', 'Order Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: var(--dark);">Order #{{ $order->order_number }}</h1>
            <p class="text-muted">Placed on {{ $order->created_at->setTimezone('Asia/Manila')->format('F d, Y h:i A') }} (PHT)</p>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-custom me-2">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary-custom">
                <i class="bi bi-pencil"></i> Edit Order
            </a>
        </div>
    </div>
    
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <!-- Order Status Header -->
    <div class="content-card mb-4">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="mb-2 text-muted small">ORDER STATUS</div>
                @php
                    $statusClass = match($order->status) {
                        'pending' => 'badge-warning',
                        'processing' => 'badge-info',
                        'ready_for_delivery' => 'badge-info',
                        'shipped' => 'badge-primary',
                        'completed' => 'badge-success',
                        'cancelled' => 'badge-danger',
                        default => 'badge-warning'
                    };
                    $statusIcon = match($order->status) {
                        'pending' => 'clock',
                        'processing' => 'arrow-repeat',
                        'ready_for_delivery' => 'box-seam',
                        'shipped' => 'truck',
                        'completed' => 'check-circle',
                        'cancelled' => 'x-circle',
                        default => 'clock'
                    };
                @endphp
                <span class="{{ $statusClass }}" style="padding: 0.5rem 1rem; border-radius: 40px; font-weight: 600; display: inline-block;">
                    <i class="bi bi-{{ $statusIcon }} me-2"></i>
                    {{ ucfirst($order->status_text) }}
                </span>
            </div>
            <div class="col-md-3">
                <div class="mb-2 text-muted small">SHIPPING STATUS</div>
                @php
                    $shippingClass = match($order->shipping_status) {
                        'pending' => 'badge-secondary',
                        'processing' => 'badge-info',
                        'shipped' => 'badge-primary',
                        'out_for_delivery' => 'badge-warning',
                        'delivered' => 'badge-success',
                        'failed' => 'badge-danger',
                        default => 'badge-secondary'
                    };
                @endphp
                <span class="{{ $shippingClass }}" style="padding: 0.5rem 1rem; border-radius: 40px; font-weight: 600; display: inline-block;">
                    <i class="bi bi-truck me-2"></i>
                    {{ $order->shipping_status_text }}
                </span>
            </div>
            <div class="col-md-3">
                <div class="mb-2 text-muted small">PAYMENT STATUS</div>
                @php
                    $paymentClass = match($order->payment_status) {
                        'paid' => 'badge-success',
                        'unpaid' => 'badge-warning',
                        'refunded' => 'badge-info',
                        'failed' => 'badge-danger',
                        default => 'badge-warning'
                    };
                @endphp
                <span class="{{ $paymentClass }}" style="padding: 0.5rem 1rem; border-radius: 40px; font-weight: 600; display: inline-block;">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>
            <div class="col-md-3">
                <div class="mb-2 text-muted small">TOTAL AMOUNT</div>
                <div class="fw-bold text-primary h4">₱{{ number_format($order->total, 2) }}</div>
            </div>
        </div>
    </div>
    
    <!-- Details Grid -->
    <div class="row">
        <!-- Left Column - Order Items & Customer Info -->
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="content-card">
                <div class="card-header">
                    <h3>
                        <i class="bi bi-box me-2" style="color: var(--primary);"></i>
                        Order Items
                    </h3>
                    <span class="badge-success">{{ $order->items->count() }} item(s)</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            32
                                <th>Product</th>
                                <th>SKU</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-img-thumb me-2">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}">
                                            @else
                                                <i class="bi bi-box"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <strong>{{ $item->product_name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->product_sku ?? 'N/A' }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">₱{{ number_format($item->price, 2) }}</td>
                                <td class="text-end">₱{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Customer Information -->
            <div class="content-card">
                <div class="card-header">
                    <h3>
                        <i class="bi bi-person me-2" style="color: var(--primary);"></i>
                        Customer Information
                    </h3>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="120"><strong>Name:</strong></td>
                                <td>{{ $order->user ? $order->user->first_name . ' ' . $order->user->last_name : 'Guest' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td><a href="mailto:{{ $order->contact_email }}">{{ $order->contact_email }}</a></td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td><a href="tel:{{ $order->contact_phone }}">{{ $order->contact_phone }}</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="120"><strong>Shipping Address:</strong></td>
                                <td>{{ $order->shipping_address }}</td>
                            </tr>
                            @if($order->billing_address && $order->billing_address != $order->shipping_address)
                            <tr>
                                <td><strong>Billing Address:</strong></td>
                                <td>{{ $order->billing_address }}</td>
                            </tr>
                            @endif
                            @if($order->delivery_instructions)
                            <tr>
                                <td><strong>Delivery Instructions:</strong></td>
                                <td>{{ $order->delivery_instructions }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                
                @if($order->notes)
                <div class="mt-3 p-3" style="background: var(--slate-50); border-radius: 8px;">
                    <strong>Order Notes:</strong>
                    <p class="mb-0 mt-1">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Right Column - Summary, Shipping Info, Timeline -->
        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="content-card">
                <div class="card-header">
                    <h3>
                        <i class="bi bi-receipt me-2" style="color: var(--primary);"></i>
                        Order Summary
                    </h3>
                </div>
                
                <div class="price-row">
                    <span>Subtotal:</span>
                    <span class="fw-bold">₱{{ number_format($order->subtotal, 2) }}</span>
                </div>
                
                @if($order->discount > 0)
                <div class="price-row">
                    <span>Discount:</span>
                    <span class="fw-bold text-success">-₱{{ number_format($order->discount, 2) }}</span>
                </div>
                @endif
                
                <div class="price-row">
                    <span>Shipping Fee:</span>
                    <span class="fw-bold">₱{{ number_format($order->shipping_fee, 2) }}</span>
                </div>
                
                @if($order->promo_code)
                <div class="price-row">
                    <span>Promo Code:</span>
                    <span class="badge-success">{{ $order->promo_code }}</span>
                </div>
                @endif
                
                <div class="price-row total">
                    <span>Total Amount:</span>
                    <span class="fw-bold text-primary">₱{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
            
            <!-- Shipping Information -->
            <div class="content-card">
                <div class="card-header">
                    <h3>
                        <i class="bi bi-truck me-2" style="color: var(--primary);"></i>
                        Shipping Information
                    </h3>
                </div>
                
                <div class="shipping-details">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td width="120"><strong>Shipping Status:</strong></td>
                            <td>
                                <span class="{{ $shippingClass }}" style="padding: 0.2rem 0.8rem; border-radius: 40px; font-size: 0.8rem; font-weight: 600; display: inline-block;">
                                    {{ $order->shipping_status_text }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Courier:</strong></td>
                            <td>{{ $order->courier_name ?? 'Not assigned' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tracking Number:</strong></td>
                            <td>
                                @if($order->tracking_number)
                                    <span class="fw-bold">{{ $order->tracking_number }}</span>
                                @else
                                    <span class="text-muted">Not available</span>
                                @endif
                            </td>
                        </tr>
                        @if($order->shipped_at)
                        <tr>
                            <td><strong>Shipped Date:</strong></td>
                            <td>{{ $order->shipped_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</td>
                        </tr>
                        @endif
                        @if($order->out_for_delivery_at)
                        <tr>
                            <td><strong>Out for Delivery:</strong></td>
                            <td>{{ $order->out_for_delivery_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</td>
                        </tr>
                        @endif
                        @if($order->delivered_at)
                        <tr>
                            <td><strong>Delivered Date:</strong></td>
                            <td>{{ $order->delivered_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</td>
                        </tr>
                        @endif
                    </table>
                    
                    @if($order->delivery_instructions)
                    <div class="mt-3 p-2" style="background: var(--slate-50); border-radius: 8px;">
                        <i class="bi bi-info-circle me-1"></i>
                        <strong>Delivery Instructions:</strong>
                        <p class="mb-0 mt-1 small">{{ $order->delivery_instructions }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Order Timeline -->
            <div class="content-card">
                <div class="card-header">
                    <h3>
                        <i class="bi bi-clock-history me-2" style="color: var(--primary);"></i>
                        Order Timeline
                    </h3>
                </div>
                
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="fw-bold">Order Placed</div>
                        <div class="text-muted small">{{ $order->created_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</div>
                    </div>
                    
                    @if($order->paid_at)
                    <div class="timeline-item">
                        <div class="fw-bold">Payment Completed</div>
                        <div class="text-muted small">{{ $order->paid_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</div>
                    </div>
                    @endif
                    
                    @if($order->shipped_at)
                    <div class="timeline-item">
                        <div class="fw-bold">Order Shipped</div>
                        <div class="text-muted small">{{ $order->shipped_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</div>
                        @if($order->courier_name)
                        <div class="text-muted small">Via: {{ $order->courier_name }}</div>
                        @endif
                        @if($order->tracking_number)
                        <div class="text-muted small">Tracking: {{ $order->tracking_number }}</div>
                        @endif
                    </div>
                    @endif
                    
                    @if($order->out_for_delivery_at)
                    <div class="timeline-item">
                        <div class="fw-bold">Out for Delivery</div>
                        <div class="text-muted small">{{ $order->out_for_delivery_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</div>
                    </div>
                    @endif
                    
                    @if($order->delivered_at)
                    <div class="timeline-item">
                        <div class="fw-bold">Order Delivered</div>
                        <div class="text-muted small">{{ $order->delivered_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</div>
                    </div>
                    @endif
                    
                    @if($order->status == 'cancelled')
                    <div class="timeline-item">
                        <div class="fw-bold text-danger">Order Cancelled</div>
                        <div class="text-muted small">{{ $order->cancelled_at ? $order->cancelled_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') : $order->updated_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</div>
                        @if($order->cancellation_reason)
                        <div class="text-muted small mt-1">Reason: {{ $order->cancellation_reason }}</div>
                        @endif
                        @if($order->cancelledBy)
                        <div class="text-muted small">Cancelled by: {{ $order->cancelledBy->first_name }} {{ $order->cancelledBy->last_name }}</div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            <div class="d-grid gap-2">
                <a href="{{ route('payment.receipt', $order) }}" class="btn btn-primary-custom" target="_blank">
                    <i class="bi bi-receipt"></i> View Receipt
                </a>
                <a href="#" class="btn btn-outline-custom" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print Order
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
        border-left: 2px solid var(--slate-200);
        padding-left: 1.5rem;
    }
    
    .timeline-item:last-child {
        border-left: 2px solid transparent;
        padding-bottom: 0;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -9px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--primary);
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .timeline-item.text-danger::before {
        background: var(--danger);
    }
    
    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.8rem;
        color: var(--slate-600);
    }
    
    .price-row.total {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark);
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--slate-200);
    }
    
    .badge-primary {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }
    
    .badge-secondary {
        background: rgba(100, 116, 139, 0.1);
        color: #64748b;
    }
    
    .badge-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    
    .badge-info {
        background: rgba(14, 165, 233, 0.1);
        color: #0ea5e9;
    }
    
    .badge-success {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }
    
    .badge-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    .shipping-details table tr td {
        padding: 0.4rem 0;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endpush