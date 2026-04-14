<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard | Grocery Mart</title>
    
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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--slate-50);
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
            color: var(--dark) !important;
        }
        
        /* Main Container - Full width with side margins */
        .main-container {
            width: 100%;
            padding: 2rem 2rem;
        }
        
        /* Stats Cards */
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
            border: 1px solid var(--slate-200);
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-color: var(--primary-light);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            background: var(--primary-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
        }
        
        .stat-icon i {
            font-size: 1.5rem;
            color: var(--primary);
        }
        
        .stat-value {
            font-family: 'Outfit', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--slate-800);
            line-height: 1.2;
        }
        
        .stat-label {
            color: var(--slate-500);
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 0.25rem;
        }
        
        /* Tabs */
        .section-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--slate-200);
            padding-bottom: 0;
        }
        
        .section-tab {
            background: none;
            border: none;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            color: var(--slate-500);
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 8px 8px 0 0;
        }
        
        .section-tab.active {
            color: var(--primary);
            border-bottom: 2px solid var(--primary);
            background: none;
        }
        
        .section-tab:hover:not(.active) {
            color: var(--primary);
            background: var(--slate-100);
        }
        
        /* Delivery Cards */
        .delivery-card {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--slate-200);
            margin-bottom: 1rem;
            transition: all 0.2s ease;
        }
        
        .delivery-card:hover {
            border-color: var(--primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .delivery-card-header {
            padding: 1.25rem 1.5rem;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 0.3rem 0.9rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        
        .status-sorting_facility, .status-arrived_at_sorting { 
            background: var(--info-light);
            color: var(--info);
        }
        
        .status-picked_up { 
            background: var(--info-light);
            color: var(--info);
        }
        
        .status-in_transit, .status-out_for_delivery { 
            background: var(--warning-light);
            color: var(--warning);
        }
        
        .status-delivered { 
            background: var(--success-light);
            color: var(--success);
        }
        
        /* Buttons */
        .btn-sm-custom {
            padding: 0.4rem 1.1rem;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .btn-primary-custom {
            background: var(--dark);
            color: white;
            border: none;
        }
        
        .btn-primary-custom:hover {
            background: var(--primary);
        }
        
        .btn-success-custom {
            background: var(--success);
            color: white;
            border: none;
        }
        
        .btn-success-custom:hover {
            background: #218838;
        }
        
        .btn-outline-custom {
            background: white;
            border: 1px solid var(--slate-200);
            color: var(--slate-600);
        }
        
        .btn-outline-custom:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }
        
        .btn-view {
            background: var(--info);
            color: white;
            border: none;
        }
        
        .btn-view:hover {
            background: #2563eb;
        }
        
        /* Info Items */
        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--slate-600);
            font-size: 0.85rem;
        }
        
        .info-item i {
            width: 18px;
            color: var(--slate-400);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 20px;
            border: 1px solid var(--slate-200);
        }
        
        .empty-state-icon {
            width: 70px;
            height: 70px;
            background: var(--slate-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        
        .empty-state-icon i {
            font-size: 2rem;
            color: var(--slate-400);
        }
        
        /* Modal */
        .modal-custom {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        
        .modal-custom.show {
            display: flex;
        }
        
        .modal-content-custom {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            max-width: 450px;
            width: 90%;
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
        
        .badge-icon-sm {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }
        
        /* Button Group */
        .button-group {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }
        
        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid var(--slate-200);
            padding: 1.2rem;
            margin-top: 2rem;
        }
        
        @media (max-width: 992px) {
            .main-container {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            .stats-grid {
                gap: 1rem;
            }
            .section-tab {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
            .delivery-card-header .row > div {
                margin-bottom: 0.75rem;
            }
            .delivery-card-header .text-end {
                text-align: left !important;
            }
            .button-group {
                justify-content: flex-start;
                margin-top: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="toast-container" id="toastContainer"></div>
    
    <nav class="navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('delivery.dashboard') }}">
                <i class="bi bi-truck me-2" style="color: var(--primary);"></i>
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
        <!-- Header -->
        <div class="mb-4">
            <h1 class="h2 fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">Delivery Dashboard</h1>
            <p class="text-muted small mb-0">Manage your deliveries and track assignments</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-truck"></i></div>
                <div class="stat-value">{{ $stats['total_deliveries'] }}</div>
                <div class="stat-label">Total Deliveries</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
                <div class="stat-value">{{ $stats['completed_today'] }}</div>
                <div class="stat-label">Completed Today</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                <div class="stat-value">{{ $stats['active_deliveries'] }}</div>
                <div class="stat-label">Active Deliveries</div>
            </div>
        </div>
        
        <!-- Tabs -->
        <div class="section-tabs">
            <button class="section-tab active" onclick="switchTab('active')" id="tabActiveBtn">
                <i class="bi bi-truck"></i> Active Deliveries
                @if($stats['active_deliveries'] > 0)
                    <span class="badge bg-secondary text-white rounded-pill px-2 py-0">{{ $stats['active_deliveries'] }}</span>
                @endif
            </button>
            <button class="section-tab" onclick="switchTab('available')" id="tabAvailableBtn">
                <i class="bi bi-building"></i> Available Orders
                @if(count($availableOrders) > 0)
                    <span class="badge bg-secondary text-white rounded-pill px-2 py-0">{{ count($availableOrders) }}</span>
                @endif
            </button>
        </div>
        
        <!-- Active Deliveries Section -->
        <div id="activeDeliveriesSection">
            @if($activeDeliveries->count() > 0)
                @foreach($activeDeliveries as $delivery)
                <div class="delivery-card">
                    <div class="delivery-card-header">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="badge-icon-sm">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <div>
                                        <strong class="fs-6">#{{ $delivery->order->order_number }}</strong>
                                        <div class="text-muted small">{{ $delivery->order->created_at->setTimezone('Asia/Manila')->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <i class="bi bi-person"></i>
                                    <span>{{ $delivery->order->user->first_name ?? 'Guest' }} {{ $delivery->order->user->last_name ?? '' }}</span>
                                </div>
                                <div class="info-item mt-1">
                                    <i class="bi bi-geo-alt"></i>
                                    <span class="small">{{ Str::limit($delivery->order->shipping_address ?? 'Address provided', 40) }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <span class="status-badge status-{{ $delivery->status }}">
                                    <i class="bi bi-{{ $delivery->status == 'picked_up' ? 'box-seam' : ($delivery->status == 'in_transit' ? 'truck' : 'clock') }}"></i>
                                    {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
                                </span>
                            </div>
                            <div class="col-md-2">
                                <strong class="text-primary">₱{{ number_format($delivery->order->total, 2) }}</strong>
                                <div class="text-muted small">{{ $delivery->order->payment_method_text }}</div>
                            </div>
                            <div class="col-md-2">
                                <div class="button-group">
                                    <a href="{{ route('delivery.show', $delivery->id) }}" class="btn btn-view btn-sm-custom">
                                        <i class="bi bi-eye"></i> View Details
                                    </a>
                                    <a href="{{ route('delivery.show', $delivery->id) }}" class="btn btn-primary-custom btn-sm-custom">
                                        <i class="bi bi-arrow-right"></i> Update
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h6 class="fw-semibold mb-1">No Active Deliveries</h6>
                    <p class="text-muted small mb-0">You don't have any active deliveries at the moment.</p>
                </div>
            @endif
        </div>
        
        <!-- Available Orders Section -->
        <div id="availableOrdersSection" style="display: none;">
            @if($availableOrders->count() > 0)
                @foreach($availableOrders as $order)
                <div class="delivery-card">
                    <div class="delivery-card-header">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="badge-icon-sm">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <div>
                                        <strong class="fs-6">#{{ $order->order_number }}</strong>
                                        <div class="text-muted small">{{ $order->created_at->setTimezone('Asia/Manila')->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <i class="bi bi-person"></i>
                                    <span>{{ $order->user->first_name ?? 'Guest' }} {{ $order->user->last_name ?? '' }}</span>
                                </div>
                                <div class="info-item mt-1">
                                    <i class="bi bi-geo-alt"></i>
                                    <span class="small">{{ Str::limit($order->shipping_address ?? 'Address provided', 40) }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <span class="status-badge status-sorting_facility">
                                    <i class="bi bi-building"></i> Sorting Facility
                                </span>
                            </div>
                            <div class="col-md-2">
                                <strong class="text-primary">₱{{ number_format($order->total, 2) }}</strong>
                                <div class="text-muted small">{{ $order->payment_method_text }}</div>
                            </div>
                            <div class="col-md-2">
                                <div class="button-group">
                                    <a href="{{ route('delivery.show-order', $order->id) }}" class="btn btn-view btn-sm-custom">
                                        <i class="bi bi-eye"></i> View Details
                                    </a>
                                    <button class="btn btn-success-custom btn-sm-custom" onclick="openPickupModal({{ $order->id }}, '{{ $order->order_number }}')">
                                        <i class="bi bi-box-seam"></i> Pick Up
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-check-circle text-success"></i>
                    </div>
                    <h6 class="fw-semibold mb-1">All Caught Up!</h6>
                    <p class="text-muted small mb-0">No orders waiting at sorting facility.</p>
                </div>
            @endif
        </div>
    </div>
    
    <footer class="footer">
        <div class="container text-center">
            <p class="text-muted small mb-0">© {{ date('Y') }} Grocery Mart. All rights reserved.</p>
        </div>
    </footer>
    
    <!-- Pickup Modal -->
    <div class="modal-custom" id="pickupModal">
        <div class="modal-content-custom">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Confirm Pickup</h5>
                <button type="button" class="btn-close" onclick="closeModal()"></button>
            </div>
            <div class="alert alert-info py-2 px-3 mb-3" style="background: var(--info-light); border: none; border-radius: 10px;">
                <i class="bi bi-info-circle-fill me-1"></i>
                You are about to pick up <strong>Order #<span id="modalOrderNumber"></span></strong>
            </div>
            <p class="small text-muted mb-3">This will assign the delivery to you and mark the order as out for delivery.</p>
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-sm btn-outline-custom btn-sm-custom" onclick="closeModal()">Cancel</button>
                <button type="button" class="btn btn-sm btn-success-custom btn-sm-custom" id="confirmPickupBtn" onclick="confirmPickup()">
                    <i class="bi bi-check-circle"></i> Confirm
                </button>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let selectedOrderId = null;
        
        function switchTab(tab) {
            const activeSection = document.getElementById('activeDeliveriesSection');
            const availableSection = document.getElementById('availableOrdersSection');
            const activeBtn = document.getElementById('tabActiveBtn');
            const availableBtn = document.getElementById('tabAvailableBtn');
            
            if (tab === 'active') {
                activeSection.style.display = 'block';
                availableSection.style.display = 'none';
                activeBtn.classList.add('active');
                availableBtn.classList.remove('active');
            } else {
                activeSection.style.display = 'none';
                availableSection.style.display = 'block';
                activeBtn.classList.remove('active');
                availableBtn.classList.add('active');
            }
        }
        
        function openPickupModal(orderId, orderNumber) {
            selectedOrderId = orderId;
            document.getElementById('modalOrderNumber').textContent = orderNumber;
            document.getElementById('pickupModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal() {
            document.getElementById('pickupModal').classList.remove('show');
            document.body.style.overflow = 'auto';
            selectedOrderId = null;
        }
        
        function confirmPickup() {
            if (!selectedOrderId) return;
            
            const confirmBtn = document.getElementById('confirmPickupBtn');
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Processing...';
            
            fetch('{{ route("delivery.assign-and-pickup") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    order_id: selectedOrderId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Order picked up successfully!', 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                } else {
                    showToast(data.message || 'Failed to pick up order.', 'error');
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = '<i class="bi bi-check-circle"></i> Confirm';
                }
                closeModal();
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = '<i class="bi bi-check-circle"></i> Confirm';
                closeModal();
            });
        }
        
        function showToast(message, type) {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) return;
            
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
    </script>
</body>
</html>