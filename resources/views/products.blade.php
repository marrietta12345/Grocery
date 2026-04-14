<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products | Grocery Mart</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @php use Illuminate\Support\Str; @endphp
    
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
            background: linear-gradient(135deg, var(--slate-50) 0%, #ffffff 100%);
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
            position: relative;
            padding: 2rem;
            background: linear-gradient(135deg, var(--primary-light), #ffffff);
            border-radius: 24px;
            border: 1px solid rgba(40, 167, 69, 0.2);
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
        
        /* Filter Sidebar */
        .filter-sidebar {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            border: 1px solid var(--slate-200);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            position: sticky;
            top: 2rem;
        }
        
        .filter-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--slate-200);
            color: var(--dark);
        }
        
        .filter-section {
            margin-bottom: 1.5rem;
        }
        
        .filter-section h6 {
            font-weight: 600;
            color: var(--slate-600);
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .category-filter-item {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 0.3rem;
        }
        
        .category-filter-item:hover {
            background: var(--slate-100);
            transform: translateX(5px);
        }
        
        .category-filter-item.active {
            background: rgba(40, 167, 69, 0.1);
            color: var(--primary);
            font-weight: 600;
        }
        
        .category-filter-item input[type="radio"] {
            margin-right: 0.8rem;
            accent-color: var(--primary);
            width: 18px;
            height: 18px;
        }
        
        .category-filter-item label {
            cursor: pointer;
            flex: 1;
        }
        
        .category-count {
            margin-left: auto;
            font-size: 0.75rem;
            background: var(--slate-100);
            padding: 0.2rem 0.6rem;
            border-radius: 40px;
            color: var(--slate-600);
        }
        
        .category-filter-item.active .category-count {
            background: var(--primary);
            color: white;
        }
        
        .price-inputs {
            display: flex;
            gap: 0.5rem;
        }
        
        .price-input {
            flex: 1;
            padding: 0.6rem;
            border: 1px solid var(--slate-200);
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .price-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        }
        
        .form-select {
            padding: 0.6rem;
            border: 1px solid var(--slate-200);
            border-radius: 8px;
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        }
        
        .btn-apply-filter {
            width: 100%;
            padding: 0.8rem;
            background: var(--dark);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
        }
        
        .btn-apply-filter:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }
        
        .btn-clear-filter {
            width: 100%;
            padding: 0.8rem;
            background: white;
            color: var(--slate-600);
            border: 1px solid var(--slate-200);
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 0.5rem;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .btn-clear-filter:hover {
            background: var(--slate-100);
            border-color: var(--slate-300);
        }
        
        /* Search Section */
        .search-filter-section {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--slate-200);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
        }
        
        .search-box {
            position: relative;
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
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            border-radius: 12px;
            border: 1px solid var(--slate-200);
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        }
        
        .results-count {
            background: white;
            padding: 0.8rem 1.2rem;
            border-radius: 40px;
            display: inline-block;
            border: 1px solid var(--slate-200);
            font-size: 0.9rem;
            color: var(--slate-600);
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
        }
        
        .results-count i {
            color: var(--primary);
            margin-right: 0.5rem;
        }
        
        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        .product-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(40, 167, 69, 0.1);
            border-color: var(--primary);
        }
        
        /* Simple View Indicator */
        .view-indicator {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            background: var(--dark);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
            z-index: 10;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .product-card:hover .view-indicator {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
        
        .product-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.3rem 0.8rem;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 2;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .badge-discount {
            background: var(--danger);
            color: white;
        }
        
        .badge-new {
            background: var(--info);
            color: white;
        }
        
        .badge-lowstock {
            background: var(--warning);
            color: white;
        }
        
        .badge-featured {
            background: var(--primary);
            color: white;
        }
        
        .product-image {
            width: 100%;
            aspect-ratio: 1 / 1;
            max-width: 250px;
            margin: 0 auto 1rem;
            background: var(--slate-100);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        
        .product-image i {
            font-size: 3rem;
            color: var(--primary);
        }
        
        /* Rating Stars */
        .product-rating {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            margin-bottom: 0.5rem;
        }
        
        .product-rating i {
            font-size: 0.85rem;
        }
        
        .product-rating .rating-number {
            font-size: 0.8rem;
            color: var(--slate-500);
            margin-left: 0.3rem;
        }
        
        .product-category {
            font-size: 0.8rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.3rem;
            text-transform: uppercase;
        }
        
        .product-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--slate-800);
            margin-bottom: 0.3rem;
        }
        
        .product-brand {
            font-size: 0.8rem;
            color: var(--slate-500);
            margin-bottom: 0.5rem;
        }
        
        .product-price-section {
            display: flex;
            align-items: baseline;
            gap: 0.8rem;
            margin-bottom: 1rem;
        }
        
        .product-price {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--dark);
        }
        
        .product-old-price {
            font-size: 0.9rem;
            color: var(--slate-400);
            text-decoration: line-through;
        }
        
        .product-stock {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--slate-600);
            margin-bottom: 1rem;
        }
        
        .stock-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        
        .stock-high {
            background: var(--primary);
        }
        
        .stock-medium {
            background: var(--warning);
        }
        
        .stock-low {
            background: var(--danger);
        }
        
        .btn-add-cart {
            width: 100%;
            padding: 0.8rem;
            border-radius: 12px;
            border: none;
            background: var(--dark);
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-add-cart:hover:not(:disabled) {
            background: var(--primary);
            transform: translateY(-2px);
        }
        
        .btn-add-cart:disabled {
            background: var(--slate-200);
            color: var(--slate-400);
            cursor: not-allowed;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 20px;
            border: 1px solid var(--slate-200);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
        }
        
        .empty-state i {
            font-size: 4rem;
            color: var(--slate-300);
            margin-bottom: 1.5rem;
        }
        
        .empty-state h5 {
            color: var(--slate-700);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .empty-state p {
            color: var(--slate-500);
            margin-bottom: 2rem;
        }
        
        .btn-clear-filters {
            background: var(--dark);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
        }
        
        .btn-clear-filters:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
            color: white;
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
            background: white;
        }
        
        .page-link:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
        }
        
        .page-item.active .page-link {
            background: var(--dark);
            border-color: var(--dark);
            color: white;
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

        .toast-close {
            background: none;
            border: none;
            color: var(--slate-400);
            cursor: pointer;
            font-size: 1.2rem;
            transition: color 0.3s;
        }

        .toast-close:hover {
            color: var(--dark);
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
            transform: translateX(5px);
            display: inline-block;
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
            .filter-sidebar {
                position: static;
                margin-bottom: 2rem;
            }
            
            .user-info {
                display: none;
            }
            
            .footer {
                text-align: center;
            }
            
            .product-image {
                max-width: 200px;
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
                        <a class="nav-link active" href="{{ route('products.index') }}">
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
                <h1>All Products</h1>
                <p>Browse our wide selection of fresh groceries</p>
            </div>

            <div class="row">
                <!-- Filter Sidebar -->
                <div class="col-lg-3">
                    <div class="filter-sidebar">
                        <h5 class="filter-title">
                            <i class="bi bi-funnel me-2" style="color: var(--primary);"></i>
                            Filter Products
                        </h5>

                        <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                            <!-- Categories -->
                            <div class="filter-section">
                                <h6>Categories</h6>
                                <div class="category-filter-item {{ !request('category') ? 'active' : '' }}">
                                    <input type="radio" name="category" value="" id="cat_all" 
                                           {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
                                    <label for="cat_all">All Categories</label>
                                    <span class="category-count">{{ $products->total() }}</span>
                                </div>

                                @foreach($categories as $category)
                                <div class="category-filter-item {{ request('category') == $category->slug ? 'active' : '' }}">
                                    <input type="radio" name="category" value="{{ $category->slug }}" id="cat_{{ $category->id }}"
                                           {{ request('category') == $category->slug ? 'checked' : '' }} onchange="this.form.submit()">
                                    <label for="cat_{{ $category->id }}">{{ $category->name }}</label>
                                    <span class="category-count">{{ $category->products_count }}</span>
                                </div>
                                @endforeach
                            </div>

                            <!-- Price Range -->
                            <div class="filter-section">
                                <h6>Price Range (₱)</h6>
                                <div class="price-inputs">
                                    <input type="number" class="price-input" name="min_price" placeholder="Min" 
                                           value="{{ request('min_price') }}" min="0" step="1">
                                    <input type="number" class="price-input" name="max_price" placeholder="Max" 
                                           value="{{ request('max_price') }}" min="0" step="1">
                                </div>
                            </div>

                            <!-- Sort -->
                            <div class="filter-section">
                                <h6>Sort By</h6>
                                <select name="sort" class="form-select" onchange="this.form.submit()">
                                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                </select>
                            </div>

                            <!-- Search (hidden) -->
                            <input type="hidden" name="search" value="{{ request('search') }}">

                            <!-- Action Buttons -->
                            <button type="submit" class="btn-apply-filter mt-3">
                                <i class="bi bi-search me-2"></i>Apply Filters
                            </button>
                            
                            @if(request()->anyFilled(['category', 'min_price', 'max_price', 'sort', 'search']))
                            <a href="{{ route('products.index') }}" class="btn-clear-filter">
                                <i class="bi bi-x-circle me-2"></i>Clear Filters
                            </a>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    <!-- Search Bar -->
                    <div class="search-filter-section">
                        <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                            <div class="col-md-8">
                                <div class="search-box">
                                    <i class="bi bi-search"></i>
                                    <input type="text" name="search" placeholder="Search products by name, brand, or description..." 
                                           value="{{ request('search') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn-apply-filter">Search</button>
                            </div>
                            
                            <!-- Preserve other filters -->
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                        </form>
                    </div>

                    <!-- Results Count -->
                    <div class="results-count">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                        Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                    </div>

                    <!-- Products Grid -->
                    <div class="products-grid" id="productsGrid">
                        @forelse($products as $product)
                        @php
                            $isNew = $product->created_at->diffInDays(now()) < 7;
                            $discountPercentage = $product->old_price && $product->old_price > $product->price 
                                ? round((($product->old_price - $product->price) / $product->old_price) * 100) 
                                : 0;
                            $averageRating = round($product->ratings()->avg('rating') ?? 0, 1);
                            $ratingCount = $product->ratings()->count();
                        @endphp
                        
                        <div class="product-card" onclick="window.location='{{ route('products.show', $product) }}'">
                            <!-- Simple View Indicator -->
                            <div class="view-indicator">View Details</div>
                            
                            @if($product->is_featured)
                                <div class="product-badge badge-featured">FEATURED</div>
                            @elseif($isNew)
                                <div class="product-badge badge-new">NEW</div>
                            @elseif($discountPercentage > 0)
                                <div class="product-badge badge-discount">-{{ $discountPercentage }}%</div>
                            @elseif($product->stock < 10 && $product->stock > 0)
                                <div class="product-badge badge-lowstock">Low Stock</div>
                            @endif
                            
                            <div class="product-image">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    @php
                                        $catName = strtolower($product->category->name ?? '');
                                    @endphp
                                    @if(str_contains($catName, 'fruit') || str_contains($catName, 'vegetable'))
                                        <i class="bi bi-apple"></i>
                                    @elseif(str_contains($catName, 'dairy') || str_contains($catName, 'milk') || str_contains($catName, 'cheese'))
                                        <i class="bi bi-cup-straw"></i>
                                    @elseif(str_contains($catName, 'beverage') || str_contains($catName, 'drink'))
                                        <i class="bi bi-cup"></i>
                                    @elseif(str_contains($catName, 'meat') || str_contains($catName, 'seafood') || str_contains($catName, 'fish') || str_contains($catName, 'chicken'))
                                        <i class="bi bi-fish"></i>
                                    @else
                                        <i class="bi bi-box"></i>
                                    @endif
                                @endif
                            </div>
                            
                            <div class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                            
                            <!-- Product Rating Stars -->
                            @if($ratingCount > 0)
                            <div class="product-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                        <i class="bi bi-star-half text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-muted"></i>
                                    @endif
                                @endfor
                                <span class="rating-number">({{ $ratingCount }})</span>
                            </div>
                            @endif
                            
                            <div class="product-title">{{ $product->name }}</div>
                            @if($product->brand)
                                <div class="product-brand">{{ $product->brand }}</div>
                            @endif
                            
                            <div class="product-price-section">
                                <span class="product-price">₱{{ number_format($product->price, 2) }}</span>
                                @if($product->old_price)
                                    <span class="product-old-price">₱{{ number_format($product->old_price, 2) }}</span>
                                @endif
                            </div>
                            
                            <div class="product-stock">
                                @php
                                    $stockClass = $product->stock > 10 ? 'stock-high' : ($product->stock > 0 ? 'stock-medium' : 'stock-low');
                                    $stockText = $product->stock > 0 ? "In Stock ({$product->stock} units)" : "Out of Stock";
                                @endphp
                                <span class="stock-indicator {{ $stockClass }}"></span>
                                <span>{{ $stockText }}</span>
                            </div>
                            
                            <button class="btn-add-cart add-to-cart-btn" 
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->price }}"
                                    onclick="event.stopPropagation();"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                <i class="bi bi-cart-plus me-2"></i>Add to Cart
                            </button>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="bi bi-emoji-frown"></i>
                                <h5>No Products Found</h5>
                                <p>We couldn't find any products matching your criteria.</p>
                                <a href="{{ route('products.index') }}" class="btn-clear-filters">
                                    <i class="bi bi-arrow-repeat me-2"></i>Clear All Filters
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $products->withQueryString()->links() }}
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
        // Add to Cart functionality
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (this.disabled) return;
                
                const productId = this.dataset.productId;
                const button = this;
                
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Adding...';
                button.disabled = true;
                
                fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Success!', data.message, 'success');
                        updateCartCount(data.cart_count);
                        
                        button.innerHTML = '<i class="bi bi-check-lg me-2"></i>Added!';
                        button.style.background = 'var(--primary)';
                        
                        setTimeout(() => {
                            button.innerHTML = originalText;
                            button.style.background = 'var(--dark)';
                            button.disabled = false;
                        }, 2000);
                    } else {
                        showToast('Error!', data.message, 'error');
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error!', 'Failed to add to cart', 'error');
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            });
        });

        // Toast notification function
        function showToast(title, message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            
            const icon = type === 'success' ? 'check-circle-fill' : 'exclamation-circle-fill';
            
            toast.innerHTML = `
                <i class="bi bi-${icon}"></i>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="this.parentElement.remove()">
                    <i class="bi bi-x"></i>
                </button>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 5000);
        }

        // Update cart count
        function updateCartCount(count) {
            const badge = document.getElementById('cartCountBadge');
            if (badge) {
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        }

        // Get initial cart count
        function fetchCartCount() {
            fetch('{{ route("cart.count") }}', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                updateCartCount(data.count);
            })
            .catch(error => console.error('Error fetching cart count:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchCartCount();
        });
    </script>
</body>
</html>