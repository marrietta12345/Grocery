<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Details | Grocery Mart</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #28a745;
            --primary-dark: #1e7e34;
            --primary-light: #e8f5e9;
            --dark: #155724;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --info: #3b82f6;
            --info-light: #dbeafe;
            --success: #28a745;
            --success-light: #d4edda;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--slate-50) 0%, #ffffff 100%);
            min-height: 100vh;
        }
        
        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Main Container */
        .main-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            border: 1px solid var(--slate-200);
            padding: 0.5rem 1.25rem;
            border-radius: 40px;
            color: var(--slate-600);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            margin-bottom: 1.5rem;
        }
        
        .back-button:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateX(-4px);
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 24px;
            background: white;
            border: 1px solid var(--slate-200);
            margin-bottom: 1.5rem;
            transition: all 0.2s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .card-header-custom {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--slate-200);
            background: white;
            border-radius: 24px 24px 0 0;
        }
        
        .card-body-custom {
            padding: 1.5rem;
        }
        
        /* Status Badge */
        .status-badge {
            padding: 0.35rem 1rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .status-picked_up {
            background: var(--info-light);
            color: var(--info);
        }
        
        .status-in_transit {
            background: var(--warning-light);
            color: var(--warning);
        }
        
        .status-delivered {
            background: var(--success-light);
            color: var(--success);
        }
        
        /* Buttons */
        .btn-update {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            width: 100%;
        }
        
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }
        
        /* Info Rows */
        .info-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 0.75rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--slate-100);
        }
        
        .info-label {
            width: 120px;
            color: var(--slate-500);
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .info-value {
            flex: 1;
            color: var(--slate-800);
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        /* Product Items */
        .product-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .product-item:last-child {
            border-bottom: none;
        }
        
        .product-image {
            width: 60px;
            height: 60px;
            background: var(--slate-100);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-image i {
            font-size: 1.8rem;
            color: var(--slate-400);
        }
        
        .product-details {
            flex: 1;
        }
        
        .product-name {
            font-weight: 600;
            color: var(--slate-800);
            margin-bottom: 0.25rem;
        }
        
        .product-sku {
            font-size: 0.7rem;
            color: var(--slate-400);
        }
        
        .product-price {
            text-align: right;
        }
        
        .product-price .price {
            font-weight: 700;
            color: var(--primary);
            font-size: 1rem;
        }
        
        .product-price .quantity {
            font-size: 0.75rem;
            color: var(--slate-500);
        }
        
        /* Totals Table */
        .totals-table {
            width: 100%;
            max-width: 350px;
            margin-left: auto;
        }
        
        .totals-table tr td {
            padding: 0.5rem 0;
        }
        
        .totals-table tr td:last-child {
            text-align: right;
            font-weight: 600;
        }
        
        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 1.25rem;
            border-left: 2px solid var(--slate-200);
            padding-left: 1.25rem;
        }
        
        .timeline-item:last-child {
            border-left-color: transparent;
        }
        
        .timeline-icon {
            position: absolute;
            left: -0.7rem;
            top: 0;
            width: 1.2rem;
            height: 1.2rem;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--primary);
        }
        
        .timeline-icon i {
            font-size: 0.6rem;
            color: var(--primary);
        }
        
        /* Toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
        }
        
        .toast-custom {
            background: white;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-left: 3px solid var(--primary);
            min-width: 280px;
        }
        
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            .product-item {
                flex-wrap: wrap;
            }
            .product-price {
                text-align: left;
                width: 100%;
                margin-left: 70px;
            }
            .info-row {
                flex-direction: column;
                gap: 0.25rem;
            }
            .info-label {
                width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="toast-container" id="toastContainer"></div>
    
    <nav class="navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('delivery.dashboard') }}">
                <i class="bi bi-truck-fill me-2" style="color: var(--primary);"></i>
                Grocery Mart Delivery
            </a>
            <div class="dropdown">
                <div class="dropdown-toggle" data-bs-toggle="dropdown" style="cursor: pointer;">
                    <i class="bi bi-person-circle me-1"></i> 
                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Sign Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="main-container">
        <!-- Back Button -->
        <a href="{{ route('delivery.dashboard') }}" class="back-button">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        
        <div class="mb-4">
            <h1 class="h2 fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">Delivery Details</h1>
            <p class="text-muted small mb-0">Update delivery status and track progress</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Order Info Card -->
                <div class="card">
                    <div class="card-header-custom">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-receipt me-2" style="color: var(--primary);"></i>
                                Order #{{ $delivery->order->order_number }}
                            </h5>
                            <span class="status-badge status-{{ $delivery->status }}">
                                <i class="bi bi-{{ $delivery->status == 'picked_up' ? 'box-seam' : ($delivery->status == 'in_transit' ? 'truck' : 'clock') }}"></i>
                                {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-semibold mb-3">
                                    <i class="bi bi-person-circle me-2"></i> Customer Information
                                </h6>
                                <div class="info-row">
                                    <div class="info-label">Full Name:</div>
                                    <div class="info-value">{{ $delivery->order->user->first_name ?? 'Guest' }} {{ $delivery->order->user->last_name ?? '' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Email Address:</div>
                                    <div class="info-value">{{ $delivery->order->contact_email }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Phone Number:</div>
                                    <div class="info-value">{{ $delivery->order->contact_phone }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-semibold mb-3">
                                    <i class="bi bi-geo-alt me-2"></i> Delivery Address
                                </h6>
                                <div class="info-row">
                                    <div class="info-value">{{ $delivery->order->shipping_address }}</div>
                                </div>
                                @if($delivery->order->delivery_instructions)
                                <div class="info-row mt-2">
                                    <div class="info-label">Special Instructions:</div>
                                    <div class="info-value">{{ $delivery->order->delivery_instructions }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-row">
                                    <div class="info-label">Order Date:</div>
                                    <div class="info-value">{{ $delivery->order->created_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <div class="info-label">Payment Method:</div>
                                    <div class="info-value">{{ $delivery->order->payment_method_text }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <div class="info-label">Total Amount:</div>
                                    <div class="info-value fw-bold text-primary">₱{{ number_format($delivery->order->total, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Items Card -->
                <div class="card">
                    <div class="card-header-custom">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-box-seam me-2" style="color: var(--primary);"></i>
                            Order Items ({{ $delivery->order->items->count() }})
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        @foreach($delivery->order->items as $item)
                        <div class="product-item">
                            <div class="product-image">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}">
                                @else
                                    <i class="bi bi-box"></i>
                                @endif
                            </div>
                            <div class="product-details">
                                <div class="product-name">{{ $item->product_name }}</div>
                                <div class="product-sku">SKU: {{ $item->product_sku ?? 'N/A' }}</div>
                            </div>
                            <div class="product-price">
                                <div class="price">₱{{ number_format($item->price, 2) }}</div>
                                <div class="quantity">Qty: {{ $item->quantity }}</div>
                            </div>
                        </div>
                        @endforeach
                        
                        <hr class="my-3">
                        
                        <div class="totals-table">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td>Subtotal:</td>
                                    <td>₱{{ number_format($delivery->order->subtotal, 2) }}</td>
                                </tr>
                                @if($delivery->order->discount > 0)
                                <tr>
                                    <td>Discount:</td>
                                    <td class="text-success">-₱{{ number_format($delivery->order->discount, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Shipping Fee:</td>
                                    <td>₱{{ number_format($delivery->order->shipping_fee, 2) }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-bold">Total:</td>
                                    <td class="fw-bold text-primary fs-5">₱{{ number_format($delivery->order->total, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Update Status Card -->
                <div class="card">
                    <div class="card-header-custom">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-arrow-repeat me-2" style="color: var(--primary);"></i>
                            Update Status
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        <form id="updateStatusForm" action="{{ route('delivery.update-status', $delivery->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Delivery Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="picked_up" {{ $delivery->status == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                                    <option value="in_transit" {{ $delivery->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                    <option value="delivered" {{ $delivery->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="failed" {{ $delivery->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Notes (Optional)</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Add delivery notes..."></textarea>
                            </div>
                            
                            <div class="mb-3" id="proofField" style="display: none;">
                                <label class="form-label fw-semibold">Proof of Delivery</label>
                                <input type="file" name="proof_image" class="form-control" accept="image/*">
                                <small class="text-muted">Take a photo of the delivered order</small>
                            </div>
                            
                            <button type="submit" class="btn-update">
                                <i class="bi bi-check-circle"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Tracking Timeline Card -->
                @if($delivery->tracking && $delivery->tracking->count() > 0)
                <div class="card">
                    <div class="card-header-custom">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-clock-history me-2" style="color: var(--primary);"></i>
                            Delivery Timeline
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="timeline">
                            @foreach($delivery->tracking->sortByDesc('created_at') as $track)
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="bi bi-circle-fill"></i>
                                </div>
                                <div class="timeline-content">
                                    <strong class="small">{{ $track->status_label }}</strong>
                                    <div class="text-muted small">{{ $track->formatted_created_at }}</div>
                                    @if($track->notes)
                                        <p class="mt-1 mb-0 small text-muted">{{ $track->notes }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Show/hide proof of delivery field based on status
        const statusSelect = document.querySelector('select[name="status"]');
        const proofField = document.getElementById('proofField');
        
        function toggleProofField() {
            if (statusSelect && proofField) {
                if (statusSelect.value === 'delivered') {
                    proofField.style.display = 'block';
                } else {
                    proofField.style.display = 'none';
                }
            }
        }
        
        if (statusSelect) {
            statusSelect.addEventListener('change', toggleProofField);
            toggleProofField();
        }
        
        // Form submission with toast notification
        const form = document.getElementById('updateStatusForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Processing...';
            });
        }
        
        function showToast(message, type) {
            let toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast-custom';
            toast.style.borderLeftColor = type === 'success' ? 'var(--primary)' : 'var(--danger)';
            const icon = type === 'success' ? 'check-circle-fill' : 'exclamation-circle-fill';
            
            toast.innerHTML = `
                <i class="bi bi-${icon}" style="color: ${type === 'success' ? 'var(--primary)' : 'var(--danger)'}; font-size: 1.1rem;"></i>
                <div class="flex-grow-1 small">${message}</div>
                <button class="btn-close btn-sm" onclick="this.parentElement.remove()"></button>
            `;
            
            toastContainer.appendChild(toast);
            setTimeout(() => { if (toast.parentNode) toast.remove(); }, 4000);
        }
        
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif
        
        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
    </script>
</body>
</html>