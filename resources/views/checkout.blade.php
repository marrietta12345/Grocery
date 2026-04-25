<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Grocery Mart</title>
    
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
        
        /* Checkout Styles */
        .checkout-container {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 2rem;
        }
        
        .checkout-form {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
        }
        
        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .section-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            color: var(--dark);
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
        
        textarea.form-control {
            height: auto;
            min-height: 100px;
        }
        
        /* Payment Methods */
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .payment-method {
            background: var(--slate-50);
            border: 2px solid var(--slate-200);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .payment-method:hover {
            border-color: var(--primary);
            background: white;
        }
        
        .payment-method.selected {
            border-color: var(--primary);
            background: rgba(40, 167, 69, 0.05);
        }
        
        .payment-method i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .payment-method .payment-logo {
            height: 32px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            margin-bottom: 0.5rem;
        }
        
        .payment-method span {
            display: block;
            font-weight: 600;
            color: var(--slate-700);
        }
        
        .payment-method small {
            color: var(--slate-500);
            font-size: 0.75rem;
        }
        
        /* Modal Styles */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .modal-header {
            border-bottom: 1px solid var(--slate-200);
            padding: 1.5rem;
        }
        
        .modal-header h5 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            border-top: 1px solid var(--slate-200);
            padding: 1.5rem;
        }
        
        .modal-icon {
            width: 60px;
            height: 60px;
            background: rgba(40, 167, 69, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: var(--primary);
        }
        
        .modal-icon img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
        
        /* Order Summary */
        .order-summary {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
            position: sticky;
            top: 2rem;
        }
        
        .summary-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }
        
        .summary-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .summary-item-image {
            width: 50px;
            height: 50px;
            background: var(--slate-100);
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .summary-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .summary-item-image i {
            font-size: 1.5rem;
            color: var(--primary);
        }
        
        .summary-item-details {
            flex: 1;
        }
        
        .summary-item-name {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.2rem;
        }
        
        .summary-item-meta {
            font-size: 0.8rem;
            color: var(--slate-500);
        }
        
        .summary-item-price {
            font-weight: 700;
            color: var(--primary);
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .summary-row.total {
            border-bottom: none;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-top: 1rem;
        }
        
        .place-order-btn {
            width: 100%;
            background: var(--dark);
            color: white;
            border: none;
            height: 52px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s;
            margin-top: 1.5rem;
        }
        
        .place-order-btn:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }
        
        .back-to-cart {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--slate-500);
            text-decoration: none;
        }
        
        .back-to-cart:hover {
            color: var(--primary);
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
            .checkout-container {
                grid-template-columns: 1fr;
            }
            
            .payment-methods {
                grid-template-columns: 1fr;
            }
            
            .footer {
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
    
    <!-- GCash/PayMaya Modal -->
    <div class="modal fade" id="ewalletModal" tabindex="-1" aria-labelledby="ewalletModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ewalletModalLabel">GCash Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-icon">
                        <img src="{{ asset('img/gcash-logo_brandlogos.net_kiaqh.png') }}" alt="GCash" id="ewalletIcon">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mobileNumber" placeholder="e.g., 09123456789">
                        <small class="text-muted">Enter your registered GCash/PayMaya mobile number</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            You will receive a payment request on your mobile app. Please confirm to proceed.
                        </div>
                    </div>
                    
                    <div class="payment-summary bg-light p-3 rounded">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Amount to pay:</span>
                            <span class="fw-bold text-primary" id="ewalletAmount">₱0.00</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="confirmEwalletPayment()">
                        <i class="bi bi-check-circle me-2"></i>Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Credit/Debit Card Modal -->
    <div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cardModalLabel">Card Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-icon">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Card Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Cardholder Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cardholderName" placeholder="John Doe">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-4">
                            <label class="form-label">Month</label>
                            <select class="form-select" id="expiryMonth">
                                <option value="">MM</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Year</label>
                            <select class="form-select" id="expiryYear">
                                <option value="">YY</option>
                                @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                    <option value="{{ substr($i, -2) }}">{{ substr($i, -2) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cvv" placeholder="123" maxlength="3">
                        </div>
                    </div>
                    
                    <div class="payment-summary bg-light p-3 rounded">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Amount to charge:</span>
                            <span class="fw-bold text-primary" id="cardAmount">₱0.00</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="confirmCardPayment()">
                        <i class="bi bi-check-circle me-2"></i>Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Checkout</h1>
                <p>Complete your order by providing your details</p>
            </div>
            
            <!-- Success/Error Messages -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    Please fix the errors below.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="checkout-container">
                <!-- Checkout Form -->
                <div class="checkout-form">
                    <form action="{{ route('order.place') }}" method="POST" id="checkoutForm">
                        @csrf
                        
                        <!-- Contact Information -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-person me-2" style="color: var(--primary);"></i>
                                Contact Information
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contact Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" 
                                           value="{{ old('contact_phone') }}" 
                                           placeholder="e.g., 09123456789" required>
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contact Email <span class="text-danger">*</span></label>
                                    <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror" 
                                           value="{{ old('contact_email', auth()->user()->email) }}" 
                                           placeholder="your@email.com" required>
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Shipping Address -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-geo-alt me-2" style="color: var(--primary);"></i>
                                Shipping Address
                            </h5>
                            
                            @if(isset($addresses) && $addresses->count() > 0)
                                <!-- User has saved addresses -->
                                <div class="mb-4">
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        Select from your saved addresses or enter a new one below.
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Choose Saved Address</label>
                                        <select class="form-select" id="savedAddress">
                                            <option value="">-- Enter new address below --</option>
                                            @foreach($addresses as $address)
                                                <option value="{{ $address->id }}" 
                                                        data-name="{{ $address->recipient_name }}"
                                                        data-phone="{{ $address->recipient_phone }}"
                                                        data-line1="{{ $address->address_line1 }}"
                                                        data-line2="{{ $address->address_line2 ?? '' }}"
                                                        data-barangay="{{ $address->barangay }}"
                                                        data-city="{{ $address->city }}"
                                                        data-province="{{ $address->province }}"
                                                        data-postal="{{ $address->postal_code }}"
                                                        data-instructions="{{ $address->delivery_instructions ?? '' }}">
                                                    {{ ucfirst($address->address_type) }}: {{ $address->address_line1 }}, {{ $address->city }}
                                                    @if($address->is_default)
                                                        <span class="badge bg-primary ms-2">Default</span>
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Selecting an address will auto-fill the fields below</small>
                                    </div>
                                </div>
                            @else
                                <!-- User has no saved addresses -->
                                <div class="mb-4">
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                        You don't have any saved addresses yet. Please enter your delivery address below.
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Recipient Information -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Recipient Name <span class="text-danger">*</span></label>
                                    <input type="text" name="recipient_name" id="recipient_name" class="form-control @error('recipient_name') is-invalid @enderror" 
                                           value="{{ old('recipient_name', auth()->user()->first_name . ' ' . auth()->user()->last_name) }}" 
                                           placeholder="Full name of recipient" required>
                                    @error('recipient_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Recipient Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="recipient_phone" id="recipient_phone" class="form-control @error('recipient_phone') is-invalid @enderror" 
                                           value="{{ old('recipient_phone') }}" 
                                           placeholder="e.g., 09123456789" required>
                                    @error('recipient_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Address Fields -->
                            <div class="mb-3">
                                <label class="form-label">Street Address / Building / Unit <span class="text-danger">*</span></label>
                                <input type="text" name="address_line1" id="address_line1" class="form-control @error('address_line1') is-invalid @enderror" 
                                       value="{{ old('address_line1') }}" 
                                       placeholder="e.g., 123 Mabini St, Unit 45" required>
                                @error('address_line1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Address Line 2 (Optional)</label>
                                <input type="text" name="address_line2" id="address_line2" class="form-control @error('address_line2') is-invalid @enderror" 
                                       value="{{ old('address_line2') }}" 
                                       placeholder="e.g., Landmark, Subdivision">
                                @error('address_line2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Barangay <span class="text-danger">*</span></label>
                                    <input type="text" name="barangay" id="barangay" class="form-control @error('barangay') is-invalid @enderror" 
                                           value="{{ old('barangay') }}" 
                                           placeholder="e.g., Barangay San Jose" required>
                                    @error('barangay')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label">City / Municipality <span class="text-danger">*</span></label>
                                    <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" 
                                           value="{{ old('city') }}" 
                                           placeholder="e.g., Manila" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label">Province <span class="text-danger">*</span></label>
                                    <input type="text" name="province" id="province" class="form-control @error('province') is-invalid @enderror" 
                                           value="{{ old('province') }}" 
                                           placeholder="e.g., Metro Manila" required>
                                    @error('province')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control @error('postal_code') is-invalid @enderror" 
                                           value="{{ old('postal_code') }}" 
                                           placeholder="e.g., 1000" required>
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Delivery Instructions -->
                            <div class="mb-3">
                                <label class="form-label">Delivery Instructions (Optional)</label>
                                <textarea name="delivery_instructions" id="delivery_instructions" class="form-control" rows="2" 
                                          placeholder="e.g., Leave at gate, Call upon arrival">{{ old('delivery_instructions') }}</textarea>
                            </div>
                            
                            <!-- Option to save address for future use -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="save_address" class="form-check-input" value="1" id="save_address" checked>
                                    <label class="form-check-label" for="save_address">
                                        Save this address to my profile for future orders
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-credit-card me-2" style="color: var(--primary);"></i>
                                Payment Method
                            </h5>
                            
                            <div class="payment-methods">
                                <label class="payment-method" onclick="selectPaymentMethod('cod', this)">
                                    <input type="radio" name="payment_method" value="cod" class="d-none" {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>
                                    <i class="bi bi-cash"></i>
                                    <span>Cash on Delivery</span>
                                    <small>Pay when you receive</small>
                                </label>
                                
                                <label class="payment-method" onclick="selectPaymentMethod('gcash', this)">
                                    <input type="radio" name="payment_method" value="gcash" class="d-none" {{ old('payment_method') == 'gcash' ? 'checked' : '' }}>
                                    <img src="{{ asset('img/gcash-logo_brandlogos.net_kiaqh.png') }}" alt="GCash" class="payment-logo">
                                    <span>GCash</span>
                                    <small>Pay via GCash</small>
                                </label>
                                
                                <label class="payment-method" onclick="selectPaymentMethod('paymaya', this)">
                                    <input type="radio" name="payment_method" value="paymaya" class="d-none" {{ old('payment_method') == 'paymaya' ? 'checked' : '' }}>
                                    <img src="{{ asset('img/PayMaya_Logo.png') }}" alt="GCash" class="payment-logo">
                                    <span>PayMaya</span>
                                    <small>Pay via PayMaya</small>
                                </label>
                                
                                <label class="payment-method" onclick="selectPaymentMethod('card', this)">
                                    <input type="radio" name="payment_method" value="card" class="d-none" {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                                    <i class="bi bi-credit-card"></i>
                                    <span>Credit/Debit Card</span>
                                    <small>Visa/Mastercard</small>
                                </label>
                            </div>
                            @error('payment_method')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Order Notes -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-pencil me-2" style="color: var(--primary);"></i>
                                Order Notes (Optional)
                            </h5>
                            
                            <textarea name="notes" class="form-control" rows="3" 
                                      placeholder="Special instructions for delivery...">{{ old('notes') }}</textarea>
                        </div>
                    </form>
                </div>
                
                <!-- Order Summary -->
                <div class="order-summary">
                    <h5 class="summary-title">Your Order</h5>
                    
                    @foreach($cart->items as $item)
                    <div class="summary-item">
                        <div class="summary-item-image">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                            @else
                                <i class="bi bi-box"></i>
                            @endif
                        </div>
                        <div class="summary-item-details">
                            <div class="summary-item-name">{{ $item->product->name ?? 'Product' }}</div>
                            <div class="summary-item-meta">{{ $item->quantity }} x ₱{{ number_format($item->price, 2) }}</div>
                        </div>
                        <div class="summary-item-price">₱{{ number_format($item->subtotal, 2) }}</div>
                    </div>
                    @endforeach
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span class="fw-600">₱{{ number_format($cart->subtotal, 2) }}</span>
                    </div>
                    
                    @if($cart->discount > 0)
                    <div class="summary-row">
                        <span>Discount</span>
                        <span class="text-success">-₱{{ number_format($cart->discount, 2) }}</span>
                    </div>
                    @endif
                    
                    <div class="summary-row">
                        <span>Shipping Fee</span>
                        <span>₱50.00</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span class="text-primary" id="totalAmount">₱{{ number_format($cart->subtotal - ($cart->discount ?? 0) + 50, 2) }}</span>
                    </div>
                    
                    <button type="button" onclick="validateAndProceed()" class="place-order-btn">
                        <i class="bi bi-check-circle me-2"></i>Place Order
                    </button>
                    
                    <a href="{{ route('cart.index') }}" class="back-to-cart">
                        <i class="bi bi-arrow-left"></i> Back to Cart
                    </a>
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
        let selectedPaymentMethod = 'cod';
        const totalAmount = {{ $cart->subtotal - ($cart->discount ?? 0) + 50 }};
        
        // Initialize Bootstrap modals
        const ewalletModal = new bootstrap.Modal(document.getElementById('ewalletModal'));
        const cardModal = new bootstrap.Modal(document.getElementById('cardModal'));
        
        // Format card number
        document.getElementById('cardNumber')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            if (value.length > 0) {
                value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
            }
            e.target.value = value;
        });
        
        // Format CVV
        document.getElementById('cvv')?.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0, 3);
        });
        
        // Format mobile number
        document.getElementById('mobileNumber')?.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0, 11);
        });
        
        // Payment method selection
        function selectPaymentMethod(method, element) {
            selectedPaymentMethod = method;
            
            // Update UI - remove selected class from all
            document.querySelectorAll('.payment-method').forEach(m => {
                m.classList.remove('selected');
            });
            
            // Add selected class to clicked element
            element.classList.add('selected');
            
            // Check the radio button
            const radio = element.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
        }
        
        // Validate and proceed
        function validateAndProceed() {
            // Check if form is valid
            const form = document.getElementById('checkoutForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // Show appropriate modal based on payment method
            switch(selectedPaymentMethod) {
                case 'gcash':
                case 'paymaya':
                    showEwalletModal(selectedPaymentMethod);
                    break;
                case 'card':
                    showCardModal();
                    break;
                default:
                    // For COD, submit form directly
                    form.submit();
            }
        }
        
        // Show e-wallet modal
        function showEwalletModal(method) {
            const title = method === 'gcash' ? 'GCash' : 'PayMaya';
            document.getElementById('ewalletModalLabel').textContent = title + ' Payment';
            document.getElementById('ewalletAmount').textContent = '₱' + totalAmount.toFixed(2);
            document.getElementById('mobileNumber').value = '';
            
            // Change modal icon based on method
            const ewalletIcon = document.getElementById('ewalletIcon');
            if (method === 'gcash') {
                ewalletIcon.src = '{{ asset("img/gcash-logo_brandlogos.net_kiaqh.png") }}';
                ewalletIcon.alt = 'GCash';
            } else {
                // For PayMaya, you can set a different image or keep the same
                ewalletIcon.src = '{{ asset("img/32049_46b3906d33.png") }}'; // Change to PayMaya logo if available
                ewalletIcon.alt = 'PayMaya';
            }
            
            ewalletModal.show();
        }
        
        // Show card modal
        function showCardModal() {
            document.getElementById('cardModalLabel').textContent = 'Card Payment';
            document.getElementById('cardAmount').textContent = '₱' + totalAmount.toFixed(2);
            // Clear form
            document.getElementById('cardNumber').value = '';
            document.getElementById('cardholderName').value = '';
            document.getElementById('expiryMonth').value = '';
            document.getElementById('expiryYear').value = '';
            document.getElementById('cvv').value = '';
            cardModal.show();
        }
        
        // Confirm e-wallet payment
        function confirmEwalletPayment() {
            const mobileNumber = document.getElementById('mobileNumber').value;
            
            if (!mobileNumber || mobileNumber.length < 11) {
                alert('Please enter a valid mobile number');
                return;
            }
            
            // Here you would integrate with actual payment gateway
            // For now, we'll just submit the form
            ewalletModal.hide();
            document.getElementById('checkoutForm').submit();
        }
        
        // Confirm card payment
        function confirmCardPayment() {
            const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
            const cardholderName = document.getElementById('cardholderName').value;
            const expiryMonth = document.getElementById('expiryMonth').value;
            const expiryYear = document.getElementById('expiryYear').value;
            const cvv = document.getElementById('cvv').value;
            
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
            
            // Here you would integrate with actual payment gateway
            // For now, we'll just submit the form
            cardModal.hide();
            document.getElementById('checkoutForm').submit();
        }
        
        // Payment method selection for initial load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.payment-method').forEach(method => {
                const radio = method.querySelector('input[type="radio"]');
                if (radio && radio.checked) {
                    method.classList.add('selected');
                    selectedPaymentMethod = radio.value;
                }
            });
            
            // Add click event listeners as backup
            document.querySelectorAll('.payment-method').forEach(method => {
                method.addEventListener('click', function(e) {
                    // Prevent event from firing twice if onclick is already set
                    if (!e.isTrusted) return;
                    
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) {
                        selectedPaymentMethod = radio.value;
                        
                        document.querySelectorAll('.payment-method').forEach(m => {
                            m.classList.remove('selected');
                        });
                        this.classList.add('selected');
                        radio.checked = true;
                    }
                });
            });
        });
        
        // Saved address selection
        const savedAddress = document.getElementById('savedAddress');
        if (savedAddress) {
            savedAddress.addEventListener('change', function() {
                if (this.value) {
                    const selected = this.options[this.selectedIndex];
                    
                    // Fill in all the fields
                    document.getElementById('recipient_name').value = selected.dataset.name || '';
                    document.getElementById('recipient_phone').value = selected.dataset.phone || '';
                    document.getElementById('address_line1').value = selected.dataset.line1 || '';
                    document.getElementById('address_line2').value = selected.dataset.line2 || '';
                    document.getElementById('barangay').value = selected.dataset.barangay || '';
                    document.getElementById('city').value = selected.dataset.city || '';
                    document.getElementById('province').value = selected.dataset.province || '';
                    document.getElementById('postal_code').value = selected.dataset.postal || '';
                    document.getElementById('delivery_instructions').value = selected.dataset.instructions || '';
                } else {
                    // Clear the form when "Enter new address" is selected
                    document.getElementById('recipient_name').value = '{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}';
                    document.getElementById('recipient_phone').value = '';
                    document.getElementById('address_line1').value = '';
                    document.getElementById('address_line2').value = '';
                    document.getElementById('barangay').value = '';
                    document.getElementById('city').value = '';
                    document.getElementById('province').value = '';
                    document.getElementById('postal_code').value = '';
                    document.getElementById('delivery_instructions').value = '';
                }
            });
        }
    </script>
</body>
</html>