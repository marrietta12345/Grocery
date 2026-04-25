<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions | Grocery Mart</title>
    
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
            margin-bottom: 3rem;
            text-align: center;
        }
        
        .page-header h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .page-header p {
            color: var(--slate-500);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Search Box */
        .search-box {
            position: relative;
            max-width: 500px;
            margin: 0 auto 3rem;
        }
        
        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-400);
            font-size: 1.2rem;
        }
        
        .search-box input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border-radius: 50px;
            border: 1px solid var(--slate-200);
            font-size: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 5px 20px rgba(40, 167, 69, 0.15);
        }
        
        /* Category Tabs */
        .faq-categories {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        
        .category-btn {
            padding: 0.6rem 1.5rem;
            border-radius: 40px;
            font-weight: 600;
            background: white;
            border: 1px solid var(--slate-200);
            color: var(--slate-600);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .category-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        
        .category-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        /* FAQ Items */
        .faq-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
            margin-bottom: 2rem;
        }
        
        .faq-category-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary);
            display: inline-block;
        }
        
        .faq-item {
            margin-bottom: 1rem;
            border: 1px solid var(--slate-200);
            border-radius: 12px;
            overflow: hidden;
        }
        
        .faq-question {
            background: var(--slate-50);
            padding: 1.2rem;
            font-weight: 600;
            color: var(--slate-800);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .faq-question:hover {
            background: var(--slate-100);
        }
        
        .faq-question i {
            transition: transform 0.3s ease;
        }
        
        .faq-question[aria-expanded="true"] i {
            transform: rotate(180deg);
        }
        
        .faq-answer {
            padding: 1.2rem;
            background: white;
            color: var(--slate-600);
            line-height: 1.6;
        }
        
        /* Still Need Help */
        .help-section {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            border-radius: 20px;
            padding: 3rem;
            color: white;
            text-align: center;
            margin-top: 3rem;
        }
        
        .help-section h2 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .help-section p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        .help-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-light-custom {
            background: white;
            color: var(--dark);
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .btn-light-custom:hover {
            background: var(--slate-100);
            transform: translateY(-2px);
            color: var(--dark);
        }
        
        .btn-outline-light {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .btn-outline-light:hover {
            background: white;
            color: var(--dark);
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
            .help-buttons {
                flex-direction: column;
            }
            
            .faq-categories {
                flex-direction: column;
                align-items: stretch;
            }
            
            .category-btn {
                text-align: center;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar (Copy the updated navbar from Step 3) -->
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
                        <a class="nav-link" href="{{ route('cart.index') }}">
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
                            <a class="dropdown-item active" href="{{ route('faq') }}">
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
                <h1>Frequently Asked Questions</h1>
                <p>Find answers to common questions about ordering, delivery, payments, and more</p>
            </div>
            
            <!-- Search Box -->
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchFAQ" placeholder="Search for answers...">
            </div>
            
            <!-- Category Tabs -->
            <div class="faq-categories">
                <button class="category-btn active" onclick="filterCategory('all')">All</button>
                <button class="category-btn" onclick="filterCategory('orders')">Orders</button>
                <button class="category-btn" onclick="filterCategory('delivery')">Delivery</button>
                <button class="category-btn" onclick="filterCategory('payments')">Payments</button>
                <button class="category-btn" onclick="filterCategory('returns')">Returns</button>
                <button class="category-btn" onclick="filterCategory('account')">Account</button>
                <button class="category-btn" onclick="filterCategory('products')">Products</button>
            </div>
            
            <!-- Orders FAQ -->
            <div class="faq-section" data-category="orders">
                <h3 class="faq-category-title">Orders</h3>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false">
                        How do I place an order?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq1">
                        <div class="faq-answer">
                            To place an order, simply browse our products, add items to your cart, and proceed to checkout. You'll need to provide your delivery address and choose a payment method. Once confirmed, you'll receive an order confirmation email.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false">
                        Can I modify or cancel my order?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq2">
                        <div class="faq-answer">
                            You can modify or cancel your order within 30 minutes of placing it, as long as it hasn't been processed for delivery. Go to your Orders page and click "Modify Order" or "Cancel Order". After 30 minutes, please contact our support team for assistance.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false">
                        How will I know if my order is confirmed?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq3">
                        <div class="faq-answer">
                            You'll receive an order confirmation email and SMS once your order is successfully placed. You can also check your order status in the "Orders" section of your account dashboard.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false">
                        How do I track my order?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq4">
                        <div class="faq-answer">
                            Once your order is out for delivery, you'll receive a tracking link via SMS and email. You can also track your order in real-time through your account dashboard under "My Orders".
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Delivery FAQ -->
            <div class="faq-section" data-category="delivery">
                <h3 class="faq-category-title">Delivery</h3>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false">
                        How long does delivery take?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq5">
                        <div class="faq-answer">
                            Standard delivery takes 1-3 business days within Metro Manila. Provincial deliveries may take 3-5 business days. Express delivery is available for select areas with delivery within 24 hours.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq6" aria-expanded="false">
                        What are the delivery fees?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq6">
                        <div class="faq-answer">
                            Delivery fees vary based on your location and order total. Metro Manila deliveries start at ₱50. Free delivery is available for orders above ₱1,500. You can see the exact delivery fee at checkout before placing your order.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq7" aria-expanded="false">
                        Do you deliver to my area?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq7">
                        <div class="faq-answer">
                            We currently deliver to Metro Manila and select provinces. Enter your address at checkout to check if we deliver to your area. We're continuously expanding our delivery coverage.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq8" aria-expanded="false">
                        Can I schedule my delivery?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq8">
                        <div class="faq-answer">
                            Yes! During checkout, you can choose your preferred delivery date and time slot. Options include morning (8am-12pm), afternoon (12pm-5pm), and evening (5pm-9pm) deliveries.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payments FAQ -->
            <div class="faq-section" data-category="payments">
                <h3 class="faq-category-title">Payments</h3>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq9" aria-expanded="false">
                        What payment methods do you accept?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq9">
                        <div class="faq-answer">
                            We accept multiple payment methods: Cash on Delivery (COD), GCash, PayMaya, credit/debit cards (Visa, Mastercard), and bank transfers. All payments are secure and encrypted.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq10" aria-expanded="false">
                        Is it safe to use my credit card?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq10">
                        <div class="faq-answer">
                            Absolutely. We use industry-standard SSL encryption to protect your payment information. We do not store your credit card details on our servers. All transactions are processed through secure payment gateways.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq11" aria-expanded="false">
                        Do you offer discounts or promo codes?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq11">
                        <div class="faq-answer">
                            Yes! We regularly offer promotions and discounts. You can apply promo codes at checkout. Subscribe to our newsletter to receive updates on the latest deals and exclusive offers.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq12" aria-expanded="false">
                        When will I be charged for my order?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq12">
                        <div class="faq-answer">
                            For credit card and e-wallet payments, you'll be charged immediately when you place your order. For Cash on Delivery, you'll pay the delivery rider upon receipt of your items.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Returns FAQ -->
            <div class="faq-section" data-category="returns">
                <h3 class="faq-category-title">Returns & Refunds</h3>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq13" aria-expanded="false">
                        What is your return policy?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq13">
                        <div class="faq-answer">
                            You can request a return within 7 days of delivery for damaged items, wrong items received, or quality issues. Perishable items must be reported within 24 hours of delivery.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq14" aria-expanded="false">
                        How do I request a return?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq14">
                        <div class="faq-answer">
                            Go to your Orders page, find the order, and click "Return Item". Fill out the return form with the reason and upload photos if necessary. Our team will review your request and contact you within 24 hours.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq15" aria-expanded="false">
                        How long does a refund take?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq15">
                        <div class="faq-answer">
                            Once your return is approved, refunds are processed within 3-5 business days. The amount will be credited back to your original payment method. For COD orders, refunds are made via bank transfer or GCash.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq16" aria-expanded="false">
                        Can I exchange an item instead of returning it?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq16">
                        <div class="faq-answer">
                            Currently, we process returns and refunds rather than direct exchanges. You can return the item for a refund and place a new order for the correct item. This ensures faster processing.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Account FAQ -->
            <div class="faq-section" data-category="account">
                <h3 class="faq-category-title">Account</h3>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq17" aria-expanded="false">
                        How do I create an account?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq17">
                        <div class="faq-answer">
                            Click "Sign Up" on the login page and fill in your details: first name, last name, email, and password. You can also register using your Google account for faster access.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq18" aria-expanded="false">
                        I forgot my password. What should I do?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq18">
                        <div class="faq-answer">
                            Click "Forgot Password" on the login page and enter your email address. We'll send you a password reset link. Follow the instructions to create a new password.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq19" aria-expanded="false">
                        How do I update my profile information?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq19">
                        <div class="faq-answer">
                            Go to "My Profile" from the dropdown menu. You can update your name, email, and other personal information there. To change your password, go to "Settings" in your profile.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq20" aria-expanded="false">
                        How do I add or change my delivery addresses?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq20">
                        <div class="faq-answer">
                            Go to "My Profile" and scroll to the "Saved Addresses" section. Click "Add New Address" to add a new delivery address. You can also edit or delete existing addresses and set a default address.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Products FAQ -->
            <div class="faq-section" data-category="products">
                <h3 class="faq-category-title">Products</h3>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq21" aria-expanded="false">
                        Are your products fresh?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq21">
                        <div class="faq-answer">
                            Yes! We source our products daily from trusted suppliers and farms. Produce is delivered fresh to our warehouse and dispatched within 24 hours. We have strict quality control measures in place.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq22" aria-expanded="false">
                        Do you offer organic products?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq22">
                        <div class="faq-answer">
                            Yes, we have a dedicated "Organic" section with certified organic fruits, vegetables, dairy, and pantry items. Look for the organic badge on product pages.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq23" aria-expanded="false">
                        What if an item is out of stock?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq23">
                        <div class="faq-answer">
                            If an item in your cart is out of stock, we'll notify you at checkout. You can choose to remove the item or wait for it to be restocked. You can also set up "Back in Stock" alerts for your favorite products.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq24" aria-expanded="false">
                        Can I request a product that's not listed?
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="faq24">
                        <div class="faq-answer">
                            Yes! We love hearing from our customers. Use our Contact Form to suggest products you'd like to see in our store. We regularly update our inventory based on customer requests.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Still Need Help -->
            <div class="help-section">
                <h2>Still have questions?</h2>
                <p>Can't find what you're looking for? Our support team is here to help!</p>
                <div class="help-buttons">
                    <a href="{{ route('contact') }}" class="btn-light-custom">
                        <i class="bi bi-headset me-2"></i>Contact Support
                    </a>
                    <a href="#" class="btn-outline-light" onclick="alert('Live chat coming soon! Please use email or phone for now.')">
                        <i class="bi bi-chat-dots me-2"></i>Live Chat
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
        // Filter FAQ by category
        function filterCategory(category) {
            // Update active button
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Filter sections
            const sections = document.querySelectorAll('.faq-section');
            sections.forEach(section => {
                if (category === 'all' || section.dataset.category === category) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        }
        
        // Search functionality
        document.getElementById('searchFAQ').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                
                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide sections based on visible items
            const sections = document.querySelectorAll('.faq-section');
            sections.forEach(section => {
                const visibleItems = section.querySelectorAll('.faq-item[style="display: block;"]').length;
                
                if (visibleItems === 0 && searchTerm !== '') {
                    section.style.display = 'none';
                } else {
                    section.style.display = 'block';
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (alert) {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);
    </script>
</body>
</html>