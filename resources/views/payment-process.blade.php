<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Process | Grocery Mart</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #28a745;
            --primary-dark: #1e7e34;
            --primary-light: #d4edda;
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
        
        .payment-container {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .payment-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
        }
        
        .payment-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .payment-header h2 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .payment-header p {
            color: var(--slate-500);
        }
        
        .method-icon {
            width: 80px;
            height: 80px;
            background: rgba(40, 167, 69, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: var(--primary);
        }
        
        .method-icon img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }
        
        .order-info {
            background: var(--slate-50);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .info-label {
            color: var(--slate-600);
            font-weight: 500;
        }
        
        .info-value {
            font-weight: 600;
            color: var(--dark);
        }
        
        .payment-reference {
            background: var(--primary-light);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: center;
            border: 2px dashed var(--primary);
        }
        
        .payment-reference-label {
            font-size: 0.9rem;
            color: var(--slate-600);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .payment-reference-number {
            font-family: 'Outfit', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 2px;
            background: white;
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        
        .payment-details {
            margin-bottom: 2rem;
        }
        
        .qr-section {
            text-align: center;
            padding: 2rem;
            background: var(--slate-50);
            border-radius: 16px;
            margin-bottom: 2rem;
        }
        
        .qr-code {
            width: 200px;
            height: 200px;
            margin: 0 auto 1rem;
            background: white;
            padding: 1rem;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .qr-code img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .card-form {
            background: var(--slate-50);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--slate-600);
            margin-bottom: 0.3rem;
        }
        
        .form-control, .form-select {
            height: 48px;
            border-radius: 12px;
            border: 1.5px solid var(--slate-200);
            padding: 0.5rem 1rem;
            font-size: 0.95rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.1);
            outline: none;
        }
        
        .row.gap-2 {
            margin-left: -0.25rem;
            margin-right: -0.25rem;
        }
        
        .row.gap-2 > [class*="col-"] {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
        
        .btn-pay {
            width: 100%;
            background: var(--dark);
            color: white;
            border: none;
            height: 52px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s;
        }
        
        .btn-pay:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }
        
        .btn-pay:disabled {
            background: var(--slate-200);
            color: var(--slate-400);
            cursor: not-allowed;
            transform: none;
        }
        
        .btn-secondary {
            width: 100%;
            background: white;
            border: 1.5px solid var(--slate-200);
            color: var(--slate-600);
            height: 48px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }
        
        .button-group {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .button-group .btn-pay {
            flex: 2;
            margin-bottom: 0;
        }
        
        .button-group .btn-secondary {
            flex: 1;
            margin-bottom: 0;
        }
        
        .payment-instructions {
            margin-top: 2rem;
            padding: 1.5rem;
            background: rgba(40, 167, 69, 0.05);
            border-radius: 12px;
            border-left: 4px solid var(--primary);
        }
        
        .payment-instructions h6 {
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        
        .payment-instructions ol {
            margin-bottom: 0;
            padding-left: 1.2rem;
            color: var(--slate-600);
        }
        
        .payment-instructions li {
            margin-bottom: 0.5rem;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.3rem 1rem;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .badge-pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
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
            .payment-card {
                padding: 1.5rem;
            }
            
            .footer {
                text-align: center;
            }
            
            .button-group {
                flex-direction: column;
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
                        <a class="nav-link active" href="{{ route('faq') }}">
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
            <div class="payment-container">
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
                
                <div class="payment-card">
                    <div class="payment-header">
                        <div class="method-icon">
                            @switch($method)
                                @case('gcash')
                                    <img src="{{ asset('img/gcash-logo_brandlogos.net_kiaqh.png') }}" alt="GCash" style="width: 50px; height: 50px; object-fit: contain;">
                                    @break
                                @case('paymaya')
                                    <i class="bi bi-phone"></i>
                                    @break
                                @case('credit_card')
                                @case('debit_card')
                                    <i class="bi bi-credit-card"></i>
                                    @break
                                @default
                                    <i class="bi bi-cash"></i>
                            @endswitch
                        </div>
                        <h2>Complete Your Payment</h2>
                        <p>
                            @switch($method)
                                @case('gcash')
                                    Pay via GCash
                                    @break
                                @case('paymaya')
                                    Pay via PayMaya
                                    @break
                                @case('credit_card')
                                    Pay with Credit Card
                                    @break
                                @case('debit_card')
                                    Pay with Debit Card
                                    @break
                                @default
                                    Payment
                            @endswitch
                        </p>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="order-info">
                        <div class="info-row">
                            <span class="info-label">Order Number</span>
                            <span class="info-value">{{ $order->order_number }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Order Date</span>
                            <span class="info-value">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Total Amount</span>
                            <span class="info-value text-primary fw-bold">₱{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                    
                    <!-- Payment Reference (Display from payment record) -->
                    @if($order->payment && $order->payment->payment_reference)
                    <div class="payment-reference">
                        <div class="payment-reference-label">Payment Reference Number</div>
                        <div class="payment-reference-number">{{ $order->payment->payment_reference }}</div>
                        <small class="text-muted mt-2 d-block">Please use this reference for payment and any inquiries</small>
                    </div>
                    @endif
                    
                    <!-- Payment Status -->
                    @if($order->payment)
                    <div class="mb-3 text-center">
                        <span class="status-badge badge-pending">
                            <i class="bi bi-clock me-1"></i>
                            Payment Status: {{ ucfirst($order->payment->status) }}
                        </span>
                    </div>
                    @endif
                    
                    <!-- Payment Details Based on Method -->
                    @switch($method)
                        @case('gcash')
                        @case('paymaya')
                            <!-- E-Wallet Payment with QR Code -->
                            <div class="payment-details">
                                <div class="qr-section">
                                    <div class="qr-code">
                                        <!-- QR code generated with payment reference -->
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $order->payment->payment_reference ?? $order->order_number }}" alt="Payment QR Code">
                                    </div>
                                    <p class="mb-2">Scan QR code or use reference number</p>
                                    <div class="reference-number" style="font-size: 1.2rem; padding: 0.5rem 1rem; background: white; border-radius: 8px; display: inline-block;">
                                        <strong>{{ $order->payment->payment_reference ?? $order->order_number }}</strong>
                                    </div>
                                </div>
                                
                                <div class="payment-instructions">
                                    <h6>How to pay via {{ ucfirst($method) }}:</h6>
                                    <ol>
                                        <li>Open your {{ ucfirst($method) }} app</li>
                                        <li>Scan the QR code above OR enter reference number: <strong>{{ $order->payment->payment_reference ?? $order->order_number }}</strong></li>
                                        <li>Verify the amount: <strong>₱{{ number_format($order->total, 2) }}</strong></li>
                                        <li>Enter your MPIN to confirm</li>
                                        <li>Click "I Have Paid" after completing payment</li>
                                    </ol>
                                </div>
                            </div>
                            @break
                            
                        @case('credit_card')
                        @case('debit_card')
                            <!-- Card Payment Form -->
                            <div class="payment-details">
                                <div class="card-form">
                                    <form id="cardPaymentForm" onsubmit="event.preventDefault(); processCardPayment();">
                                        <div class="mb-3">
                                            <label class="form-label">Card Number</label>
                                            <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Cardholder Name</label>
                                            <input type="text" class="form-control" id="cardholderName" placeholder="John Doe" required>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label class="form-label">Month</label>
                                                <select class="form-select" id="expiryMonth" required>
                                                    <option value="">MM</option>
                                                    @for($i = 1; $i <= 12; $i++)
                                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label">Year</label>
                                                <select class="form-select" id="expiryYear" required>
                                                    <option value="">YY</option>
                                                    @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                                        <option value="{{ substr($i, -2) }}">{{ substr($i, -2) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label">CVV</label>
                                                <input type="text" class="form-control" id="cvv" placeholder="123" maxlength="3" required>
                                            </div>
                                        </div>
                                        
                                        <div class="payment-reference mt-3 mb-3" style="border: 1px dashed var(--primary);">
                                            <div class="payment-reference-label">Payment Reference</div>
                                            <div class="payment-reference-number" style="font-size: 1.2rem;">{{ $order->payment->payment_reference ?? 'N/A' }}</div>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="payment-instructions">
                                    <h6>Secure Payment</h6>
                                    <p class="mb-0 small text-muted">
                                        <i class="bi bi-shield-lock me-1"></i>
                                        Your payment information is encrypted and secure. We do not store your card details.
                                    </p>
                                </div>
                            </div>
                            @break
                    @endswitch
                    
                    <!-- Action Buttons with Back/Proceed Options -->
                    <div class="button-group">
                        <!-- Back button to return to order details -->
                        <a href="{{ route('order.details', $order) }}" class="btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </a>
                        
                        <!-- For GCash/PayMaya - I Have Paid Button -->
                        @if(in_array($method, ['gcash', 'paymaya']))
                        <form action="{{ route('payment.callback') }}" method="POST" style="flex: 2;" id="paymentForm">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" name="payment_method" value="{{ $method }}">
                            <input type="hidden" name="payment_reference" value="{{ $order->payment->payment_reference ?? 'REF-'.uniqid() }}">
                            <input type="hidden" name="status" value="success">
                            
                            <button type="submit" class="btn-pay" id="confirmPaymentBtn">
                                <i class="bi bi-check-circle me-2"></i>
                                I Have Paid
                            </button>
                        </form>
                        @endif
                    </div>
                    
                    <!-- For Card Payments - Single button since card form has its own -->
                    @if(in_array($method, ['credit_card', 'debit_card']))
                    <div class="button-group">
                        <a href="{{ route('order.details', $order) }}" class="btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </a>
                        <button type="button" class="btn-pay" onclick="processCardPayment()" style="flex: 2;">
                            <i class="bi bi-lock me-2"></i>Pay Now
                        </button>
                    </div>
                    @endif
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
        // Format card number input
        const cardNumber = document.getElementById('cardNumber');
        if (cardNumber) {
            cardNumber.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s/g, '');
                if (value.length > 0) {
                    value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
                }
                e.target.value = value;
            });
        }
        
        // Format CVV
        const cvv = document.getElementById('cvv');
        if (cvv) {
            cvv.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '').slice(0, 3);
            });
        }
        
        // Process card payment
        function processCardPayment() {
            const cardNumber = document.getElementById('cardNumber')?.value.replace(/\s/g, '');
            const cardholderName = document.getElementById('cardholderName')?.value;
            const expiryMonth = document.getElementById('expiryMonth')?.value;
            const expiryYear = document.getElementById('expiryYear')?.value;
            const cvv = document.getElementById('cvv')?.value;
            
            if (!cardNumber || cardNumber.length < 16) {
                alert('Please enter a valid card number');
                return;
            }
            
            if (!cardholderName) {
                alert('Please enter the cardholder name');
                return;
            }
            
            if (!expiryMonth || !expiryYear) {
                alert('Please select expiry date');
                return;
            }
            
            if (!cvv || cvv.length < 3) {
                alert('Please enter a valid CVV');
                return;
            }
            
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("payment.callback") }}';
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            
            const orderId = document.createElement('input');
            orderId.type = 'hidden';
            orderId.name = 'order_id';
            orderId.value = '{{ $order->id }}';
            form.appendChild(orderId);
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = 'payment_method';
            method.value = '{{ $method }}';
            form.appendChild(method);
            
            const reference = document.createElement('input');
            reference.type = 'hidden';
            reference.name = 'payment_reference';
            reference.value = '{{ $order->payment->payment_reference ?? "REF-".uniqid() }}';
            form.appendChild(reference);
            
            const status = document.createElement('input');
            status.type = 'hidden';
            status.name = 'status';
            status.value = 'success';
            form.appendChild(status);
            
            document.body.appendChild(form);
            form.submit();
        }
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>