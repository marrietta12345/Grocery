<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Grocery Mart</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @php
        use Illuminate\Support\Str;
    @endphp
    
    <style>
        /* Modern Hero Section - Full Width with Background Image */
        .hero-section {
            position: relative;
            background-image: url('{{ asset("img/hero-img.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 32px;
            margin-bottom: 2.5rem;
            overflow: hidden;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Dark Overlay */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.5) 100%);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 800px;
            padding: 3rem;
        }
        
        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            letter-spacing: 0.5px;
        }
        
        .hero-title {
            font-family: 'Outfit', sans-serif;
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .hero-description {
            font-size: 1.2rem;
            opacity: 0.95;
            margin-bottom: 2rem;
            line-height: 1.6;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-btn-primary {
            background: white;
            color: var(--dark);
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .hero-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            background: white;
            color: var(--primary);
        }
        
        /* Modern Featured Carousel Styles */
        .featured-section {
            margin-bottom: 2.5rem;
        }
        
        .featured-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .featured-header .featured-label {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 40px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }
        
        .featured-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--slate-800);
            margin-bottom: 0.5rem;
        }
        
        .featured-header p {
            color: var(--slate-500);
            font-size: 1rem;
        }
        
        .featured-carousel-container {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--dark), var(--primary));
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            min-height: 500px;
            display: flex;
            align-items: center;
        }
        
        .featured-carousel {
            position: relative;
            width: 100%;
        }
        
        .featured-slide {
            display: none;
            width: 100%;
        }
        
        .featured-slide.active {
            display: block;
        }
        
        .featured-slide-content {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            padding: 3rem 4rem;
            gap: 3rem;
            min-height: 500px;
        }
        
        .featured-info {
            flex: 1;
            color: white;
            z-index: 2;
            max-width: 500px;
            text-align: left;
        }
        
        .featured-category {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.4rem 1.2rem;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }
        
        .featured-title {
            font-family: 'Outfit', sans-serif;
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .featured-description {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .featured-price-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .featured-current-price {
            font-size: 2.2rem;
            font-weight: 700;
        }
        
        .featured-old-price {
            font-size: 1.2rem;
            text-decoration: line-through;
            opacity: 0.7;
        }
        
        .featured-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .featured-rating .stars {
            display: flex;
            gap: 0.2rem;
        }
        
        .featured-rating .stars i {
            font-size: 1rem;
            color: #ffc107;
        }
        
        .featured-rating .rating-text {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .featured-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            color: var(--dark);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        
        .featured-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: var(--primary);
        }
        
        .featured-image-card {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 2;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .featured-image-card img {
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            border-radius: 16px;
            transition: transform 0.3s ease;
        }
        
        .featured-image-card:hover img {
            transform: scale(1.05);
        }
        
        /* Carousel Navigation */
        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 1rem;
            pointer-events: none;
            z-index: 10;
        }
        
        .carousel-nav-btn {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            pointer-events: auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .carousel-nav-btn:hover {
            background: white;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }
        
        .carousel-nav-btn i {
            font-size: 1.5rem;
            color: var(--dark);
        }
        
        /* Carousel Indicators */
        .carousel-indicators-modern {
            position: absolute;
            bottom: 1.5rem;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 0.8rem;
            z-index: 10;
        }
        
        .carousel-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 0;
        }
        
        .carousel-dot.active {
            background: white;
            width: 28px;
            border-radius: 5px;
        }
        
        .carousel-dot:hover {
            background: white;
            transform: scale(1.1);
        }
        
        /* Add rating styles */
        .product-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .product-rating .stars {
            display: flex;
            gap: 0.2rem;
        }
        
        .product-rating .stars i {
            font-size: 0.9rem;
        }
        
        .product-rating .stars i.bi-star-fill {
            color: #ffc107;
        }
        
        .product-rating .stars i.bi-star-half {
            color: #ffc107;
        }
        
        .product-rating .stars i.bi-star {
            color: var(--slate-300);
        }
        
        .product-rating .rating-count {
            font-size: 0.8rem;
            color: var(--slate-500);
        }
        
        .product-rating .rating-count:hover {
            color: var(--primary);
            text-decoration: underline;
        }
        
        /* Rating Modal Styles */
        .rating-view-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 10000;
            align-items: center;
            justify-content: center;
        }
        
        .rating-view-modal.show {
            display: flex;
        }
        
        .rating-view-content {
            background: white;
            border-radius: 32px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            padding: 2rem;
            animation: modalFadeIn 0.3s ease;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .rating-view-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .rating-view-header h3 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }
        
        .rating-view-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--slate-500);
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .rating-view-close:hover {
            color: var(--danger);
        }
        
        .rating-summary {
            background: var(--slate-50);
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .rating-summary .average-rating {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
        }
        
        .rating-summary .total-ratings {
            color: var(--slate-500);
        }
        
        .rating-item {
            padding: 1rem 0;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .rating-item:last-child {
            border-bottom: none;
        }
        
        .rating-user {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .rating-user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary), var(--dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
        }
        
        .rating-user-name {
            font-weight: 600;
            color: var(--slate-800);
        }
        
        .rating-user-date {
            font-size: 0.75rem;
            color: var(--slate-500);
            margin-left: auto;
        }
        
        .rating-stars {
            display: flex;
            gap: 0.2rem;
            margin-bottom: 0.5rem;
        }
        
        .rating-stars i {
            font-size: 1rem;
            color: #ffc107;
        }
        
        .rating-title {
            font-weight: 600;
            color: var(--slate-800);
            margin-bottom: 0.3rem;
        }
        
        .rating-review {
            color: var(--slate-600);
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .no-ratings {
            text-align: center;
            padding: 2rem;
            color: var(--slate-500);
        }
        
        /* Rest of your existing CSS */
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
        }
        
        /* Category Cards */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .category-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
            transition: all 0.3s ease;
            text-align: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 15px 30px rgba(40, 167, 69, 0.1);
        }
        
        .category-card.active {
            border: 2px solid var(--primary);
            background: linear-gradient(135deg, white, var(--slate-50));
        }
        
        .category-image {
            width: 100px;
            height: 100px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            overflow: hidden;
            background: var(--slate-100);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }
        
        .category-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .category-image span {
            line-height: 1;
            display: block;
        }
        
        .category-name {
            font-weight: 600;
            color: var(--slate-800);
            margin-bottom: 0.5rem;
        }
        
        .category-count {
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 500;
        }
        
        /* Product Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .product-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(40, 167, 69, 0.1);
            border-color: var(--primary);
        }
        
        .product-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.3rem 0.8rem;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 600;
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
            height: 180px;
            background: var(--slate-100);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            overflow: hidden;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-image i {
            font-size: 3rem;
            color: var(--primary);
        }
        
        .product-category {
            font-size: 0.8rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.3rem;
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
        
        .product-description {
            font-size: 0.85rem;
            color: var(--slate-600);
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        
        .product-price-section {
            display: flex;
            align-items: center;
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
        
        /* Search and Filter */
        .search-filter-section {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--slate-200);
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
        }
        
        .search-box input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            border-radius: 12px;
            border: 1px solid var(--slate-200);
            font-size: 0.95rem;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        }
        
        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }
        
        .content-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .card-header h3 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--slate-800);
            margin: 0;
        }
        
        .card-header a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .card-header a:hover {
            text-decoration: underline;
        }
        
        /* Order List */
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
        
        .order-info h4 {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--slate-800);
            margin-bottom: 0.2rem;
        }
        
        .order-info p {
            font-size: 0.8rem;
            color: var(--slate-500);
            margin: 0;
        }
        
        .order-status {
            padding: 0.3rem 0.8rem;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-completed {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }
        
        .status-pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .status-processing {
            background: rgba(100, 116, 139, 0.1);
            color: var(--slate-600);
        }
        
        .status-cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }
        
        /* Product List (for recommended) */
        .product-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .product-item {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .product-item:hover {
            background: var(--slate-50);
        }
        
        .product-img {
            width: 60px;
            height: 60px;
            background: var(--slate-100);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            overflow: hidden;
        }
        
        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-img i {
            font-size: 1.8rem;
            color: var(--primary);
        }
        
        .product-info {
            flex: 1;
        }
        
        .product-name {
            font-weight: 600;
            color: var(--slate-800);
            margin-bottom: 0.2rem;
        }
        
        .product-category {
            font-size: 0.75rem;
            color: var(--slate-500);
        }
        
        .product-price {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.1rem;
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
        
        @media (max-width: 968px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-description {
                font-size: 1rem;
            }
            
            .hero-section {
                min-height: 500px;
            }
            
            .featured-slide-content {
                flex-direction: column;
                text-align: center;
                padding: 2rem;
                gap: 1.5rem;
            }
            
            .featured-info {
                text-align: center;
                max-width: 100%;
            }
            
            .featured-description {
                max-width: 100%;
            }
            
            .featured-price-section {
                justify-content: center;
            }
            
            .featured-rating {
                justify-content: center;
            }
            
            .featured-title {
                font-size: 2rem;
            }
            
            .featured-current-price {
                font-size: 1.8rem;
            }
            
            .featured-image-card {
                max-width: 280px;
            }
        }
        
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .user-info {
                display: none;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .category-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-section {
                min-height: 400px;
            }
        }
    </style>
</head>
<body>
    <!-- Toast Notifications Container -->
    <div class="toast-container" id="toastContainer"></div>
    
    <!-- Rating View Modal -->
    <div class="rating-view-modal" id="ratingViewModal">
        <div class="rating-view-content">
            <div class="rating-view-header">
                <h3 id="ratingModalTitle">Product Ratings</h3>
                <button class="rating-view-close" onclick="closeRatingModal()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div id="ratingModalContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
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
                        <a class="nav-link active" href="{{ route('dashboard') }}">
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
            <!-- Modern Hero Section - Full Width with Background Image (No Animations) -->
            <div class="hero-section">
                <div class="hero-content">
                    <div class="hero-badge">
                        <i class="bi bi-star-fill me-1"></i> Welcome to Grocery Mart
                    </div>
                    <h1 class="hero-title">
                        Fresh Groceries<br>
                        Delivered to Your Doorstep
                    </h1>
                    <p class="hero-description">
                        Discover the freshest produce, premium quality meats, and everyday essentials. 
                        Shop smarter, live healthier with Grocery Mart.
                    </p>
                    <a href="{{ route('products.index') }}" class="hero-btn-primary">
                        <i class="bi bi-cart-plus"></i> Start Shopping
                    </a>
                </div>
            </div>
            
            <!-- Modern Featured Products Carousel -->
            @if(isset($featuredProducts) && $featuredProducts->count() > 0)
            <div class="featured-section">
                <div class="featured-header">
                    <div class="featured-label">
                        <i class="bi bi-star-fill me-1"></i> Featured Collection
                    </div>
                    <h2>Handpicked Just For You</h2>
                    <p>Discover our curated selection of premium products</p>
                </div>
                
                <div class="featured-carousel-container">
                    <div class="featured-carousel" id="featuredCarousel">
                        @foreach($featuredProducts as $index => $product)
                        <div class="featured-slide {{ $index == 0 ? 'active' : '' }}" data-slide-index="{{ $index }}">
                            <div class="featured-slide-content">
                                <div class="featured-info">
                                    <div class="featured-category">
                                        @if($product->category)
                                            {{ is_object($product->category) ? $product->category->name : $product->category }}
                                        @else
                                            Featured Product
                                        @endif
                                    </div>
                                    <h2 class="featured-title">{{ $product->name }}</h2>
                                    <p class="featured-description">{{ Str::limit($product->description, 120) }}</p>
                                    <div class="featured-price-section">
                                        <span class="featured-current-price">₱{{ number_format($product->price, 2) }}</span>
                                        @if($product->old_price)
                                            <span class="featured-old-price">₱{{ number_format($product->old_price, 2) }}</span>
                                        @endif
                                    </div>
                                    @php
                                        $avgRating = $product->ratings()->avg('rating') ?? 0;
                                        $ratingCount = $product->ratings()->count() ?? 0;
                                        $fullStars = floor($avgRating);
                                        $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                                    @endphp
                                    @if($ratingCount > 0)
                                    <div class="featured-rating">
                                        <div class="stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $fullStars)
                                                    <i class="bi bi-star-fill"></i>
                                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                    <i class="bi bi-star-half"></i>
                                                @else
                                                    <i class="bi bi-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="rating-text">{{ number_format($avgRating, 1) }} ({{ $ratingCount }} reviews)</span>
                                    </div>
                                    @endif
                                    <button class="featured-btn add-to-cart-btn" 
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-price="{{ $product->price }}"
                                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-cart-plus"></i> Shop Now
                                    </button>
                                </div>
                                <div class="featured-image-card">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        @php
                                            $catName = strtolower(is_object($product->category) ? $product->category->name : ($product->category ?? ''));
                                        @endphp
                                        @if(str_contains($catName, 'fresh') || str_contains($catName, 'produce') || str_contains($catName, 'fruit') || str_contains($catName, 'vegetable'))
                                            <img src="https://placehold.co/400x400/28a745/white?text=Fresh+Produce" alt="Fresh Produce">
                                        @elseif(str_contains($catName, 'dairy') || str_contains($catName, 'milk'))
                                            <img src="https://placehold.co/400x400/28a745/white?text=Dairy" alt="Dairy">
                                        @elseif(str_contains($catName, 'beverage') || str_contains($catName, 'drink'))
                                            <img src="https://placehold.co/400x400/28a745/white?text=Beverages" alt="Beverages">
                                        @else
                                            <img src="https://placehold.co/400x400/28a745/white?text=Grocery" alt="Grocery">
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="carousel-nav">
                        <button class="carousel-nav-btn" id="prevSlide">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="carousel-nav-btn" id="nextSlide">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                    
                    <div class="carousel-indicators-modern" id="carouselIndicators">
                        @foreach($featuredProducts as $index => $product)
                            <button class="carousel-dot {{ $index == 0 ? 'active' : '' }}" data-index="{{ $index }}"></button>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Shop by Category Section -->
            <div class="content-card mb-4">
                <div class="card-header">
                    <h3><i class="bi bi-tags me-2" style="color: var(--primary);"></i>Shop by Category</h3>
                </div>
                
                <div class="category-grid">
                    <div class="category-card active" onclick="filterProducts('all')">
                        <div class="category-image">
                            <span style="font-size: 3rem;">🛒</span>
                        </div>
                        <div class="category-name">All Products</div>
                        <div class="category-count">{{ $totalProducts ?? 0 }} items</div>
                    </div>
                    
                    @forelse($categories ?? [] as $category)
                    <div class="category-card" onclick="filterProducts('{{ Str::slug($category->name) }}')">
                        <div class="category-image">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                            @else
                                @php
                                    $categoryName = strtolower($category->name);
                                    $emoji = '📦';
                                    
                                    if (str_contains($categoryName, 'fresh') || str_contains($categoryName, 'produce') || str_contains($categoryName, 'fruit') || str_contains($categoryName, 'vegetable')) {
                                        $emoji = '🥬';
                                    } else if (str_contains($categoryName, 'dairy') || str_contains($categoryName, 'milk') || str_contains($categoryName, 'cheese') || str_contains($categoryName, 'egg')) {
                                        $emoji = '🥛';
                                    } else if (str_contains($categoryName, 'beverage') || str_contains($categoryName, 'drink') || str_contains($categoryName, 'juice') || str_contains($categoryName, 'soda')) {
                                        $emoji = '🧃';
                                    } else if (str_contains($categoryName, 'snack') || str_contains($categoryName, 'chip') || str_contains($categoryName, 'cookie')) {
                                        $emoji = '🍪';
                                    } else if (str_contains($categoryName, 'bakery') || str_contains($categoryName, 'bread') || str_contains($categoryName, 'cake') || str_contains($categoryName, 'pastry')) {
                                        $emoji = '🥖';
                                    } else if (str_contains($categoryName, 'meat') || str_contains($categoryName, 'seafood') || str_contains($categoryName, 'fish') || str_contains($categoryName, 'chicken')) {
                                        $emoji = '🥩';
                                    } else if (str_contains($categoryName, 'frozen')) {
                                        $emoji = '❄️';
                                    } else if (str_contains($categoryName, 'pantry') || str_contains($categoryName, 'grain') || str_contains($categoryName, 'rice') || str_contains($categoryName, 'pasta')) {
                                        $emoji = '🍚';
                                    } else if (str_contains($categoryName, 'household') || str_contains($categoryName, 'clean')) {
                                        $emoji = '🧹';
                                    } else if (str_contains($categoryName, 'personal') || str_contains($categoryName, 'beauty') || str_contains($categoryName, 'care')) {
                                        $emoji = '🧴';
                                    }
                                @endphp
                                <span>{{ $emoji }}</span>
                            @endif
                        </div>
                        <div class="category-name">{{ $category->name }}</div>
                        <div class="category-count">{{ $category->products_count ?? 0 }} products</div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">No categories available</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Products Section -->
            <div id="products" class="content-card">
                <div class="card-header">
                    <h3><i class="bi bi-shop me-2" style="color: var(--primary);"></i>Browse Products</h3>
                    <div class="d-flex gap-2">
                        <span class="badge bg-success">{{ $totalProducts ?? 0 }} items</span>
                    </div>
                </div>
                
                <!-- Search and Filter -->
                <div class="search-filter-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="search-box">
                                <i class="bi bi-search"></i>
                                <input type="text" id="searchInput" placeholder="Search products by name, brand, or description...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select" id="sortSelect" style="height: 48px; border-radius: 12px;">
                                <option value="featured">Sort by: Featured</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                                <option value="newest">Newest First</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Products Grid -->
                <div class="products-grid" id="productsGrid">
                    @forelse($products ?? [] as $product)
                    @php
                        $categorySlug = '';
                        $categoryName = '';
                        if ($product->category) {
                            if (is_object($product->category) && isset($product->category->name)) {
                                $categoryName = $product->category->name;
                                $categorySlug = Str::slug($product->category->name);
                            } else {
                                $categoryName = $product->category;
                                $categorySlug = Str::slug($product->category);
                            }
                        }
                        
                        $isNew = $product->created_at->diffInDays(now()) < 7;
                        $discountPercentage = $product->old_price && $product->old_price > $product->price 
                            ? round((($product->old_price - $product->price) / $product->old_price) * 100) 
                            : 0;
                        
                        $avgRating = $product->ratings()->avg('rating') ?? 0;
                        $ratingCount = $product->ratings()->count() ?? 0;
                        $fullStars = floor($avgRating);
                        $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                    @endphp
                    
                    <div class="product-card" 
                         data-category="{{ $categorySlug }}" 
                         data-price="{{ $product->price }}" 
                         data-date="{{ $product->created_at }}"
                         data-category-name="{{ strtolower($categoryName) }}">
                        
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
                                    $catName = strtolower($categoryName);
                                @endphp
                                @if(str_contains($catName, 'fresh') || str_contains($catName, 'produce') || str_contains($catName, 'fruit') || str_contains($catName, 'vegetable'))
                                    <i class="bi bi-apple"></i>
                                @elseif(str_contains($catName, 'dairy') || str_contains($catName, 'milk') || str_contains($catName, 'cheese') || str_contains($catName, 'egg'))
                                    <i class="bi bi-cup-straw"></i>
                                @elseif(str_contains($catName, 'beverage') || str_contains($catName, 'drink') || str_contains($catName, 'juice') || str_contains($catName, 'soda'))
                                    <i class="bi bi-cup"></i>
                                @elseif(str_contains($catName, 'snack') || str_contains($catName, 'chip') || str_contains($catName, 'cookie'))
                                    <i class="bi bi-basket"></i>
                                @elseif(str_contains($catName, 'bakery') || str_contains($catName, 'bread') || str_contains($catName, 'cake') || str_contains($catName, 'pastry'))
                                    <i class="bi bi-basket"></i>
                                @elseif(str_contains($catName, 'meat') || str_contains($catName, 'seafood') || str_contains($catName, 'fish') || str_contains($catName, 'chicken'))
                                    <i class="bi bi-fish"></i>
                                @elseif(str_contains($catName, 'frozen'))
                                    <i class="bi bi-snow"></i>
                                @elseif(str_contains($catName, 'pantry') || str_contains($catName, 'grain') || str_contains($catName, 'rice') || str_contains($catName, 'pasta'))
                                    <i class="bi bi-basket"></i>
                                @else
                                    <i class="bi bi-box"></i>
                                @endif
                            @endif
                        </div>
                        
                        <div class="product-category">{{ $categoryName }}</div>
                        <div class="product-title">{{ $product->name }}</div>
                        <div class="product-brand">{{ $product->brand ?? '' }}</div>
                        
                        <div class="product-rating">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $fullStars)
                                        <i class="bi bi-star-fill"></i>
                                    @elseif($i == $fullStars + 1 && $hasHalfStar)
                                        <i class="bi bi-star-half"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-count" onclick="viewRatings({{ $product->id }}, '{{ addslashes($product->name) }}')">
                                ({{ $ratingCount }} {{ Str::plural('review', $ratingCount) }})
                            </span>
                        </div>
                        
                        <div class="product-description">{{ Str::limit($product->description, 80) }}</div>
                        
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
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <i class="bi bi-cart-plus me-2"></i>Add to Cart
                        </button>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-box" style="font-size: 4rem; color: var(--slate-300);"></i>
                        <h5 class="mt-3 text-muted">No Products Available</h5>
                        <p class="text-muted">Check back later for fresh groceries!</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Content Grid -->
            <div class="content-grid mt-4">
                <!-- Recent Orders -->
                <div class="content-card">
                    <div class="card-header">
                        <h3><i class="bi bi-clock-history me-2" style="color: var(--primary);"></i>Recent Orders</h3>
                        <a href="{{ route('order.history') }}">View All <i class="bi bi-arrow-right"></i></a>
                    </div>
                    
                    <div class="order-list">
                        @forelse($recentOrders ?? [] as $order)
                        <div class="order-item">
                            <div class="order-info">
                                <h4>#{{ $order->order_number ?? 'ORD-'.$order->id }}</h4>
                                <p>{{ $order->items_count ?? 0 }} items • ₱{{ number_format($order->total ?? 0, 2) }}</p>
                            </div>
                            @php
                                $status = $order->status ?? 'pending';
                                $statusClass = match($status) {
                                    'completed', 'delivered' => 'status-completed',
                                    'pending' => 'status-pending',
                                    'processing' => 'status-processing',
                                    'cancelled' => 'status-cancelled',
                                    default => 'status-processing'
                                };
                                $statusLabel = match($status) {
                                    'completed', 'delivered' => 'Completed',
                                    'pending' => 'Pending',
                                    'processing' => 'Processing',
                                    'cancelled' => 'Cancelled',
                                    default => ucfirst($status)
                                };
                            @endphp
                            <span class="order-status {{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No recent orders</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Recommended Products -->
                <div class="content-card">
                    <div class="card-header">
                        <h3><i class="bi bi-lightning-charge me-2" style="color: var(--primary);"></i>Recommended for You</h3>
                        <a href="#">View All</a>
                    </div>
                    
                    <div class="product-list">
                        @forelse($recommendedProducts ?? [] as $product)
                        <div class="product-item add-to-cart-btn" 
                             data-product-id="{{ $product->id }}"
                             data-product-name="{{ $product->name }}"
                             data-product-price="{{ $product->price }}">
                            <div class="product-img">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <i class="bi bi-{{ $product->category->name == 'Fresh Produce' ? 'apple' : ($product->category->name == 'Dairy' ? 'cup-straw' : 'box') }}"></i>
                                @endif
                            </div>
                            <div class="product-info">
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="product-category">{{ $product->category->name ?? $product->category }}</div>
                            </div>
                            <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="bi bi-star fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No recommendations yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="footer" style="margin-top: 3rem;">
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
        // Modern Carousel JavaScript
        let currentSlide = 0;
        const slides = document.querySelectorAll('.featured-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const prevBtn = document.getElementById('prevSlide');
        const nextBtn = document.getElementById('nextSlide');
        
        function showSlide(index) {
            if (!slides.length) return;
            
            slides.forEach(slide => {
                slide.classList.remove('active');
            });
            
            dots.forEach(dot => {
                dot.classList.remove('active');
            });
            
            slides[index].classList.add('active');
            if (dots[index]) {
                dots[index].classList.add('active');
            }
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }
        
        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }
        
        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', prevSlide);
            nextBtn.addEventListener('click', nextSlide);
        }
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Filter products by category
        window.filterProducts = function(category) {
            document.querySelectorAll('.category-card').forEach(card => {
                card.classList.remove('active');
            });
            
            if (category === 'all') {
                document.querySelectorAll('.category-card').forEach(card => {
                    const cardName = card.querySelector('.category-name').textContent.trim().toLowerCase();
                    if (cardName.includes('all products')) {
                        card.classList.add('active');
                    }
                });
            } else {
                document.querySelectorAll('.category-card').forEach(card => {
                    const cardName = card.querySelector('.category-name').textContent.trim().toLowerCase();
                    const categoryName = category.replace(/-/g, ' ').toLowerCase();
                    
                    if (cardName.includes(categoryName)) {
                        card.classList.add('active');
                    }
                    
                    if ((categoryName === 'meat' || categoryName === 'seafood' || categoryName === 'meat & seafood') && 
                        (cardName.includes('meat') || cardName.includes('seafood'))) {
                        card.classList.add('active');
                    }
                });
            }
            
            const products = document.querySelectorAll('.product-card');
            let visibleCount = 0;
            
            products.forEach(product => {
                const productCategory = product.dataset.category || '';
                const productCategoryName = (product.dataset.categoryName || '').toLowerCase();
                
                if (category === 'all') {
                    product.style.display = 'block';
                    visibleCount++;
                } else {
                    const searchCategory = category.replace(/-/g, ' ').toLowerCase();
                    
                    const matchesSlug = productCategory === category;
                    const matchesName = productCategoryName.includes(searchCategory);
                    
                    const isMeatCategory = (productCategoryName.includes('meat') || productCategoryName.includes('seafood') || 
                                            productCategoryName.includes('fish') || productCategoryName.includes('chicken'));
                    const isSearchingMeat = (searchCategory.includes('meat') || searchCategory.includes('seafood') || 
                                             searchCategory.includes('fish') || searchCategory.includes('chicken'));
                    
                    if (matchesSlug || matchesName || (isMeatCategory && isSearchingMeat)) {
                        product.style.display = 'block';
                        visibleCount++;
                    } else {
                        product.style.display = 'none';
                    }
                }
            });
            
            const productsGrid = document.getElementById('productsGrid');
            let noProductsMessage = document.getElementById('noProductsMessage');
            
            if (visibleCount === 0) {
                if (!noProductsMessage) {
                    noProductsMessage = document.createElement('div');
                    noProductsMessage.id = 'noProductsMessage';
                    noProductsMessage.className = 'col-12 text-center py-5';
                    noProductsMessage.innerHTML = `
                        <i class="bi bi-box" style="font-size: 4rem; color: var(--slate-300);"></i>
                        <h5 class="mt-3 text-muted">No Products Found</h5>
                        <p class="text-muted">No products available in this category.</p>
                    `;
                    productsGrid.appendChild(noProductsMessage);
                }
            } else {
                if (noProductsMessage) {
                    noProductsMessage.remove();
                }
            }
            
            document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
        }
        
        // Search Functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const products = document.querySelectorAll('.product-card');
                
                products.forEach(product => {
                    const title = product.querySelector('.product-title')?.textContent.toLowerCase() || '';
                    const brand = product.querySelector('.product-brand')?.textContent.toLowerCase() || '';
                    const description = product.querySelector('.product-description')?.textContent.toLowerCase() || '';
                    const category = product.querySelector('.product-category')?.textContent.toLowerCase() || '';
                    
                    if (title.includes(searchTerm) || brand.includes(searchTerm) || description.includes(searchTerm) || category.includes(searchTerm)) {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                });
            });
        }
        
        // Sort Functionality
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortBy = this.value;
                const productsGrid = document.getElementById('productsGrid');
                const products = Array.from(document.querySelectorAll('.product-card'));
                
                products.sort((a, b) => {
                    const priceA = parseFloat(a.dataset.price);
                    const priceB = parseFloat(b.dataset.price);
                    const dateA = new Date(a.dataset.date);
                    const dateB = new Date(b.dataset.date);
                    
                    switch(sortBy) {
                        case 'price_low':
                            return priceA - priceB;
                        case 'price_high':
                            return priceB - priceA;
                        case 'newest':
                            return dateB - dateA;
                        default:
                            return 0;
                    }
                });
                
                productsGrid.innerHTML = '';
                products.forEach(product => productsGrid.appendChild(product));
            });
        }
        
        // View Ratings Function
        window.viewRatings = async function(productId, productName) {
            const modal = document.getElementById('ratingViewModal');
            const modalTitle = document.getElementById('ratingModalTitle');
            const modalContent = document.getElementById('ratingModalContent');
            
            modalTitle.textContent = `${productName} - Ratings & Reviews`;
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            
            modalContent.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;
            
            try {
                const response = await fetch(`/ratings/product/${productId}`);
                const data = await response.json();
                
                if (data.success) {
                    const avgRating = data.average_rating || 0;
                    const ratingCount = data.rating_count || 0;
                    const fullStars = Math.floor(avgRating);
                    const hasHalfStar = (avgRating - fullStars) >= 0.5;
                    
                    let ratingsHtml = `
                        <div class="rating-summary">
                            <div class="average-rating">${avgRating.toFixed(1)}</div>
                            <div class="stars" style="display: flex; justify-content: center; gap: 0.2rem; margin: 0.5rem 0;">
                                ${Array(5).fill(0).map((_, i) => {
                                    if (i < fullStars) return '<i class="bi bi-star-fill" style="color: #ffc107; font-size: 1.2rem;"></i>';
                                    if (i === fullStars && hasHalfStar) return '<i class="bi bi-star-half" style="color: #ffc107; font-size: 1.2rem;"></i>';
                                    return '<i class="bi bi-star" style="color: #cbd5e1; font-size: 1.2rem;"></i>';
                                }).join('')}
                            </div>
                            <div class="total-ratings">Based on ${ratingCount} ${ratingCount === 1 ? 'review' : 'reviews'}</div>
                        </div>
                    `;
                    
                    if (data.ratings && data.ratings.length > 0) {
                        ratingsHtml += '<div class="ratings-list">';
                        data.ratings.forEach(rating => {
                            const date = new Date(rating.created_at);
                            const formattedDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                            
                            ratingsHtml += `
                                <div class="rating-item">
                                    <div class="rating-user">
                                        <div class="rating-user-avatar">
                                            ${rating.user ? rating.user.first_name?.charAt(0) || 'U' : 'U'}${rating.user ? rating.user.last_name?.charAt(0) || '' : ''}
                                        </div>
                                        <div class="rating-user-name">${rating.user ? rating.user.first_name + ' ' + rating.user.last_name : 'Anonymous'}</div>
                                        <div class="rating-user-date">${formattedDate}</div>
                                    </div>
                                    <div class="rating-stars">
                                        ${Array(5).fill(0).map((_, i) => {
                                            if (i < rating.rating) {
                                                return '<i class="bi bi-star-fill"></i>';
                                            }
                                            return '<i class="bi bi-star"></i>';
                                        }).join('')}
                                    </div>
                                    ${rating.title ? `<div class="rating-title">${escapeHtml(rating.title)}</div>` : ''}
                                    ${rating.review ? `<div class="rating-review">${escapeHtml(rating.review)}</div>` : ''}
                                </div>
                            `;
                        });
                        ratingsHtml += '</div>';
                    } else {
                        ratingsHtml += `
                            <div class="no-ratings">
                                <i class="bi bi-star fs-1"></i>
                                <p class="mt-2">No reviews yet. Be the first to review this product!</p>
                            </div>
                        `;
                    }
                    
                    modalContent.innerHTML = ratingsHtml;
                } else {
                    modalContent.innerHTML = `
                        <div class="text-center py-4 text-danger">
                            <i class="bi bi-exclamation-circle fs-1"></i>
                            <p class="mt-2">Failed to load ratings. Please try again.</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error loading ratings:', error);
                modalContent.innerHTML = `
                    <div class="text-center py-4 text-danger">
                        <i class="bi bi-exclamation-circle fs-1"></i>
                        <p class="mt-2">Failed to load ratings. Please try again.</p>
                    </div>
                `;
            }
        };
        
        window.closeRatingModal = function() {
            const modal = document.getElementById('ratingViewModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        };
        
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
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
                    showToast('Note!', 'Product added to cart, but there was a connection issue.', 'success');
                    fetchCartCount();
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            });
        });
        
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('ratingViewModal');
            if (event.target === modal) {
                closeRatingModal();
            }
        });
        
        function showToast(title, message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            toast.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-circle-fill'}"></i>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
            `;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
        
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