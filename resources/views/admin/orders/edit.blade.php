@extends('admin.layouts.admin')

@section('title', 'Edit Order #' . $order->order_number)
@section('page-title', 'Edit Order')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: var(--dark);">Edit Order #{{ $order->order_number }}</h2>
            <p class="text-muted">Placed on {{ $order->created_at->setTimezone('Asia/Manila')->format('F d, Y h:i A') }} (PHT)</p>
        </div>
        <div>
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-custom me-2">
                <i class="bi bi-eye"></i> View Order
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-custom">
                <i class="bi bi-arrow-left"></i> Back to List
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
    
    @if($errors->any())
        <div class="alert alert-danger alert-custom">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
    
    <!-- Edit Form -->
    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Order Status Card -->
        <div class="content-card">
            <div class="card-header">
                <h3>
                    <i class="bi bi-gear me-2" style="color: var(--primary);"></i>
                    Order Status
                </h3>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Order Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted small">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Note:</strong> Changing status to "Shipped" will automatically update shipping status and mark shipped date.
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Payment Status</label>
                    <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror">
                        @foreach($paymentStatuses as $status)
                            <option value="{{ $status }}" {{ $order->payment_status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                        @foreach($paymentMethods ?? ['cod', 'gcash', 'paymaya', 'credit_card', 'debit_card'] as $method)
                            <option value="{{ $method }}" {{ $order->payment_method == $method ? 'selected' : '' }}>
                                @switch($method)
                                    @case('cod')
                                        Cash on Delivery
                                        @break
                                    @case('gcash')
                                        GCash
                                        @break
                                    @case('paymaya')
                                        PayMaya
                                        @break
                                    @case('credit_card')
                                        Credit Card
                                        @break
                                    @case('debit_card')
                                        Debit Card
                                        @break
                                    @default
                                        {{ ucfirst($method) }}
                                @endswitch
                            </option>
                        @endforeach
                    </select>
                    @error('payment_method')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Shipping Information Card -->
        <div class="content-card">
            <div class="card-header">
                <h3>
                    <i class="bi bi-truck me-2" style="color: var(--primary);"></i>
                    Shipping Information
                </h3>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Shipping Status</label>
                    <select name="shipping_status" class="form-select @error('shipping_status') is-invalid @enderror">
                        <option value="pending" {{ $order->shipping_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->shipping_status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->shipping_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="sorting_facility" {{ $order->shipping_status == 'sorting_facility' ? 'selected' : '' }}>Sorting Facility</option>
                        <option value="out_for_delivery" {{ $order->shipping_status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                        <option value="delivered" {{ $order->shipping_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="failed" {{ $order->shipping_status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    @error('shipping_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted small">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Timeline:</strong> Pending → Processing → Shipped → Sorting Facility → Out for Delivery → Delivered
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Courier / Carrier</label>
                    <select name="courier_name" class="form-select @error('courier_name') is-invalid @enderror">
                        <option value="">Select Courier</option>
                        <option value="LBC" {{ $order->courier_name == 'LBC' ? 'selected' : '' }}>LBC</option>
                        <option value="2GO" {{ $order->courier_name == '2GO' ? 'selected' : '' }}>2GO</option>
                        <option value="J&T Express" {{ $order->courier_name == 'J&T Express' ? 'selected' : '' }}>J&T Express</option>
                        <option value="Ninja Van" {{ $order->courier_name == 'Ninja Van' ? 'selected' : '' }}>Ninja Van</option>
                        <option value="Grab Express" {{ $order->courier_name == 'Grab Express' ? 'selected' : '' }}>Grab Express</option>
                        <option value="Other" {{ $order->courier_name == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('courier_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tracking Number</label>
                    <input type="text" name="tracking_number" class="form-control @error('tracking_number') is-invalid @enderror" 
                           value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="e.g., LBC123456789">
                    @error('tracking_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Enter the tracking number provided by the courier.</div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Shipped Date</label>
                    <input type="datetime-local" name="shipped_at" class="form-control @error('shipped_at') is-invalid @enderror" 
                           value="{{ old('shipped_at', $order->shipped_at ? $order->shipped_at->format('Y-m-d\TH:i') : '') }}">
                    @error('shipped_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Arrived at Sorting Facility Date</label>
                    <input type="datetime-local" name="arrived_at_sorting_at" class="form-control @error('arrived_at_sorting_at') is-invalid @enderror" 
                           value="{{ old('arrived_at_sorting_at', $order->arrived_at_sorting_at ? $order->arrived_at_sorting_at->format('Y-m-d\TH:i') : '') }}">
                    @error('arrived_at_sorting_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Date when the package arrived at the sorting facility.</div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Out for Delivery Date</label>
                    <input type="datetime-local" name="out_for_delivery_at" class="form-control @error('out_for_delivery_at') is-invalid @enderror" 
                           value="{{ old('out_for_delivery_at', $order->out_for_delivery_at ? $order->out_for_delivery_at->format('Y-m-d\TH:i') : '') }}">
                    @error('out_for_delivery_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Delivery Instructions</label>
                    <textarea name="delivery_instructions" class="form-control @error('delivery_instructions') is-invalid @enderror" rows="2" 
                              placeholder="Special instructions for the delivery rider...">{{ old('delivery_instructions', $order->delivery_instructions) }}</textarea>
                    @error('delivery_instructions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Customer Information Card -->
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
                            <td>{{ $order->contact_email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $order->contact_phone }}</td>
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
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Order Items Card -->
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
                        <tr>
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
                                    <div class="product-img-thumb me-2" style="width: 40px; height: 40px; background: var(--slate-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-box" style="font-size: 1.2rem;"></i>
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
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">Subtotal:</th>
                            <th class="text-end">₱{{ number_format($order->subtotal, 2) }}</th>
                        </tr>
                        @if($order->discount > 0)
                        <tr>
                            <th colspan="4" class="text-end">Discount:</th>
                            <th class="text-end text-success">-₱{{ number_format($order->discount, 2) }}</th>
                        </tr>
                        @endif
                        <tr>
                            <th colspan="4" class="text-end">Shipping Fee:</th>
                            <th class="text-end">₱{{ number_format($order->shipping_fee, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Total Amount:</th>
                            <th class="text-end text-primary h5">₱{{ number_format($order->total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <!-- Admin Notes Card -->
        <div class="content-card">
            <div class="card-header">
                <h3>
                    <i class="bi bi-pencil me-2" style="color: var(--primary);"></i>
                    Admin Notes
                </h3>
            </div>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" 
                              placeholder="Add internal notes about this order...">{{ old('notes', $order->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">These notes are for internal use only and won't be visible to the customer.</div>
                </div>
            </div>
        </div>
        
        <!-- Submit Buttons -->
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-custom">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary-custom">
                <i class="bi bi-check-circle"></i> Update Order
            </button>
        </div>
    </form>
</div>

<style>
    /* Additional styles for better appearance */
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
    
    .btn-primary-custom {
        background: var(--dark);
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-primary-custom:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-outline-custom {
        background: white;
        border: 1.5px solid var(--slate-200);
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
    
    .form-label {
        font-weight: 600;
        color: var(--slate-700);
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border: 1px solid var(--slate-200);
        border-radius: 12px;
        padding: 0.6rem 1rem;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        outline: none;
    }
    
    .table-borderless td {
        padding: 0.5rem 0;
    }
    
    .alert-custom {
        border-radius: 12px;
        border: none;
        padding: 1rem;
    }
    
    .product-img-thumb {
        width: 40px;
        height: 40px;
        background: var(--slate-100);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .product-img-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    @media (max-width: 768px) {
        .content-card {
            padding: 1rem;
        }
        
        .table-responsive {
            font-size: 0.85rem;
        }
        
        .btn-primary-custom, .btn-outline-custom {
            padding: 0.5rem 1rem;
        }
    }
</style>

<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
    
    // Auto-update shipping status when order status changes
    const orderStatusSelect = document.querySelector('select[name="status"]');
    const shippingStatusSelect = document.querySelector('select[name="shipping_status"]');
    
    if (orderStatusSelect && shippingStatusSelect) {
        orderStatusSelect.addEventListener('change', function() {
            const status = this.value;
            
            if (status === 'shipped') {
                // If order status is set to shipped, automatically set shipping status to shipped
                shippingStatusSelect.value = 'shipped';
                
                // Auto-set shipped date if not set
                const shippedAtInput = document.querySelector('input[name="shipped_at"]');
                if (shippedAtInput && !shippedAtInput.value) {
                    const now = new Date();
                    const formattedDate = now.getFullYear() + '-' + 
                        String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                        String(now.getDate()).padStart(2, '0') + 'T' + 
                        String(now.getHours()).padStart(2, '0') + ':' + 
                        String(now.getMinutes()).padStart(2, '0');
                    shippedAtInput.value = formattedDate;
                }
            } else if (status === 'completed') {
                // If order is completed, set shipping status to delivered
                shippingStatusSelect.value = 'delivered';
            }
        });
    }
    
    // Auto-update tracking link preview
    document.querySelector('select[name="courier_name"]')?.addEventListener('change', function() {
        const courier = this.value;
        const trackingNumber = document.querySelector('input[name="tracking_number"]').value;
        
        if (courier && trackingNumber) {
            let trackingUrl = '';
            switch(courier) {
                case 'LBC':
                    trackingUrl = `https://www.lbcexpress.com/track/${trackingNumber}`;
                    break;
                case '2GO':
                    trackingUrl = `https://2go.com.ph/track/${trackingNumber}`;
                    break;
                case 'J&T Express':
                    trackingUrl = `https://www.jtexpress.ph/track/${trackingNumber}`;
                    break;
                default:
                    trackingUrl = '';
            }
            
            if (trackingUrl) {
                // Show a preview link
                console.log('Tracking URL:', trackingUrl);
                // You can display a link here if needed
            }
        }
    });
</script>
@endsection

@push('scripts')
<script>
    // Additional script to ensure shipping status sync
    document.addEventListener('DOMContentLoaded', function() {
        const orderStatus = document.querySelector('select[name="status"]');
        const shippingStatus = document.querySelector('select[name="shipping_status"]');
        
        if (orderStatus && orderStatus.value === 'shipped' && shippingStatus && shippingStatus.value !== 'shipped') {
            shippingStatus.value = 'shipped';
        }
        
        // Auto-fill sorting facility date when sorting facility status is selected
        if (shippingStatus) {
            shippingStatus.addEventListener('change', function() {
                const sortingFacilityInput = document.querySelector('input[name="arrived_at_sorting_at"]');
                
                if (this.value === 'sorting_facility' && sortingFacilityInput && !sortingFacilityInput.value) {
                    const now = new Date();
                    const formattedDate = now.getFullYear() + '-' + 
                        String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                        String(now.getDate()).padStart(2, '0') + 'T' + 
                        String(now.getHours()).padStart(2, '0') + ':' + 
                        String(now.getMinutes()).padStart(2, '0');
                    sortingFacilityInput.value = formattedDate;
                }
            });
        }
    });
</script>
@endpush