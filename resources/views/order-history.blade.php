<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History | Grocery Mart</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #28a745;
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
            --slate-900: #0f172a;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --success: #28a745;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--slate-50);
            color: var(--slate-800);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Navbar Styles */
        .navbar {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .navbar-brand {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--dark) !important;
        }
        
        .brand-icon {
            height: 35px;
            margin-right: 10px;
            filter: brightness(0) invert(22%) sepia(89%) saturate(748%) hue-rotate(81deg) brightness(92%) contrast(92%);
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--slate-600) !important;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary) !important;
            background-color: var(--slate-100);
        }
        
        .nav-link.active {
            color: var(--primary) !important;
            background-color: rgba(40, 167, 69, 0.1);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.5rem 1rem;
            background-color: var(--slate-100);
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .user-profile:hover {
            background-color: var(--slate-200);
        }
        
        .user-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .user-info {
            line-height: 1.3;
        }
        
        .user-name {
            font-weight: 600;
            color: var(--slate-800);
            font-size: 0.9rem;
        }
        
        .user-email {
            font-size: 0.75rem;
            color: var(--slate-500);
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 0.5rem;
        }
        
        .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-weight: 500;
            color: var(--slate-600);
        }
        
        .dropdown-item:hover {
            background-color: var(--slate-100);
            color: var(--primary);
        }
        
        .dropdown-item i {
            margin-right: 8px;
            font-size: 1.1rem;
        }
        
        /* Main Content */
        .main-content {
            padding: 2rem 1.5rem;
            flex: 1;
        }
        
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-header h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }
        
        .page-header p {
            color: var(--slate-500);
            font-size: 1rem;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
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
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--slate-800);
        }
        
        /* Simplified Cancellation Card - No Average */
        .cancellation-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--slate-200);
            transition: all 0.3s;
        }
        
        .cancellation-card:hover {
            transform: translateY(-5px);
            border-color: var(--danger);
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.05);
        }
        
        .cancellation-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .cancellation-icon {
            width: 50px;
            height: 50px;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .cancellation-icon i {
            font-size: 1.8rem;
            color: var(--danger);
        }
        
        .cancellation-info {
            flex: 1;
        }
        
        .cancellation-info h3 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--slate-800);
            margin: 0;
            font-size: 1.2rem;
        }
        
        .cancellation-info p {
            color: var(--slate-500);
            margin: 0.2rem 0 0;
            font-size: 0.85rem;
        }
        
        .cancellation-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .cancellation-stat {
            background: var(--slate-50);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
        }
        
        .cancellation-stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--danger);
            line-height: 1;
        }
        
        .cancellation-stat-label {
            font-size: 0.75rem;
            color: var(--slate-500);
            margin-top: 0.4rem;
        }
        
        .cancellation-note {
            background: rgba(239, 68, 68, 0.05);
            border-radius: 10px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .cancellation-note i {
            color: var(--danger);
            font-size: 1rem;
        }
        
        .cancellation-note span {
            font-size: 0.8rem;
            color: var(--slate-600);
        }
        
        /* Orders Table */
        .orders-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            font-weight: 600;
            color: var(--slate-600);
            border-bottom-width: 2px;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .order-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .badge-pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .badge-processing {
            background: rgba(100, 116, 139, 0.1);
            color: var(--slate-600);
        }
        
        .badge-completed {
            background: rgba(40, 167, 69, 0.1);
            color: var(--primary);
        }
        
        .badge-cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }
        
        .badge-paid {
            background: rgba(40, 167, 69, 0.1);
            color: var(--primary);
        }
        
        .badge-unpaid {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .badge-refunded {
            background: rgba(100, 116, 139, 0.1);
            color: var(--slate-600);
        }
        
        .btn-view {
            background: var(--dark);
            color: white;
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-view:hover {
            background: var(--primary);
            color: white;
        }
        
        .empty-orders {
            text-align: center;
            padding: 3rem;
        }
        
        .empty-orders i {
            font-size: 4rem;
            color: var(--slate-300);
            margin-bottom: 1rem;
        }
        
        .empty-orders h4 {
            color: var(--slate-600);
            margin-bottom: 1rem;
        }
        
        .empty-orders .btn-shop {
            background: var(--dark);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        
        .empty-orders .btn-shop:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }
        
        /* Pagination */
        .pagination {
            gap: 0.3rem;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .page-link {
            border-radius: 8px;
            color: var(--slate-600);
            border: 1px solid var(--slate-200);
            padding: 0.5rem 1rem;
            transition: all 0.3s;
        }
        
        .page-link:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        .page-item.disabled .page-link {
            background: var(--slate-100);
            color: var(--slate-400);
            border-color: var(--slate-200);
            pointer-events: none;
        }
        
        /* Pagination info */
        .pagination-info {
            color: var(--slate-600);
            font-size: 0.9rem;
        }
        
        /* Footer Styles */
        .footer {
            background: white;
            border-top: 1px solid var(--slate-200);
            padding: 3rem 1.5rem 1.5rem;
            margin-top: 3rem;
        }
        
        .footer h5 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.2rem;
        }
        
        .footer a {
            color: var(--slate-600);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer a:hover {
            color: var(--primary);
        }
        
        .footer i {
            margin-right: 0.5rem;
            color: var(--primary);
        }
        
        .footer hr {
            border-color: var(--slate-200);
            opacity: 0.5;
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 12px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .cancellation-stats {
                grid-template-columns: 1fr;
            }
            
            .footer {
                text-align: center;
            }
            
            .pagination {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <i class="bi bi-cart-fill me-2" style="color: var(--primary); font-size: 1.5rem;"></i>
                <span style="font-weight: 700;">Grocery Mart</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="bi bi-shop me-1"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart me-1"></i> Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('order.history') }}">
                            <i class="bi bi-bag me-1"></i> Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('faq') }}">
                            <i class="bi bi-question-circle me-1"></i> FAQ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="bi bi-headset me-1"></i> Support
                        </a>
                    </li>
                </ul>
                
                @auth
                <div class="dropdown">
                    <div class="user-profile" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                            <div class="user-email">{{ auth()->user()->email }}</div>
                        </div>
                        <i class="bi bi-chevron-down" style="color: var(--slate-400);"></i>
                    </div>
                    
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="bi bi-person-circle"></i> My Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="dropdown-header text-muted small">Help & Support</li>
                        <li>
                            <a class="dropdown-item" href="{{ route('faq') }}">
                                <i class="bi bi-question-circle"></i> Frequently Asked Questions
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('contact') }}">
                                <i class="bi bi-headset"></i> Contact Support
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h1>My Orders</h1>
                    <p>View and track your order history</p>
                </div>
                <a href="{{ route('dashboard') }}#products" class="btn btn-outline-primary">
                    <i class="bi bi-plus-circle"></i> Shop More
                </a>
            </div>
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Order Statistics -->
            @php
                $totalOrders = $orders->total();
                $completedOrders = $orders->where('status', 'completed')->count();
                $pendingOrders = $orders->where('status', 'pending')->count();
                $processingOrders = $orders->where('status', 'processing')->count();
                $cancelledOrders = $orders->where('status', 'cancelled')->count();
                
                // Calculate total spent from non-cancelled orders only
                $totalSpent = $orders->filter(function($order) {
                    return $order->status !== 'cancelled';
                })->sum('total');
                
                // Calculate total lost from cancelled orders
                $totalLost = $orders->where('status', 'cancelled')->sum('total');
            @endphp
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-bag"></i>
                    </div>
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-value">{{ $totalOrders }}</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-label">Completed</div>
                    <div class="stat-value">{{ $completedOrders }}</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-hourglass"></i>
                    </div>
                    <div class="stat-label">Pending</div>
                    <div class="stat-value">{{ $pendingOrders }}</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-cash"></i>
                    </div>
                    <div class="stat-label">Total Spent</div>
                    <div class="stat-value">₱{{ number_format($totalSpent, 2) }}</div>
                </div>
            </div>
            
            <!-- Simplified Cancellation Card - Only shows if there are cancelled orders -->
            @if($cancelledOrders > 0)
            <div class="cancellation-card">
                <div class="cancellation-header">
                    <div class="cancellation-icon">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div class="cancellation-info">
                        <h3>Cancelled Orders</h3>
                        <p>You have {{ $cancelledOrders }} cancelled {{ Str::plural('order', $cancelledOrders) }}</p>
                    </div>
                </div>
                
                <div class="cancellation-stats">
                    <div class="cancellation-stat">
                        <div class="cancellation-stat-number">{{ $cancelledOrders }}</div>
                        <div class="cancellation-stat-label">Cancelled Orders</div>
                    </div>
                    <div class="cancellation-stat">
                        <div class="cancellation-stat-number">₱{{ number_format($totalLost, 2) }}</div>
                        <div class="cancellation-stat-label">Total Cancelled Amount</div>
                    </div>
                </div>
                
                <div class="cancellation-note">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Refunds for cancelled orders are processed within 3-5 business days to your original payment method.</span>
                </div>
            </div>
            @endif
            
            <!-- Orders List -->
            <div class="orders-card">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                32
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Action</th>
                                </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr class="{{ $order->status == 'cancelled' ? 'text-muted' : '' }}">
                                    <td>
                                        <strong>{{ $order->order_number }}</strong>
                                        @if($order->status == 'cancelled')
                                            <span class="badge bg-danger bg-opacity-10 text-danger ms-2" style="font-size: 0.7rem; padding: 0.2rem 0.5rem;">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->setTimezone('Asia/Manila')->format('M d, Y') }}</td>
                                    <td>{{ $order->items_count }} items</td>
                                    <td>
                                        @if($order->status == 'cancelled')
                                            <span class="text-muted">₱{{ number_format($order->total, 2) }}</span>
                                            <small class="text-success d-block">Refunded</small>
                                        @else
                                            ₱{{ number_format($order->total, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($order->status) {
                                                'completed' => 'badge-completed',
                                                'pending' => 'badge-pending',
                                                'processing' => 'badge-processing',
                                                'cancelled' => 'badge-cancelled',
                                                default => 'badge-pending'
                                            };
                                        @endphp
                                        <span class="order-badge {{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $paymentClass = match($order->payment_status) {
                                                'paid' => 'badge-paid',
                                                'unpaid' => 'badge-unpaid',
                                                'refunded' => 'badge-refunded',
                                                default => 'badge-unpaid'
                                            };
                                        @endphp
                                        <span class="order-badge {{ $paymentClass }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                        @if($order->status == 'cancelled' && $order->payment_status == 'paid')
                                            <small class="text-success d-block mt-1">Refunded</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('order.details', $order) }}" class="btn-view">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination Section -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
                        <div class="pagination-info mb-3 mb-md-0">
                            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
                            @if($cancelledOrders > 0)
                                <span class="text-danger ms-2">
                                    ({{ $cancelledOrders }} cancelled)
                                </span>
                            @endif
                        </div>
                        
                        @if($orders->hasPages())
                            <nav aria-label="Order pagination">
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    @if($orders->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">
                                                <i class="bi bi-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif
                                    
                                    {{-- Pagination Elements --}}
                                    @foreach($orders->getUrlRange(max(1, $orders->currentPage() - 2), min($orders->lastPage(), $orders->currentPage() + 2)) as $page => $url)
                                        @if($page == $orders->currentPage())
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
                                    @if($orders->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">
                                                <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                    
                @else
                    <!-- Empty State -->
                    <div class="empty-orders">
                        <i class="bi bi-bag"></i>
                        <h4>No orders yet</h4>
                        <p class="text-muted mb-4">Looks like you haven't placed any orders yet.</p>
                        <a href="{{ route('dashboard') }}#products" class="btn-shop">
                            <i class="bi bi-shop"></i> Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-cart-fill" style="color: var(--primary); font-size: 1.5rem;"></i>
                        <h5 class="mb-0" style="font-weight: 700;">Grocery Mart</h5>
                    </div>
                    <p class="text-muted">Your trusted online grocery store. Fresh products delivered to your doorstep.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <p><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i>Dashboard</a></p>
                    <p><a href="{{ route('profile') }}"><i class="bi bi-person-circle"></i>My Profile</a></p>
                    <p><a href="{{ route('faq') }}"><i class="bi bi-question-circle"></i>FAQs</a></p>
                    <p><a href="{{ route('contact') }}"><i class="bi bi-headset"></i>Contact Us</a></p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Connect With Us</h5>
                    <p><i class="bi bi-facebook"></i> <a href="#">Facebook</a></p>
                    <p><i class="bi bi-instagram"></i> <a href="#">Instagram</a></p>
                    <p><i class="bi bi-twitter"></i> <a href="#">Twitter</a></p>
                    <p><i class="bi bi-envelope"></i> <a href="mailto:support@grocerymart.com">support@grocerymart.com</a></p>
                </div>
            </div>
            <hr class="my-4">
            <p class="text-center text-muted small mb-0">© {{ date('Y') }} Grocery Mart. All rights reserved.</p>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>