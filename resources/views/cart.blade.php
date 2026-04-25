<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | Grocery Mart</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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
            min-height: calc(100vh - 200px);
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
        
        /* Cart Styles */
        .cart-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        
        .cart-items {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
        }
        
        .cart-item {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 1.5rem;
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item-image {
            width: 100px;
            height: 100px;
            background: var(--slate-100);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .cart-item-image i {
            font-size: 2.5rem;
            color: var(--primary);
        }
        
        .cart-item-details h4 {
            font-weight: 700;
            margin-bottom: 0.3rem;
        }
        
        .cart-item-brand {
            color: var(--slate-500);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .cart-item-price {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.2rem;
        }
        
        .cart-item-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 1rem;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--slate-100);
            padding: 0.3rem;
            border-radius: 40px;
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            background: white;
            color: var(--dark);
            font-weight: 700;
            transition: all 0.3s;
        }
        
        .quantity-btn:hover {
            background: var(--primary);
            color: white;
        }
        
        .quantity-input {
            width: 40px;
            text-align: center;
            border: none;
            background: transparent;
            font-weight: 600;
        }
        
        .remove-btn {
            color: var(--danger);
            background: none;
            border: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        
        .remove-btn:hover {
            color: var(--dark);
        }
        
        /* Cart Summary */
        .cart-summary {
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
        
        .promo-section {
            margin: 1.5rem 0;
            padding: 1rem 0;
            border-top: 1px solid var(--slate-200);
            border-bottom: 1px solid var(--slate-200);
        }
        
        .promo-input {
            display: flex;
            gap: 0.5rem;
        }
        
        .promo-input input {
            flex: 1;
            height: 45px;
            border-radius: 8px;
            border: 1px solid var(--slate-200);
            padding: 0 1rem;
        }
        
        .promo-input button {
            background: var(--dark);
            color: white;
            border: none;
            padding: 0 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .promo-input button:hover {
            background: var(--primary);
        }
        
        .promo-applied {
            background: rgba(40, 167, 69, 0.1);
            color: var(--primary);
            padding: 0.8rem;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .promo-applied .remove-promo {
            color: var(--danger);
            cursor: pointer;
            background: none;
            border: none;
        }
        
        .checkout-btn {
            width: 100%;
            background: var(--dark);
            color: white;
            border: none;
            height: 52px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        
        .checkout-btn:hover {
            background: var(--primary);
            transform: translateY(-2px);
            color: white;
        }
        
        .continue-shopping {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--slate-500);
            text-decoration: none;
        }
        
        .continue-shopping:hover {
            color: var(--primary);
        }
        
        .empty-cart {
            text-align: center;
            padding: 3rem;
        }
        
        .empty-cart i {
            font-size: 5rem;
            color: var(--slate-300);
            margin-bottom: 1rem;
        }
        
        .empty-cart h3 {
            color: var(--slate-600);
            margin-bottom: 1rem;
        }
        
        .empty-cart .btn-shop {
            background: var(--dark);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        
        .empty-cart .btn-shop:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }
        
        /* Cart Count Badge */
        .cart-count-badge {
            position: absolute;
            top: 0;
            right: -5px;
            background: var(--danger);
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            min-width: 18px;
            text-align: center;
        }

        .nav-item.position-relative {
            position: relative;
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast-notification {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 4px solid var(--primary);
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 300px;
            animation: slideIn 0.3s ease;
        }

        .toast-notification.error {
            border-left-color: var(--danger);
        }

        .toast-notification i {
            font-size: 1.5rem;
        }

        .toast-notification.success i {
            color: var(--primary);
        }

        .toast-notification.error i {
            color: var(--danger);
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 700;
            margin-bottom: 0.2rem;
        }

        .toast-message {
            font-size: 0.85rem;
            color: var(--slate-600);
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Footer */
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
        
        @media (max-width: 768px) {
            .cart-container {
                grid-template-columns: 1fr;
            }
            
            .cart-item {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .cart-item-image {
                margin: 0 auto;
            }
            
            .cart-item-actions {
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <!-- Toast Notifications Container -->
    <div class="toast-container" id="toastContainer"></div>

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
                    <li class="nav-item position-relative">
                        <a class="nav-link active" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart me-1"></i> Cart
                            <span class="cart-count-badge" id="cartCountBadge" style="display: none;">0</span>
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
            <!-- Page Header -->
            <div class="page-header">
                <h1>Shopping Cart</h1>
                <p>Review and manage your items before checkout</p>
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
            
            @if(isset($cart) && $cart && $cart->items->count() > 0)
            <div class="cart-container">
                <!-- Cart Items -->
                <div class="cart-items">
                    @foreach($cart->items as $item)
                    <div class="cart-item">
                        <div class="cart-item-image">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                            @else
                                <i class="bi bi-box"></i>
                            @endif
                        </div>
                        
                        <div class="cart-item-details">
                            <h4>{{ $item->product->name ?? 'Product' }}</h4>
                            <div class="cart-item-brand">{{ $item->product->brand ?? 'Unknown' }}</div>
                            <div class="cart-item-price">₱{{ number_format($item->price, 2) }}</div>
                        </div>
                        
                        <div class="cart-item-actions">
                            <div class="quantity-control">
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                    <button type="submit" class="quantity-btn" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                </form>
                                
                                <span class="quantity-input">{{ $item->quantity }}</span>
                                
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                    <button type="submit" class="quantity-btn">+</button>
                                </form>
                            </div>
                            
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-cart-x"></i> Clear Cart
                            </button>
                        </form>
                        
                        <span class="text-muted">
                            Total items: <strong>{{ $cart->items->sum('quantity') }}</strong>
                        </span>
                    </div>
                </div>
                
                <!-- Cart Summary -->
                <div class="cart-summary">
                    <h5 class="summary-title">Order Summary</h5>
                    
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
                        <span class="text-primary">₱{{ number_format($cart->total + 50, 2) }}</span>
                    </div>
                    
                    <!-- Promo Code Section -->
                    <div class="promo-section">
                        @if($cart->promo_code)
                            <div class="promo-applied">
                                <span>
                                    <i class="bi bi-tag-fill"></i> 
                                    Promo "{{ $cart->promo_code }}" applied
                                </span>
                                <form action="{{ route('cart.remove-promo') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="remove-promo">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('cart.apply-promo') }}" method="POST" class="promo-input">
                                @csrf
                                <input type="text" name="promo_code" placeholder="Enter promo code">
                                <button type="submit">Apply</button>
                            </form>
                        @endif
                    </div>
                    
                    <a href="{{ route('order.checkout') }}" class="checkout-btn">
                        <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                    </a>
                    
                    <a href="{{ route('dashboard') }}#products" class="continue-shopping">
                        <i class="bi bi-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
            @else
            <!-- Empty Cart -->
            <div class="empty-cart">
                <i class="bi bi-cart"></i>
                <h3>Your cart is empty</h3>
                <p class="text-muted">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('dashboard') }}#products" class="btn-shop">
                    <i class="bi bi-shop"></i> Start Shopping
                </a>
            </div>
            @endif
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
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Get cart count from server
        function updateCartCount() {
            fetch('{{ route("cart.count") }}', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('cartCountBadge');
                if (badge) {
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Error fetching cart count:', error));
        }

        // Update cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });
    </script>
</body>
</html>