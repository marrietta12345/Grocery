<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | Grocery Mart</title>
    
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
        
        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.2rem;
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 8px;
            color: var(--slate-600);
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }
        
        .back-button:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
            transform: translateX(-3px);
        }
        
        .back-button i {
            margin-right: 0.4rem;
            font-size: 1rem;
        }
        
        /* Breadcrumb */
        .breadcrumb {
            background: white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
            margin-bottom: 0;
        }
        
        .breadcrumb-item {
            font-size: 0.9rem;
        }
        
        .breadcrumb-item a {
            color: var(--primary);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .breadcrumb-item a:hover {
            color: var(--primary-dark);
            text-decoration: underline !important;
        }
        
        .breadcrumb-item.active {
            color: var(--slate-600);
            font-weight: 500;
        }
        
        /* Product Detail */
        .product-detail {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
            margin-bottom: 3rem;
        }
        
        .product-gallery {
            border-radius: 16px;
            overflow: hidden;
            background: var(--slate-100);
            border: 1px solid var(--slate-200);
            width: 100%;
            max-width: 400px;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin: 0 auto;
            transition: all 0.3s ease;
        }
        
        .product-gallery:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(40, 167, 69, 0.1);
            border-color: var(--primary);
        }
        
        .product-gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .product-gallery:hover img {
            transform: scale(1.05);
        }
        
        .product-gallery .placeholder-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }
        
        .product-gallery .placeholder-icon i {
            font-size: 5rem;
            color: var(--primary);
            opacity: 0.5;
            margin-bottom: 0.5rem;
        }
        
        .product-gallery .placeholder-icon span {
            font-size: 0.9rem;
            color: var(--slate-500);
            font-weight: 500;
        }
        
        .product-info {
            padding-left: 1rem;
        }
        
        .product-info h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        /* Rating Section */
        .product-rating-section {
            margin-bottom: 1rem;
        }
        
        .product-rating-stars {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .product-rating-stars i {
            font-size: 1.2rem;
        }
        
        .rating-number {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .rating-count {
            font-size: 0.9rem;
            color: var(--slate-500);
        }
        
        .product-meta {
            display: flex;
            gap: 0.8rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        
        .product-meta .badge {
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        
        .badge-category {
            background: linear-gradient(135deg, var(--primary-light), #ffffff);
            color: var(--primary-dark);
            border: 1px solid var(--primary);
        }
        
        .badge-featured {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }
        
        .badge-lowstock {
            background: linear-gradient(135deg, var(--warning), #d97706);
            color: white;
        }
        
        .product-price {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .product-old-price {
            font-size: 1.1rem;
            color: var(--slate-400);
            text-decoration: line-through;
            margin-left: 0.8rem;
            font-weight: 400;
        }
        
        .product-stock {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-top: 1px solid var(--slate-200);
            border-bottom: 1px solid var(--slate-200);
            margin-bottom: 1.2rem;
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
        
        .stock-text {
            font-weight: 600;
            color: var(--slate-700);
            font-size: 0.95rem;
        }
        
        .stock-text strong {
            color: var(--primary);
            margin-left: 0.3rem;
            font-size: 0.95rem;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin: 1.2rem 0;
        }
        
        .quantity-label {
            font-weight: 600;
            color: var(--slate-700);
            margin-right: 0.3rem;
            font-size: 0.95rem;
        }
        
        .quantity-btn {
            width: 38px;
            height: 38px;
            border: 1px solid var(--slate-200);
            background: white;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--slate-600);
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .quantity-btn:hover:not(:disabled) {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
        }
        
        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .quantity-input {
            width: 60px;
            height: 38px;
            text-align: center;
            border: 1px solid var(--slate-200);
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            color: var(--dark);
        }
        
        .quantity-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        }
        
        .btn-add-cart-lg {
            width: 100%;
            padding: 1rem;
            border-radius: 12px;
            border: none;
            background: var(--dark);
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
        }
        
        .btn-add-cart-lg:hover:not(:disabled) {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }
        
        .btn-add-cart-lg:disabled {
            background: var(--slate-200);
            color: var(--slate-400);
            cursor: not-allowed;
            box-shadow: none;
        }
        
        .product-description {
            margin-top: 1.5rem;
        }
        
        .product-description h5 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.8rem;
            font-size: 1.1rem;
        }
        
        .product-description p {
            line-height: 1.6;
            color: var(--slate-600);
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        
        .product-specs {
            background: var(--slate-50);
            border-radius: 16px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            border: 1px solid var(--slate-200);
        }
        
        .product-specs h5 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        
        .spec-item {
            display: flex;
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--slate-200);
            font-size: 0.95rem;
        }
        
        .spec-item:last-child {
            border-bottom: none;
        }
        
        .spec-label {
            width: 100px;
            font-weight: 600;
            color: var(--slate-600);
        }
        
        .spec-value {
            flex: 1;
            color: var(--slate-800);
            font-weight: 500;
        }
        
        /* Reviews Section */
        .reviews-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid var(--slate-200);
            margin-top: 2rem;
        }
        
        .reviews-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .reviews-header h3 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .review-item {
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .review-item:last-child {
            border-bottom: none;
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.8rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .reviewer-name {
            font-weight: 600;
            color: var(--slate-800);
        }
        
        .review-date {
            font-size: 0.8rem;
            color: var(--slate-500);
        }
        
        .review-stars {
            color: #ffc107;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .review-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .review-content {
            color: var(--slate-600);
            line-height: 1.6;
            margin-bottom: 0.8rem;
        }
        
        .review-images {
            display: flex;
            gap: 0.8rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        
        .review-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--slate-200);
            cursor: pointer;
        }
        
        .review-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .verified-badge {
            display: inline-block;
            background: var(--success-light);
            color: var(--success);
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .btn-write-review {
            background: var(--dark);
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-write-review:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }
        
        /* Rating Summary */
        .rating-summary {
            background: var(--slate-50);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .rating-summary .average-rating {
            font-size: 3rem;
            font-weight: 700;
            color: var(--dark);
        }
        
        .rating-bars {
            margin-top: 1rem;
        }
        
        .rating-bar-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 0.5rem;
        }
        
        .rating-bar-label {
            width: 40px;
            font-size: 0.9rem;
            color: var(--slate-600);
        }
        
        .rating-bar {
            flex: 1;
            height: 8px;
            background: var(--slate-200);
            border-radius: 4px;
            overflow: hidden;
        }
        
        .rating-bar-fill {
            height: 100%;
            background: #ffc107;
            border-radius: 4px;
        }
        
        .rating-bar-percent {
            width: 45px;
            font-size: 0.9rem;
            color: var(--slate-600);
        }
        
        /* Related Products */
        .related-products {
            margin-top: 3rem;
        }
        
        .related-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            font-size: 1.4rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .related-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
        }
        
        .product-card {
            background: white;
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(40, 167, 69, 0.1);
            border-color: var(--primary);
        }
        
        .product-card .product-image {
            width: 100%;
            aspect-ratio: 1 / 1;
            max-width: 180px;
            margin: 0 auto 0.8rem;
            background: var(--slate-100);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .product-card .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        
        .product-card .product-image i {
            font-size: 2.5rem;
            color: var(--primary);
        }
        
        .product-card .product-category {
            font-size: 0.7rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.2rem;
            text-transform: uppercase;
        }
        
        .product-card .product-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--slate-800);
            margin-bottom: 0.2rem;
        }
        
        .product-card .product-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.6rem;
        }
        
        .product-card .product-rating {
            display: flex;
            align-items: center;
            gap: 0.2rem;
            margin-bottom: 0.5rem;
        }
        
        .product-card .product-rating i {
            font-size: 0.7rem;
        }
        
        .product-card .btn-add-cart {
            width: 100%;
            padding: 0.5rem;
            border-radius: 8px;
            border: none;
            background: var(--dark);
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s;
            margin-top: auto;
        }
        
        .product-card .btn-add-cart:hover:not(:disabled) {
            background: var(--primary);
            transform: translateY(-2px);
        }
        
        .product-card .btn-add-cart:disabled {
            background: var(--slate-200);
            color: var(--slate-400);
            cursor: not-allowed;
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
            padding: 0.8rem 1.2rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 4px solid var(--primary);
            display: flex;
            align-items: center;
            gap: 0.8rem;
            min-width: 280px;
            animation: slideIn 0.3s ease;
            font-size: 0.9rem;
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

        .toast-notification.error {
            border-left-color: var(--danger);
        }

        .toast-notification i {
            font-size: 1.3rem;
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
            margin-bottom: 0.1rem;
            font-size: 0.95rem;
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
            font-size: 1rem;
            transition: color 0.3s;
        }

        .toast-close:hover {
            color: var(--dark);
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
            .product-info {
                padding-left: 0;
                margin-top: 1.5rem;
            }
            
            .product-info h1 {
                font-size: 1.8rem;
            }
            
            .product-price {
                font-size: 1.8rem;
            }
            
            .user-info {
                display: none;
            }
            
            .footer {
                text-align: center;
            }
            
            .product-gallery {
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
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
        <div class="container">
            <!-- Back Button and Breadcrumb -->
            <div class="d-flex align-items-center mb-4">
                <a href="javascript:history.back()" class="back-button me-3">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <nav aria-label="breadcrumb" class="flex-grow-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none"><i class="bi bi-house-door me-1"></i>Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 30) }}</li>
                    </ol>
                </nav>
            </div>

            <!-- Product Detail -->
            <div class="product-detail">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5">
                        <div class="product-gallery">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            @else
                                @php
                                    $catName = strtolower($product->category->name ?? '');
                                @endphp
                                <div class="placeholder-icon">
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
                                    <span>{{ $product->category->name ?? 'Product' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="product-info">
                            <div class="product-meta">
                                <span class="badge badge-category">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                @if($product->is_featured)
                                    <span class="badge badge-featured">FEATURED</span>
                                @endif
                                @if($product->stock < 10 && $product->stock > 0)
                                    <span class="badge badge-lowstock">Low Stock</span>
                                @endif
                            </div>
                            
                            <h1>{{ $product->name }}</h1>
                            
                            <!-- Rating Display -->
                            @php
                                $averageRating = round($product->ratings()->avg('rating') ?? 0, 1);
                                $ratingCount = $product->ratings()->count();
                            @endphp
                            
                            @if($ratingCount > 0)
                            <div class="product-rating-section">
                                <div class="product-rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($averageRating))
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                            <i class="bi bi-star-half text-warning"></i>
                                        @else
                                            <i class="bi bi-star text-muted"></i>
                                        @endif
                                    @endfor
                                    <span class="rating-number">{{ number_format($averageRating, 1) }}</span>
                                    <span class="rating-count">({{ $ratingCount }} reviews)</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($product->brand)
                                <p class="text-muted mb-3">
                                    <i class="bi bi-tag me-2" style="color: var(--primary);"></i>
                                    Brand: <strong>{{ $product->brand }}</strong>
                                </p>
                            @endif
                            
                            <div class="product-price">
                                ₱{{ number_format($product->price, 2) }}
                                @if($product->old_price)
                                    <span class="product-old-price">₱{{ number_format($product->old_price, 2) }}</span>
                                @endif
                            </div>
                            
                            <div class="product-stock">
                                @php
                                    $stockClass = $product->stock > 10 ? 'stock-high' : ($product->stock > 0 ? 'stock-medium' : 'stock-low');
                                    $stockText = $product->stock > 0 ? "In Stock" : "Out of Stock";
                                @endphp
                                <span class="stock-indicator {{ $stockClass }}"></span>
                                <span class="stock-text">
                                    {{ $stockText }}
                                    @if($product->stock > 0)
                                        <strong>{{ $product->stock }} units available</strong>
                                    @endif
                                </span>
                            </div>
                            
                            @if($product->stock > 0)
                            <div class="quantity-selector">
                                <span class="quantity-label">Quantity:</span>
                                <button class="quantity-btn" onclick="decrementQuantity()" id="decrementBtn">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" class="quantity-input" id="quantity" value="1" min="1" max="{{ $product->stock }}" readonly>
                                <button class="quantity-btn" onclick="incrementQuantity({{ $product->stock }})" id="incrementBtn">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            
                            <button class="btn-add-cart-lg add-to-cart-btn" 
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->price }}"
                                    data-quantity="1"
                                    id="addToCartBtn">
                                <i class="bi bi-cart-plus me-2"></i> Add to Cart
                            </button>
                            @else
                            <button class="btn-add-cart-lg" disabled>
                                <i class="bi bi-cart-x me-2"></i> Out of Stock
                            </button>
                            @endif
                            
                            @if($product->description)
                            <div class="product-description">
                                <h5><i class="bi bi-info-circle me-2" style="color: var(--primary);"></i>Description</h5>
                                <p>{{ $product->description }}</p>
                            </div>
                            @endif
                            
                            <div class="product-specs">
                                <h5><i class="bi bi-gear me-2" style="color: var(--primary);"></i>Product Specifications</h5>
                                <div class="spec-item">
                                    <span class="spec-label">SKU:</span>
                                    <span class="spec-value">{{ $product->sku ?? 'N/A' }}</span>
                                </div>
                                @if($product->weight)
                                <div class="spec-item">
                                    <span class="spec-label">Weight:</span>
                                    <span class="spec-value">{{ $product->weight }}</span>
                                </div>
                                @endif
                                @if($product->dimensions)
                                <div class="spec-item">
                                    <span class="spec-label">Dimensions:</span>
                                    <span class="spec-value">{{ $product->dimensions }}</span>
                                </div>
                                @endif
                                <div class="spec-item">
                                    <span class="spec-label">Category:</span>
                                    <span class="spec-value">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Availability:</span>
                                    <span class="spec-value">
                                        @if($product->stock > 10)
                                            <span class="text-success">High Stock</span>
                                        @elseif($product->stock > 0)
                                            <span class="text-warning">Low Stock ({{ $product->stock }} left)</span>
                                        @else
                                            <span class="text-danger">Out of Stock</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            @if($ratingCount > 0)
            <div class="reviews-section">
                <div class="reviews-header">
                    <h3>Customer Reviews</h3>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <div class="product-rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                        <i class="bi bi-star-half text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-muted"></i>
                                    @endif
                                @endfor
                                <span class="rating-number ms-2">{{ number_format($averageRating, 1) }} out of 5</span>
                            </div>
                            <p class="text-muted mt-1">Based on {{ $ratingCount }} reviews</p>
                        </div>
                        @auth
                            <button class="btn-write-review" onclick="window.location='{{ route('order.history') }}'">
                                <i class="bi bi-pencil-square"></i> Write a Review
                            </button>
                        @endauth
                    </div>
                </div>
                
                <!-- Rating Distribution -->
                @php
                    $ratingDistribution = [];
                    for ($i = 5; $i >= 1; $i--) {
                        $ratingDistribution[$i] = $product->ratings()->where('rating', $i)->count();
                    }
                @endphp
                
                <div class="rating-summary">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="average-rating">{{ number_format($averageRating, 1) }}</div>
                            <div class="product-rating-stars justify-content-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                        <i class="bi bi-star-half text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="text-muted">{{ $ratingCount }} reviews</div>
                        </div>
                        <div class="col-md-8">
                            <div class="rating-bars">
                                @foreach($ratingDistribution as $star => $count)
                                    @php
                                        $percentage = $ratingCount > 0 ? ($count / $ratingCount) * 100 : 0;
                                    @endphp
                                    <div class="rating-bar-item">
                                        <div class="rating-bar-label">{{ $star }} ★</div>
                                        <div class="rating-bar">
                                            <div class="rating-bar-fill" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="rating-bar-percent">{{ round($percentage) }}%</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Reviews List -->
                @foreach($product->ratings()->with('user')->latest()->paginate(10) as $review)
                <div class="review-item">
                    <div class="review-header">
                        <div>
                            <span class="reviewer-name">{{ $review->user->first_name }} {{ substr($review->user->last_name, 0, 1) }}.</span>
                            @if($review->is_verified_purchase)
                                <span class="verified-badge"><i class="bi bi-check-circle"></i> Verified Purchase</span>
                            @endif
                        </div>
                        <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="review-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="bi bi-star-fill text-warning"></i>
                            @else
                                <i class="bi bi-star text-muted"></i>
                            @endif
                        @endfor
                    </div>
                    @if($review->title)
                        <div class="review-title">{{ $review->title }}</div>
                    @endif
                    <div class="review-content">{{ $review->review }}</div>
                    @if($review->images && count($review->images) > 0)
                        <div class="review-images">
                            @foreach($review->images as $image)
                                <div class="review-image" onclick="window.open('{{ asset('storage/' . $image) }}', '_blank')">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Review image">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endforeach
                
                <!-- Pagination -->
                @if($product->ratings()->count() > 10)
                <div class="mt-4">
                    {{ $product->ratings()->paginate(10)->links() }}
                </div>
                @endif
            </div>
            @endif

            <!-- Related Products -->
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="related-products">
                <h3 class="related-title">You May Also Like</h3>
                <div class="row g-3">
                    @foreach($relatedProducts as $related)
                    @php
                        $relatedAvgRating = round($related->ratings()->avg('rating') ?? 0, 1);
                        $relatedRatingCount = $related->ratings()->count();
                    @endphp
                    <div class="col-md-3">
                        <div class="product-card" onclick="window.location='{{ route('products.show', $related) }}'">
                            <div class="product-image">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}">
                                @else
                                    @php
                                        $catName = strtolower($related->category->name ?? '');
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
                            <div class="product-category">{{ $related->category->name ?? 'Uncategorized' }}</div>
                            <div class="product-title">{{ Str::limit($related->name, 20) }}</div>
                            @if($relatedRatingCount > 0)
                            <div class="product-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($relatedAvgRating))
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @elseif($i == ceil($relatedAvgRating) && $relatedAvgRating - floor($relatedAvgRating) >= 0.5)
                                        <i class="bi bi-star-half text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-muted"></i>
                                    @endif
                                @endfor
                                <span class="small text-muted ms-1">({{ $relatedRatingCount }})</span>
                            </div>
                            @endif
                            <div class="product-price">₱{{ number_format($related->price, 2) }}</div>
                            <button class="btn-add-cart add-to-cart-btn" 
                                    data-product-id="{{ $related->id }}"
                                    data-product-name="{{ $related->name }}"
                                    data-product-price="{{ $related->price }}"
                                    onclick="event.stopPropagation();"
                                    {{ $related->stock <= 0 ? 'disabled' : '' }}>
                                <i class="bi bi-cart-plus me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
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
        // Quantity selector
        function incrementQuantity(max) {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            if (currentValue < max) {
                input.value = currentValue + 1;
                updateAddToCartQuantity();
            }
        }

        function decrementQuantity() {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateAddToCartQuantity();
            }
        }

        function updateAddToCartQuantity() {
            const quantity = document.getElementById('quantity').value;
            const addToCartBtn = document.getElementById('addToCartBtn');
            if (addToCartBtn) {
                addToCartBtn.dataset.quantity = quantity;
            }
        }

        // Add to Cart
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (this.disabled) return;
                
                const productId = this.dataset.productId;
                const quantity = this.dataset.quantity || 1;
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
                        quantity: parseInt(quantity)
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