<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt | Grocery Mart</title>
    
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
        
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .receipt-header h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            font-size: 2rem;
        }
        
        .btn-print {
            background: var(--dark);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-print:hover {
            background: var(--primary);
            color: white;
        }
        
        .receipt-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
        }
        
        /* Receipt Header */
        .receipt-brand {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px dashed var(--slate-200);
        }
        
        .receipt-brand h2 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .receipt-brand p {
            color: var(--slate-500);
            margin-bottom: 0.5rem;
        }
        
        .receipt-brand .receipt-number {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary);
        }
        
        /* Receipt Info Grid */
        .receipt-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .info-block h6 {
            font-weight: 600;
            color: var(--slate-500);
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }
        
        .info-block p {
            margin-bottom: 0.25rem;
            color: var(--slate-800);
        }
        
        /* Receipt Items */
        .receipt-items {
            margin-bottom: 2rem;
        }
        
        .items-header {
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 1fr;
            padding: 0.8rem 0;
            border-bottom: 2px solid var(--slate-200);
            font-weight: 600;
            color: var(--slate-600);
            font-size: 0.9rem;
        }
        
        .item-row {
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 1fr;
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--slate-100);
        }
        
        .item-row:last-child {
            border-bottom: none;
        }
        
        .item-name {
            font-weight: 500;
        }
        
        .item-sku {
            font-size: 0.8rem;
            color: var(--slate-500);
            margin-top: 0.2rem;
        }
        
        .item-qty, .item-price, .item-total {
            text-align: right;
        }
        
        .item-total {
            font-weight: 600;
            color: var(--dark);
        }
        
        /* Receipt Summary */
        .receipt-summary {
            background: var(--slate-50);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .summary-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .summary-row.total {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
        }
        
        .summary-label {
            color: var(--slate-600);
        }
        
        .summary-value {
            font-weight: 600;
        }
        
        /* Payment Status */
        .payment-status {
            display: inline-block;
            padding: 0.3rem 1rem;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-paid {
            background: rgba(40, 167, 69, 0.1);
            color: var(--primary);
        }
        
        .status-pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .status-refunded {
            background: rgba(100, 116, 139, 0.1);
            color: var(--slate-600);
        }
        
        /* Receipt Footer */
        .receipt-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px dashed var(--slate-200);
            color: var(--slate-500);
            font-size: 0.9rem;
        }
        
        .receipt-footer p {
            margin-bottom: 0.25rem;
        }
        
        .footer-note {
            margin-top: 1rem;
            font-weight: 500;
            color: var(--primary);
        }
        
        /* Page Footer Styles */
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
        
        /* Print Styles */
        @media print {
            .navbar, .footer, .btn-print, .dropdown {
                display: none !important;
            }
            
            .main-content {
                padding: 0;
                flex: none;
            }
            
            .receipt-card {
                box-shadow: none;
                border: none;
            }
            
            body {
                background: white;
                display: block;
                min-height: auto;
            }
        }
        
        @media (max-width: 768px) {
            .footer {
                text-align: center;
            }
            
            .receipt-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
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
                        <a class="nav-link" href="{{ route('order.history') }}">
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
        <div class="container">
            <div class="receipt-container">
                <!-- Receipt Header with Print Button -->
                <div class="receipt-header">
                    <h1>Payment Receipt</h1>
                    <button onclick="window.print()" class="btn-print">
                        <i class="bi bi-printer"></i> Print Receipt
                    </button>
                </div>
                
                <!-- Receipt Card -->
                <div class="receipt-card" id="receipt">
                    <!-- Brand Header -->
                    <div class="receipt-brand">
                        <h2>Grocery Mart</h2>
                        <p>Your Trusted Online Grocery Store</p>
                        <p class="receipt-number">Receipt #: {{ $order->order_number }}</p>
                        <p>Date: {{ $order->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                    
                    <!-- Customer & Order Info -->
                    <div class="receipt-info-grid">
                        <div class="info-block">
                            <h6>BILL TO</h6>
                            <p><strong>{{ $order->user->first_name }} {{ $order->user->last_name }}</strong></p>
                            <p>{{ $order->contact_email }}</p>
                            <p>{{ $order->contact_phone }}</p>
                        </div>
                        
                        <div class="info-block">
                            <h6>ORDER INFO</h6>
                            <p><strong>Payment Method:</strong> 
                                @switch($order->payment_method)
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
                                        {{ ucfirst($order->payment_method) }}
                                @endswitch
                            </p>
                            <p><strong>Payment Status:</strong> 
                                <span class="payment-status status-{{ $order->payment_status }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                            <p><strong>Order Status:</strong> {{ ucfirst($order->status) }}</p>
                        </div>
                    </div>
                    
                    <!-- Shipping Address -->
                    <div class="info-block mb-4">
                        <h6>SHIPPING ADDRESS</h6>
                        <p>{{ $order->shipping_address }}</p>
                    </div>
                    
                    <!-- Order Items -->
                    <div class="receipt-items">
                        <div class="items-header">
                            <div>Item</div>
                            <div class="item-qty">Qty</div>
                            <div class="item-price">Price</div>
                            <div class="item-total">Total</div>
                        </div>
                        
                        @foreach($order->items as $item)
                        <div class="item-row">
                            <div>
                                <div class="item-name">{{ $item->product_name }}</div>
                                <div class="item-sku">SKU: {{ $item->product_sku ?? 'N/A' }}</div>
                            </div>
                            <div class="item-qty">{{ $item->quantity }}</div>
                            <div class="item-price">₱{{ number_format($item->price, 2) }}</div>
                            <div class="item-total">₱{{ number_format($item->price * $item->quantity, 2) }}</div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Summary -->
                    <div class="receipt-summary">
                        <div class="summary-row">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value">₱{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        
                        @if($order->discount > 0)
                        <div class="summary-row">
                            <span class="summary-label">Discount</span>
                            <span class="summary-value text-success">-₱{{ number_format($order->discount, 2) }}</span>
                        </div>
                        @endif
                        
                        <div class="summary-row">
                            <span class="summary-label">Shipping Fee</span>
                            <span class="summary-value">₱{{ number_format($order->shipping_fee, 2) }}</span>
                        </div>
                        
                        <div class="summary-row total">
                            <span class="summary-label">Total Amount</span>
                            <span class="summary-value text-primary">₱{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                    
                    <!-- Payment Details -->
                    @if($order->payment)
                    <div class="info-block mb-3">
                        <h6>PAYMENT DETAILS</h6>
                        <p><strong>Transaction ID:</strong> {{ $order->payment->payment_reference ?? 'N/A' }}</p>
                        <p><strong>Paid At:</strong> {{ $order->paid_at ? $order->paid_at->format('F d, Y h:i A') : 'N/A' }}</p>
                    </div>
                    @endif
                    
                    <!-- Footer -->
                    <div class="receipt-footer">
                        <p>Thank you for shopping with Grocery Mart!</p>
                        <p>For any inquiries, please contact support@grocerymart.com</p>
                        <div class="footer-note">
                            <i class="bi bi-check-circle-fill"></i> This is a system-generated receipt
                        </div>
                    </div>
                </div>
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
    
    <script>
        // Print functionality
        document.querySelector('.btn-print').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>
</html>