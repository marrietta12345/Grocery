<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details | Grocery Mart</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* All your existing CSS styles remain exactly the same */
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
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .page-header h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }
        
        .order-number {
            color: var(--primary);
            font-size: 1.1rem;
        }
        
        /* Order Status */
        .status-bar {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--slate-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .status-badge {
            padding: 0.5rem 1.5rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .status-pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .status-processing {
            background: rgba(100, 116, 139, 0.1);
            color: var(--slate-600);
        }
        
        .status-completed {
            background: rgba(40, 167, 69, 0.1);
            color: var(--primary);
        }
        
        .status-cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }
        
        .status-shipped {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }
        
        .status-timeline {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        
        .timeline-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .timeline-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--slate-300);
        }
        
        .timeline-dot.completed {
            background: var(--primary);
        }
        
        .timeline-dot.active {
            background: var(--warning);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
        }
        
        /* Simple Tracking Timeline */
        .tracking-timeline-simple {
            background: var(--slate-50);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1rem;
        }
        
        .tracking-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 1rem 0;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .tracking-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 5%;
            right: 5%;
            height: 2px;
            background: var(--slate-200);
            z-index: 0;
        }
        
        .tracking-step {
            flex: 1;
            text-align: center;
            position: relative;
            z-index: 1;
            min-width: 70px;
        }
        
        .tracking-step-icon {
            width: 40px;
            height: 40px;
            background: white;
            border: 2px solid var(--slate-200);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            transition: all 0.3s;
        }
        
        .tracking-step.completed .tracking-step-icon {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        .tracking-step.pending .tracking-step-icon {
            border-color: var(--warning);
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .tracking-step-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--slate-500);
        }
        
        .tracking-step.completed .tracking-step-label {
            color: var(--primary);
        }
        
        .tracking-step.pending .tracking-step-label {
            color: var(--warning);
        }
        
        /* Tracking Modal */
        .tracking-modal {
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
        
        .tracking-modal.show {
            display: flex;
        }
        
        .tracking-modal-content {
            background: white;
            border-radius: 24px;
            max-width: 500px;
            width: 90%;
            padding: 2rem;
            animation: modalFadeIn 0.3s ease;
            max-height: 90vh;
            overflow-y: auto;
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
        
        .tracking-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .tracking-modal-header h3 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }
        
        .tracking-modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--slate-500);
            cursor: pointer;
        }
        
        .tracking-info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--slate-100);
        }
        
        .tracking-info-label {
            font-weight: 600;
            color: var(--slate-600);
        }
        
        .tracking-info-value {
            color: var(--slate-800);
            font-weight: 500;
        }
        
        .tracking-updates {
            margin-top: 1.5rem;
        }
        
        .tracking-update-item {
            display: flex;
            gap: 1rem;
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--slate-100);
            transition: all 0.3s;
        }
        
        .tracking-update-item:last-child {
            border-bottom: none;
        }
        
        .tracking-update-icon {
            width: 32px;
            height: 32px;
            background: var(--slate-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }
        
        .tracking-update-icon.completed {
            background: var(--primary);
            color: white;
        }
        
        .tracking-update-icon.pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .tracking-update-content {
            flex: 1;
        }
        
        .tracking-update-status {
            font-weight: 600;
            margin-bottom: 0.2rem;
        }
        
        .tracking-update-date {
            font-size: 0.75rem;
            color: var(--slate-500);
        }
        
        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid var(--slate-300);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Order Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        
        /* Order Items */
        .items-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
        }
        
        .section-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }
        
        .item-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .item-row:last-child {
            border-bottom: none;
        }
        
        .item-image {
            width: 60px;
            height: 60px;
            background: var(--slate-100);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .item-image i {
            font-size: 2rem;
            color: var(--primary);
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            font-weight: 600;
            margin-bottom: 0.2rem;
        }
        
        .item-meta {
            font-size: 0.85rem;
            color: var(--slate-500);
        }
        
        .item-price {
            font-weight: 700;
            color: var(--primary);
        }
        
        /* Review Button */
        .btn-review {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.75rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-review:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            color: white;
        }
        
        /* Order Received Button */
        .btn-received {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            width: 100%;
        }
        
        .btn-received:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }
        
        .rating-display {
            margin-top: 0.5rem;
        }
        
        .stars {
            color: #ffc107;
            font-size: 0.8rem;
        }
        
        .review-text {
            font-size: 0.75rem;
            color: var(--slate-500);
            margin-top: 0.25rem;
        }
        
        /* Cross Check Modal */
        .cross-check-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-bottom: 1px solid var(--slate-200);
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .cross-check-item:hover {
            background: var(--slate-50);
        }
        
        .cross-check-item.checked {
            background: var(--success-light);
        }
        
        .cross-check-item .check-icon {
            width: 24px;
            height: 24px;
            border: 2px solid var(--slate-300);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        
        .cross-check-item.checked .check-icon {
            background: var(--success);
            border-color: var(--success);
            color: white;
        }
        
        .cross-check-item.checked .check-icon i {
            font-size: 0.8rem;
        }
        
        /* Order Summary */
        .summary-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
            position: sticky;
            top: 2rem;
        }
        
        .info-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .info-title {
            font-weight: 600;
            color: var(--slate-600);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .info-content {
            color: var(--slate-800);
            line-height: 1.6;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            color: var(--slate-600);
        }
        
        .price-row.total {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--slate-200);
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .btn-primary-custom {
            flex: 1;
            background: var(--dark);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: var(--primary);
            color: white;
        }
        
        .btn-outline-custom {
            flex: 1;
            background: white;
            border: 1.5px solid var(--slate-200);
            color: var(--slate-600);
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }
        
        .btn-outline-custom:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        
        .btn-track-simple {
            width: 100%;
            background: var(--info);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 12px;
            font-weight: 600;
            margin-top: 0.5rem;
            transition: all 0.3s;
        }
        
        .btn-track-simple:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }
        
        .btn-danger-custom {
            background: white;
            border: 1.5px solid var(--danger);
            color: var(--danger);
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }
        
        .btn-danger-custom:hover {
            background: var(--danger);
            color: white;
        }
        
        .btn-success-custom {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }
        
        .cancel-button-container {
            margin-top: 1rem;
            width: 100%;
        }
        
        .btn-cancel-full {
            width: 100%;
            background: white;
            border: 1.5px solid var(--danger);
            color: var(--danger);
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
            display: inline-block;
        }
        
        /* Modal Styles */
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
            border-radius: 20px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            position: relative;
            animation: modalSlideIn 0.3s ease;
        }
        
        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .payment-info-box {
            background: var(--primary-light);
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: center;
            border: 1px solid var(--primary);
        }
        
        .payment-reference-display {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 1px;
            background: white;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            display: inline-block;
            margin: 0.5rem 0;
        }
        
        /* Reason Options */
        .reason-option {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1.5px solid var(--slate-200);
            border-radius: 12px;
            margin-bottom: 0.8rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .reason-option:hover {
            border-color: var(--primary);
            background: var(--slate-50);
        }
        
        .reason-option.selected {
            border-color: var(--primary);
            background: rgba(40, 167, 69, 0.05);
        }
        
        .reason-option input[type="radio"] {
            margin-right: 1rem;
            accent-color: var(--primary);
            width: 18px;
            height: 18px;
        }
        
        .reason-option label {
            flex: 1;
            cursor: pointer;
            font-weight: 500;
            margin: 0;
        }
        
        .other-reason-input {
            margin-top: 1rem;
            padding: 1rem;
            border: 1.5px solid var(--slate-200);
            border-radius: 12px;
            width: 100%;
            resize: vertical;
        }
        
        /* Toast Styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
        }
        
        .toast-custom {
            background: white;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideInRight 0.3s ease;
            border-left: 4px solid var(--primary);
            min-width: 300px;
        }
        
        @keyframes slideInRight {
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
            .details-grid {
                grid-template-columns: 1fr;
            }
            
            .status-bar {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .tracking-steps {
                flex-direction: column;
                gap: 1rem;
            }
            
            .tracking-steps::before {
                display: none;
            }
            
            .tracking-step {
                display: flex;
                align-items: center;
                gap: 1rem;
                text-align: left;
            }
            
            .tracking-step-icon {
                margin: 0;
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
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person-circle"></i> My Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="dropdown-header text-muted small">Help & Support</li>
                        <li><a class="dropdown-item" href="{{ route('faq') }}"><i class="bi bi-question-circle"></i> Frequently Asked Questions</a></li>
                        <li><a class="dropdown-item" href="{{ route('contact') }}"><i class="bi bi-headset"></i> Contact Support</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Sign Out</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Cancellation Modal -->
    <div class="modal-custom" id="cancellationModal">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <h3><i class="bi bi-x-circle text-danger me-2"></i> Cancel Order</h3>
                <button type="button" class="modal-close" onclick="closeModal()"><i class="bi bi-x"></i></button>
            </div>
            <div class="modal-body-custom">
                <form id="cancellationForm">
                    @csrf
                    <p class="text-muted mb-3">Please select a reason for cancelling this order:</p>
                    <div class="reason-option" onclick="selectReason(this, 'changed_mind')">
                        <input type="radio" name="cancellation_reason" value="Changed my mind">
                        <label>Changed my mind</label>
                    </div>
                    <div class="reason-option" onclick="selectReason(this, 'found_cheaper')">
                        <input type="radio" name="cancellation_reason" value="Found a cheaper price elsewhere">
                        <label>Found a cheaper price elsewhere</label>
                    </div>
                    <div class="reason-option" onclick="selectReason(this, 'wrong_item')">
                        <input type="radio" name="cancellation_reason" value="Ordered wrong item">
                        <label>Ordered wrong item</label>
                    </div>
                    <div class="reason-option" onclick="selectReason(this, 'other')">
                        <input type="radio" name="cancellation_reason" value="Other">
                        <label>Other (please specify)</label>
                    </div>
                    <textarea class="other-reason-input" id="otherReason" placeholder="Please specify your reason..." style="display: none;"></textarea>
                </form>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-outline-custom" onclick="closeModal()">No, Keep Order</button>
                <button type="button" class="btn btn-danger-custom" id="submitCancel" onclick="submitCancellation()">Yes, Cancel Order</button>
            </div>
        </div>
    </div>

    <!-- I Have Paid Modal (for online payments) -->
    <div class="modal-custom" id="confirmPaymentModal">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <h3><i class="bi bi-check-circle text-success me-2"></i> Confirm Payment</h3>
                <button type="button" class="modal-close" onclick="closePaymentModal()"><i class="bi bi-x"></i></button>
            </div>
            <div class="modal-body-custom">
                <div class="text-center mb-4">
                    <i class="bi bi-phone" style="font-size: 3rem; color: var(--primary);"></i>
                </div>
                <p class="text-center mb-3">Have you completed the payment for this order?</p>
                <div class="payment-info-box">
                    <div class="mb-2"><span class="text-muted">Order Number:</span><br><strong>{{ $order->order_number }}</strong></div>
                    <div class="mb-2"><span class="text-muted">Payment Reference:</span><br><span class="payment-reference-display">{{ $order->payment ? $order->payment->payment_reference : 'N/A' }}</span></div>
                    <div class="mb-2"><span class="text-muted">Amount:</span><br><strong class="text-primary">₱{{ number_format($order->total, 2) }}</strong></div>
                </div>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Important:</strong> By confirming, you verify that you have successfully completed the payment.
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-outline-custom" onclick="closePaymentModal()">No, I haven't paid</button>
                <button type="button" class="btn btn-success-custom" id="submitPaymentConfirm" onclick="submitPaymentConfirmation()">Yes, I have paid</button>
            </div>
        </div>
    </div>

    <!-- Cross Check Modal (Order Received for COD) -->
    <div class="modal-custom" id="crossCheckModal">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <h3><i class="bi bi-check2-circle text-success me-2"></i> Confirm Order Received</h3>
                <button type="button" class="modal-close" onclick="closeCrossCheckModal()"><i class="bi bi-x"></i></button>
            </div>
            <div class="modal-body-custom">
                <p class="text-muted mb-3">Please confirm that you have received all items:</p>
                <div id="itemsList">
                    @foreach($order->items as $item)
                    <div class="cross-check-item" data-item-id="{{ $item->id }}" onclick="toggleCheckItem(this)">
                        <div class="check-icon"><i class="bi"></i></div>
                        <div>
                            <strong>{{ $item->product_name }}</strong>
                            <div class="text-muted small">Quantity: {{ $item->quantity }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Note:</strong> Please check all items before confirming receipt. This will mark your order as paid.
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-outline-custom" onclick="closeCrossCheckModal()">Cancel</button>
                <button type="button" class="btn btn-success-custom" id="confirmReceivedBtn" onclick="confirmReceived()">Confirm All Received & Pay</button>
            </div>
        </div>
    </div>

    <!-- Tracking Modal -->
    <div class="tracking-modal" id="trackingModal">
        <div class="tracking-modal-content">
            <div class="tracking-modal-header">
                <h3><i class="bi bi-truck me-2"></i> Order Tracking</h3>
                <button class="tracking-modal-close" onclick="closeTrackingModal()"><i class="bi bi-x"></i></button>
            </div>
            <div id="trackingModalContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading tracking data...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h1>Order Details</h1>
                    <p class="order-number">Order #{{ $order->order_number }}</p>
                </div>
                <a href="{{ route('order.history') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back to Orders</a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Order Status Bar -->
            <div class="status-bar">
                @php
                    $statusClass = '';
                    if ($order->status == 'pending') $statusClass = 'status-pending';
                    elseif ($order->status == 'processing') $statusClass = 'status-processing';
                    elseif ($order->status == 'shipped') $statusClass = 'status-shipped';
                    elseif ($order->status == 'completed') $statusClass = 'status-completed';
                    elseif ($order->status == 'cancelled') $statusClass = 'status-cancelled';
                @endphp
                
                <span class="status-badge {{ $statusClass }}">
                    @if($order->status == 'completed')<i class="bi bi-check-circle me-2"></i>
                    @elseif($order->status == 'cancelled')<i class="bi bi-x-circle me-2"></i>
                    @elseif($order->status == 'shipped')<i class="bi bi-truck me-2"></i>
                    @else<i class="bi bi-clock me-2"></i>@endif
                    {{ ucfirst($order->status) }}
                </span>
                
                <div class="status-timeline">
                    <div class="timeline-item"><div class="timeline-dot {{ in_array($order->status, ['pending', 'processing', 'shipped', 'completed']) ? 'completed' : '' }}"></div><span>Order Placed</span></div>
                    <div class="timeline-item"><div class="timeline-dot {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'completed' : ($order->status == 'pending' ? 'active' : '') }}"></div><span>Processing</span></div>
                    <div class="timeline-item"><div class="timeline-dot {{ in_array($order->status, ['shipped', 'completed']) ? 'completed' : ($order->status == 'processing' ? 'active' : '') }}"></div><span>Shipped</span></div>
                    <div class="timeline-item"><div class="timeline-dot {{ $order->status == 'completed' ? 'completed' : ($order->status == 'shipped' ? 'active' : '') }}"></div><span>Delivered</span></div>
                </div>
            </div>
            
            <!-- Order Details Grid -->
            <div class="details-grid">
                <!-- Order Items -->
                <div class="items-card">
                    <h5 class="section-title"><i class="bi bi-box me-2" style="color: var(--primary);"></i> Order Items ({{ $order->items->count() }})</h5>
                    @foreach($order->items as $item)
                    <div class="item-row">
                        <div class="item-image">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}">
                            @else
                                <i class="bi bi-box"></i>
                            @endif
                        </div>
                        <div class="item-details">
                            <div class="item-name">{{ $item->product_name }}</div>
                            <div class="item-meta">SKU: {{ $item->product_sku ?? 'N/A' }} | Qty: {{ $item->quantity }}</div>
                            
                            <!-- Show existing rating if available -->
                            @php
                                $userRating = $item->product ? $item->product->ratings()->where('user_id', auth()->id())->first() : null;
                            @endphp
                            @if($userRating)
                            <div class="rating-display">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star-fill {{ $i <= $userRating->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                    @endfor
                                    <span class="text-muted ms-1 small">({{ $userRating->rating }}/5)</span>
                                </div>
                                @if($userRating->review)
                                <div class="review-text">
                                    <i class="bi bi-chat-quote"></i> "{{ Str::limit($userRating->review, 80) }}"
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="item-price text-end">
                            <div>₱{{ number_format($item->price * $item->quantity, 2) }}</div>
                            @if($order->status == 'completed' && !$userRating)
                            <a href="{{ route('ratings.create', ['order' => $order->id, 'product' => $item->product_id]) }}" class="btn-review mt-2">
                                <i class="bi bi-star"></i> Write a Review
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Order Summary -->
                <div class="summary-card">
                    <h5 class="section-title"><i class="bi bi-receipt me-2" style="color: var(--primary);"></i> Order Summary</h5>
                    
                    <div class="info-section">
                        <div class="info-title">Order Date</div>
                        <div class="info-content">{{ $order->created_at->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</div>
                    </div>
                    
                    <div class="info-section">
                        <div class="info-title">Payment Method</div>
                        <div class="info-content">
                            @switch($order->payment_method)
                                @case('cod') Cash on Delivery @break
                                @case('gcash') GCash @break
                                @case('paymaya') PayMaya @break
                                @default {{ ucfirst($order->payment_method) }}
                            @endswitch
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <div class="info-title">Payment Status</div>
                        <div class="info-content">
                            @if($order->payment_method == 'cod' && $order->payment_status == 'unpaid')
                                <span class="badge bg-warning text-dark">Pending Payment (COD)</span>
                            @elseif($order->payment_status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($order->payment_status) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <div class="info-title">Shipping Address</div>
                        <div class="info-content">{{ $order->shipping_address }}</div>
                    </div>
                    
                    @if($order->status == 'shipped' && $order->tracking_number)
                    <div class="info-section">
                        <div class="info-title">Tracking Number</div>
                        <div class="info-content" id="trackingNumberDisplay">{{ $order->tracking_number }}</div>
                    </div>
                    @endif
                    
                    <!-- Simple Tracking Timeline - Full 6-step timeline -->
                    @if($order->status == 'shipped' || $order->status == 'completed')
                    <div class="tracking-timeline-simple">
                        <div class="tracking-steps" id="liveTrackingSteps">
                            <div class="tracking-step" id="orderPlacedStep">
                                <div class="tracking-step-icon"><i class="bi bi-check-lg"></i></div>
                                <div class="tracking-step-label">Order Placed</div>
                            </div>
                            <div class="tracking-step" id="paymentStep">
                                <div class="tracking-step-icon"><i class="bi bi-credit-card"></i></div>
                                <div class="tracking-step-label">Payment</div>
                            </div>
                            <div class="tracking-step" id="shippedStep">
                                <div class="tracking-step-icon"><i class="bi bi-truck"></i></div>
                                <div class="tracking-step-label">Shipped</div>
                            </div>
                            <div class="tracking-step" id="sortingStep">
                                <div class="tracking-step-icon"><i class="bi bi-building"></i></div>
                                <div class="tracking-step-label">Sorting Facility</div>
                            </div>
                            <div class="tracking-step" id="outForDeliveryStep">
                                <div class="tracking-step-icon"><i class="bi bi-geo-alt"></i></div>
                                <div class="tracking-step-label">Out for Delivery</div>
                            </div>
                            <div class="tracking-step" id="deliveredStep">
                                <div class="tracking-step-icon"><i class="bi bi-check-circle"></i></div>
                                <div class="tracking-step-label">Delivered</div>
                            </div>
                        </div>
                        <button class="btn-track-simple" onclick="openTrackingModal()">
                            <i class="bi bi-geo-alt"></i> Track Order
                        </button>
                    </div>
                    @endif
                    
                    <div class="price-row"><span>Subtotal</span><span>₱{{ number_format($order->subtotal, 2) }}</span></div>
                    @if($order->discount > 0)<div class="price-row"><span>Discount</span><span class="text-success">-₱{{ number_format($order->discount, 2) }}</span></div>@endif
                    <div class="price-row"><span>Shipping Fee</span><span>₱{{ number_format($order->shipping_fee, 2) }}</span></div>
                    <div class="price-row total"><span>Total</span><span class="text-primary">₱{{ number_format($order->total, 2) }}</span></div>
                    
                    <div class="action-buttons">
                        <a href="{{ route('payment.receipt', $order) }}" class="btn-primary-custom"><i class="bi bi-receipt"></i> Receipt</a>
                        @if($order->status == 'pending' && in_array($order->payment_method, ['gcash', 'paymaya']) && $order->payment_status != 'paid')
                            <button type="button" onclick="openPaymentModal()" class="btn-success-custom"><i class="bi bi-check-circle"></i> I Have Paid</button>
                        @endif
                    </div>
                    
                    <!-- Order Received Button for COD orders that are delivered but not paid -->
                    @if($order->payment_method == 'cod' && $order->shipping_status == 'delivered' && $order->payment_status != 'paid' && $order->status != 'cancelled')
                        <div class="mt-3">
                            <button type="button" onclick="openCrossCheckModal()" class="btn-received">
                                <i class="bi bi-check2-circle"></i> I Have Received the Order
                            </button>
                        </div>
                    @endif
                    
                    @if($order->status == 'pending')
                        <div class="cancel-button-container">
                            <button type="button" onclick="openModal()" class="btn-cancel-full"><i class="bi bi-x-circle"></i> Cancel Order</button>
                        </div>
                    @endif
                    
                    @if($order->payment_status == 'unpaid' && $order->payment_method != 'cod' && $order->status != 'cancelled' && $order->status != 'processing' && $order->status != 'shipped')
                        <a href="{{ route('payment.process', ['order' => $order, 'method' => $order->payment_method]) }}" class="btn btn-warning w-100 mt-3"><i class="bi bi-credit-card"></i> Complete Payment</a>
                    @endif
                </div>
            </div>
        </div>
    </main>


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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    let checkedItems = [];
    let selectedOrderId = null;
    
    // Cross Check Functions for COD Order Received
    function toggleCheckItem(element) {
        element.classList.toggle('checked');
        const itemId = element.dataset.itemId;
        const icon = element.querySelector('.check-icon i');
        
        if (element.classList.contains('checked')) {
            icon.className = 'bi bi-check-lg';
            if (!checkedItems.includes(itemId)) {
                checkedItems.push(itemId);
            }
        } else {
            icon.className = 'bi';
            checkedItems = checkedItems.filter(id => id !== itemId);
        }
    }
    
    function openCrossCheckModal() {
        checkedItems = [];
        document.querySelectorAll('.cross-check-item').forEach(item => {
            item.classList.remove('checked');
            const icon = item.querySelector('.check-icon i');
            icon.className = 'bi';
        });
        document.getElementById('crossCheckModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    
    function closeCrossCheckModal() {
        document.getElementById('crossCheckModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }
    
    function confirmReceived() {
        const totalItems = document.querySelectorAll('.cross-check-item').length;
        
        if (checkedItems.length !== totalItems) {
            showToast('Please check all items before confirming receipt.', 'warning');
            return;
        }
        
        const confirmBtn = document.getElementById('confirmReceivedBtn');
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
        
        fetch('{{ route("order.confirm-received", $order->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                order_id: {{ $order->id }}
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Order confirmed as received! Payment status updated to paid.', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showToast(data.message || 'Failed to confirm order receipt.', 'error');
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = 'Confirm All Received & Pay';
            }
            closeCrossCheckModal();
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred. Please try again.', 'error');
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = 'Confirm All Received & Pay';
            closeCrossCheckModal();
        });
    }
    
    // Helper function to check if a date is valid and not in the future
    function isValidCompletedDate(dateString) {
        if (!dateString) return false;
        try {
            const date = new Date(dateString);
            const now = new Date();
            return !isNaN(date.getTime()) && date <= now;
        } catch (e) {
            return false;
        }
    }
    
    // Helper function to format date for display
    function formatDateForDisplay(dateString) {
        if (!dateString) return null;
        try {
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return dateString;
            const now = new Date();
            if (date > now) {
                return `Scheduled for ${date.toLocaleString()}`;
            }
            return date.toLocaleString();
        } catch (e) {
            return dateString;
        }
    }
    
    // Function to fetch tracking data from database
    async function fetchTrackingData() {
        try {
            const response = await fetch('{{ route("order.tracking.data", $order->id) }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                cache: 'no-cache'
            });
            
            if (!response.ok) {
                throw new Error('Failed to fetch tracking data');
            }
            
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error fetching tracking data:', error);
            return null;
        }
    }
    
    // Function to update the main page timeline
    async function updateMainPageTimelineOnLoad() {
        const trackingData = await fetchTrackingData();
        if (trackingData) {
            updateMainPageTimeline(trackingData);
        }
    }
    
    // Function to update tracking display
    async function updateTrackingDisplay() {
        const modalContent = document.getElementById('trackingModalContent');
        const trackingData = await fetchTrackingData();
        
        if (!trackingData) {
            modalContent.innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="bi bi-exclamation-circle fs-1"></i>
                    <p class="mt-2">Failed to load tracking data. Please try again.</p>
                </div>
            `;
            return;
        }
        
        let updatesHtml = `
            <div class="tracking-info-row">
                <span class="tracking-info-label">Tracking Number:</span>
                <span class="tracking-info-value">${trackingData.tracking_number || 'N/A'}</span>
            </div>
            <div class="tracking-info-row">
                <span class="tracking-info-label">Courier:</span>
                <span class="tracking-info-value">${trackingData.courier_name || 'Not Assigned'}</span>
            </div>
            <div class="tracking-info-row">
                <span class="tracking-info-label">Shipped Date:</span>
                <span class="tracking-info-value">${trackingData.shipped_date || 'Pending'}</span>
            </div>
            <div class="tracking-info-row">
                <span class="tracking-info-label">Order Status:</span>
                <span class="tracking-info-value">${trackingData.order_status || 'Pending'}</span>
            </div>
            <div class="tracking-info-row">
                <span class="tracking-info-label">Shipping Status:</span>
                <span class="tracking-info-value">${trackingData.shipping_status || 'Pending'}</span>
            </div>
            <div class="tracking-updates">
                <h5 class="mb-3">Delivery Timeline</h5>
        `;
        
        const timelineItems = [];
        
        if (trackingData.created_at && isValidCompletedDate(trackingData.created_at)) {
            timelineItems.push({ status: "Order Placed", date: trackingData.created_at, completed: true, icon: "check-circle-fill" });
        } else if (trackingData.created_at) {
            timelineItems.push({ status: "Order Placed", date: formatDateForDisplay(trackingData.created_at), completed: false, icon: "clock-history" });
        } else {
            timelineItems.push({ status: "Order Placed", date: "Pending", completed: false, icon: "clock-history" });
        }
        
        if (trackingData.paid_at && isValidCompletedDate(trackingData.paid_at)) {
            timelineItems.push({ status: "Payment Confirmed", date: trackingData.paid_at, completed: true, icon: "credit-card" });
        } else if (trackingData.paid_at) {
            timelineItems.push({ status: "Payment Confirmed", date: formatDateForDisplay(trackingData.paid_at), completed: false, icon: "hourglass-split" });
        } else {
            timelineItems.push({ status: "Payment Confirmed", date: "Awaiting payment", completed: false, icon: "hourglass-split" });
        }
        
        if (trackingData.shipped_at && isValidCompletedDate(trackingData.shipped_at)) {
            timelineItems.push({ status: "Order Shipped", date: trackingData.shipped_at, completed: true, icon: "truck" });
        } else if (trackingData.shipped_at) {
            timelineItems.push({ status: "Order Shipped", date: formatDateForDisplay(trackingData.shipped_at), completed: false, icon: "hourglass-split" });
        } else {
            timelineItems.push({ status: "Order Shipped", date: "Awaiting shipment", completed: false, icon: "hourglass-split" });
        }
        
        if (trackingData.arrived_at_sorting_at && isValidCompletedDate(trackingData.arrived_at_sorting_at)) {
            timelineItems.push({ status: "Arrived at Sorting Facility", date: trackingData.arrived_at_sorting_at, completed: true, icon: "building" });
        } else if (trackingData.arrived_at_sorting_at) {
            timelineItems.push({ status: "Arrived at Sorting Facility", date: formatDateForDisplay(trackingData.arrived_at_sorting_at), completed: false, icon: "hourglass-split" });
        } else {
            timelineItems.push({ status: "Arrived at Sorting Facility", date: "Pending", completed: false, icon: "clock-history" });
        }
        
        if (trackingData.out_for_delivery_at && isValidCompletedDate(trackingData.out_for_delivery_at)) {
            timelineItems.push({ status: "Out for Delivery", date: trackingData.out_for_delivery_at, completed: true, icon: "geo-alt" });
        } else if (trackingData.out_for_delivery_at) {
            timelineItems.push({ status: "Out for Delivery", date: formatDateForDisplay(trackingData.out_for_delivery_at), completed: false, icon: "hourglass-split" });
        } else {
            timelineItems.push({ status: "Out for Delivery", date: "Pending", completed: false, icon: "clock-history" });
        }
        
        if (trackingData.delivered_at && isValidCompletedDate(trackingData.delivered_at)) {
            timelineItems.push({ status: "Delivered", date: trackingData.delivered_at, completed: true, icon: "check-circle" });
        } else if (trackingData.delivered_at) {
            timelineItems.push({ status: "Delivered", date: formatDateForDisplay(trackingData.delivered_at), completed: false, icon: "clock-history" });
        } else {
            timelineItems.push({ status: "Delivered", date: "Pending", completed: false, icon: "clock-history" });
        }
        
        timelineItems.forEach((item) => {
            updatesHtml += `
                <div class="tracking-update-item">
                    <div class="tracking-update-icon ${item.completed ? 'completed' : 'pending'}">
                        <i class="bi bi-${item.icon}"></i>
                    </div>
                    <div class="tracking-update-content">
                        <div class="tracking-update-status">${item.status}</div>
                        <div class="tracking-update-date">${item.date}</div>
                        ${item.completed ? '<span class="badge bg-success mt-1">Completed</span>' : '<span class="badge bg-warning mt-1">Pending</span>'}
                    </div>
                </div>
            `;
        });
        
        updatesHtml += `</div>`;
        modalContent.innerHTML = updatesHtml;
        updateMainPageTimeline(trackingData);
    }
    
    function updateMainPageTimeline(trackingData) {
        const orderPlacedStep = document.getElementById('orderPlacedStep');
        const paymentStep = document.getElementById('paymentStep');
        const shippedStep = document.getElementById('shippedStep');
        const sortingStep = document.getElementById('sortingStep');
        const outForDeliveryStep = document.getElementById('outForDeliveryStep');
        const deliveredStep = document.getElementById('deliveredStep');
        
        function updateStep(stepElement, dateValue) {
            if (!stepElement) return;
            stepElement.classList.remove('completed', 'pending');
            if (dateValue && isValidCompletedDate(dateValue)) {
                stepElement.classList.add('completed');
            } else {
                stepElement.classList.add('pending');
            }
        }
        
        updateStep(orderPlacedStep, trackingData.created_at);
        updateStep(paymentStep, trackingData.paid_at);
        updateStep(shippedStep, trackingData.shipped_at);
        updateStep(sortingStep, trackingData.arrived_at_sorting_at);
        updateStep(outForDeliveryStep, trackingData.out_for_delivery_at);
        updateStep(deliveredStep, trackingData.delivered_at);
    }
    
    window.openTrackingModal = async function() {
        document.getElementById('trackingModal').classList.add('show');
        document.body.style.overflow = 'hidden';
        await updateTrackingDisplay();
    };
    
    window.closeTrackingModal = function() {
        document.getElementById('trackingModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    };
    
    window.openModal = function() {
        document.getElementById('cancellationModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    };
    
    window.closeModal = function() {
        document.getElementById('cancellationModal').classList.remove('show');
        document.body.style.overflow = 'auto';
        var options = document.querySelectorAll('.reason-option');
        for (var i = 0; i < options.length; i++) options[i].classList.remove('selected');
        var radios = document.querySelectorAll('input[name="cancellation_reason"]');
        for (var i = 0; i < radios.length; i++) radios[i].checked = false;
        var otherReason = document.getElementById('otherReason');
        if (otherReason) { otherReason.style.display = 'none'; otherReason.value = ''; }
    };
    
    window.openPaymentModal = function() {
        document.getElementById('confirmPaymentModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    };
    
    window.closePaymentModal = function() {
        document.getElementById('confirmPaymentModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    };
    
    window.selectReason = function(element, reason) {
        var options = document.querySelectorAll('.reason-option');
        for (var i = 0; i < options.length; i++) options[i].classList.remove('selected');
        element.classList.add('selected');
        var radio = element.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
        var otherReason = document.getElementById('otherReason');
        if (reason === 'other') otherReason.style.display = 'block';
        else otherReason.style.display = 'none';
    };
    
    window.submitCancellation = function() {
        var selectedRadio = document.querySelector('input[name="cancellation_reason"]:checked');
        var otherReason = document.getElementById('otherReason');
        var reason = '';
        if (selectedRadio) {
            if (selectedRadio.value === 'Other' && otherReason && otherReason.style.display === 'block' && otherReason.value.trim() !== '') reason = otherReason.value.trim();
            else reason = selectedRadio.value;
        }
        if (!reason) { showToast('Please select or enter a cancellation reason', 'warning'); return; }
        var submitBtn = document.getElementById('submitCancel');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
        var formData = new FormData();
        formData.append('cancellation_reason', reason);
        formData.append('_token', '{{ csrf_token() }}');
        fetch('{{ route('order.cancel', $order) }}', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) { showToast('Order cancelled successfully', 'success'); setTimeout(() => window.location.reload(), 1000); }
            else { showToast(data.message || 'Failed to cancel order', 'error'); submitBtn.disabled = false; submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Yes, Cancel Order'; }
            closeModal();
        })
        .catch(error => { console.error('Error:', error); showToast('An error occurred. Please try again.', 'error'); submitBtn.disabled = false; submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Yes, Cancel Order'; closeModal(); });
    };
    
    window.submitPaymentConfirmation = function() {
        var submitBtn = document.getElementById('submitPaymentConfirm');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
        var form = document.getElementById('confirmPaymentForm');
        if (form) {
            form.action = '{{ route("payment.callback") }}';
            form.submit();
        }
    };
    
    function showToast(message, type) {
        if (!type) type = 'success';
        var toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;
        var toast = document.createElement('div');
        toast.className = 'toast-custom ' + type;
        var icon = type === 'success' ? 'check-circle-fill' : (type === 'error' ? 'exclamation-circle-fill' : 'info-circle-fill');
        var title = type === 'success' ? 'Success' : (type === 'error' ? 'Error' : 'Information');
        toast.innerHTML = '<div class="toast-icon text-' + type + '"><i class="bi bi-' + icon + '"></i></div>' +
            '<div class="toast-content"><div class="toast-title">' + title + '</div><div class="toast-message">' + message + '</div></div>' +
            '<button class="toast-close" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>';
        toastContainer.appendChild(toast);
        setTimeout(function() { if (toast.parentNode) toast.remove(); }, 5000);
    }
    
    window.addEventListener('click', function(event) {
        var cancelModal = document.getElementById('cancellationModal');
        var paymentModal = document.getElementById('confirmPaymentModal');
        var crossCheckModal = document.getElementById('crossCheckModal');
        var trackingModal = document.getElementById('trackingModal');
        if (event.target === cancelModal) closeModal();
        if (event.target === paymentModal) closePaymentModal();
        if (event.target === crossCheckModal) closeCrossCheckModal();
        if (event.target === trackingModal) closeTrackingModal();
    });
    
    window.showToast = showToast;
    
    document.addEventListener('DOMContentLoaded', function() {
        updateMainPageTimelineOnLoad();
    });
    </script>
</body>
</html>