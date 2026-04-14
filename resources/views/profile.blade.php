<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Grocery Mart</title>
    
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
        }
        
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-header h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--slate-800);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .page-header p {
            color: var(--slate-500);
            font-size: 1rem;
        }
        
        /* Profile Cards */
        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--slate-200);
            margin-bottom: 2rem;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .profile-avatar-large {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary), var(--dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 2.5rem;
        }
        
        .profile-title h2 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--slate-800);
            margin-bottom: 0.3rem;
        }
        
        .profile-title p {
            color: var(--slate-500);
            margin: 0;
        }
        
        /* Form Styles */
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
        
        .btn-primary-custom {
            background: var(--dark);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }
        
        .btn-outline-custom {
            background: white;
            border: 1.5px solid var(--slate-200);
            color: var(--slate-600);
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-outline-custom:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        
        .btn-danger-custom {
            background: white;
            border: 1.5px solid var(--danger);
            color: var(--danger);
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-danger-custom:hover {
            background: var(--danger);
            color: white;
        }
        
        /* Address Cards */
        .addresses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .address-card {
            background: var(--slate-50);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid var(--slate-200);
            position: relative;
            transition: all 0.3s ease;
        }
        
        .address-card:hover {
            border-color: var(--primary);
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.1);
        }
        
        .address-card.default {
            border: 2px solid var(--primary);
            background: linear-gradient(to bottom, white, var(--slate-50));
        }
        
        .default-badge {
            position: absolute;
            top: -10px;
            right: 20px;
            background: var(--primary);
            color: white;
            padding: 0.3rem 1rem;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .address-type {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .type-home {
            background: rgba(40, 167, 69, 0.1);
            color: var(--primary);
        }
        
        .type-work {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }
        
        .type-other {
            background: rgba(100, 116, 139, 0.1);
            color: var(--slate-600);
        }
        
        .address-details {
            margin-bottom: 1rem;
        }
        
        .address-details p {
            margin-bottom: 0.3rem;
            color: var(--slate-600);
            font-size: 0.9rem;
        }
        
        .address-details i {
            width: 20px;
            color: var(--primary);
            margin-right: 0.5rem;
        }
        
        .address-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--slate-200);
        }
        
        .address-actions button, .address-actions form {
            flex: 1;
        }
        
        /* Modal Styles */
        .modal-content {
            border-radius: 20px;
            border: none;
            padding: 1rem;
        }
        
        .modal-header {
            border-bottom: 1px solid var(--slate-200);
            padding: 1.5rem;
        }
        
        .modal-title {
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
        
        /* Alert */
        .alert-custom {
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 2rem;
            border: none;
        }
        
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .addresses-grid {
                grid-template-columns: 1fr;
            }
        }

                /* Footer Styles - Matching contact.blade.php */
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
                    
                    <!-- Navigation -->
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
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h1>My Profile</h1>
                    <p>Manage your personal information and delivery addresses</p>
                </div>
                <a href="{{ route('dashboard') }}" class="btn-outline-custom">
                    <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger alert-custom">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
            
            <!-- Profile Information -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar-large">
                        {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                    </div>
                    <div class="profile-title">
                        <h2>{{ $user->first_name }} {{ $user->middle_name ? $user->middle_name . ' ' : '' }}{{ $user->last_name }}</h2>
                        <p><i class="bi bi-envelope me-2"></i>{{ $user->email }}</p>
                        <p><i class="bi bi-calendar me-2"></i>Member since {{ $user->created_at->format('F Y') }}</p>
                    </div>
                </div>
                
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Middle Name (Optional)</label>
                            <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $user->middle_name) }}">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn-primary-custom">
                                <i class="bi bi-check-lg me-2"></i>Update Profile
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Saved Addresses -->
            <div class="profile-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 style="font-family: 'Outfit', sans-serif; font-weight: 700; margin: 0;">
                        <i class="bi bi-geo-alt me-2" style="color: var(--primary);"></i>Saved Addresses
                    </h3>
                   
                </div>
                
                @if($addresses->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-geo-alt" style="font-size: 4rem; color: var(--slate-300);"></i>
                        <h4 class="mt-3 text-muted">No addresses saved yet</h4>
                        <p class="text-muted">Add your first delivery address to get started!</p>
                        <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                            <i class="bi bi-plus-lg me-2"></i>Add Address
                        </button>
                    </div>
                @else
                    <div class="addresses-grid">
                        @foreach($addresses as $address)
                            <div class="address-card {{ $address->is_default ? 'default' : '' }}">
                                @if($address->is_default)
                                    <span class="default-badge">
                                        <i class="bi bi-star-fill me-1"></i>Default
                                    </span>
                                @endif
                                
                                <span class="address-type type-{{ $address->address_type }}">
                                    <i class="bi bi-{{ $address->address_type == 'home' ? 'house' : ($address->address_type == 'work' ? 'briefcase' : 'pin-map') }} me-1"></i>
                                    {{ ucfirst($address->address_type) }}
                                </span>
                                
                                <div class="address-details">
                                    <p><i class="bi bi-person"></i>{{ $address->recipient_name }}</p>
                                    <p><i class="bi bi-telephone"></i>{{ $address->recipient_phone }}</p>
                                    <p><i class="bi bi-geo-alt"></i>{{ $address->address_line1 }}</p>
                                    @if($address->address_line2)
                                        <p><i class="bi bi-geo"></i>{{ $address->address_line2 }}</p>
                                    @endif
                                    <p>{{ $address->barangay }}, {{ $address->city }}</p>
                                    <p>{{ $address->province }} {{ $address->postal_code }}</p>
                                    @if($address->delivery_instructions)
                                        <p class="mt-2"><i class="bi bi-info-circle"></i><small>{{ $address->delivery_instructions }}</small></p>
                                    @endif
                                </div>
                                
                                <div class="address-actions">
                                    @if(!$address->is_default)
                                        <form action="{{ route('addresses.default', $address) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-outline-custom w-100" style="padding: 8px;">
                                                <i class="bi bi-star"></i> Set Default
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <button type="button" class="btn-outline-custom w-100" style="padding: 8px;" 
                                            onclick="editAddress({{ json_encode($address) }})">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    
                                    <form action="{{ route('addresses.delete', $address) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this address?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-custom w-100" style="padding: 8px;">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
    
    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addresses.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address Type</label>
                                <select name="address_type" class="form-select" required>
                                    <option value="home">Home</option>
                                    <option value="work">Work</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Set as Default</label>
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="is_default" class="form-check-input" value="1" id="defaultAddress">
                                    <label class="form-check-label" for="defaultAddress">Use as default delivery address</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Recipient Name</label>
                                <input type="text" name="recipient_name" class="form-control" value="{{ $user->first_name }} {{ $user->last_name }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Recipient Phone</label>
                                <input type="text" name="recipient_phone" class="form-control" placeholder="e.g., 09123456789" required>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Street Address / Building / Unit</label>
                                <input type="text" name="address_line1" class="form-control" placeholder="e.g., 123 Mabini St, Unit 45" required>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Address Line 2 (Optional)</label>
                                <input type="text" name="address_line2" class="form-control" placeholder="e.g., Landmark, Subdivision">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Barangay</label>
                                <input type="text" name="barangay" class="form-control" placeholder="e.g., Barangay San Jose" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">City / Municipality</label>
                                <input type="text" name="city" class="form-control" placeholder="e.g., Manila" required>
                            </div>
                            
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Province</label>
                                <input type="text" name="province" class="form-control" placeholder="e.g., Metro Manila" required>
                            </div>
                            
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control" placeholder="e.g., 1000" required>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Delivery Instructions (Optional)</label>
                                <textarea name="delivery_instructions" class="form-control" rows="2" placeholder="e.g., Leave at gate, Call upon arrival"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-primary-custom">Save Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Address Modal -->
    <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAddressModalLabel">Edit Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="editAddressForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address Type</label>
                                <select name="address_type" id="edit_address_type" class="form-select" required>
                                    <option value="home">Home</option>
                                    <option value="work">Work</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Set as Default</label>
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="is_default" class="form-check-input" value="1" id="edit_defaultAddress">
                                    <label class="form-check-label" for="edit_defaultAddress">Use as default delivery address</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Recipient Name</label>
                                <input type="text" name="recipient_name" id="edit_recipient_name" class="form-control" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Recipient Phone</label>
                                <input type="text" name="recipient_phone" id="edit_recipient_phone" class="form-control" required>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Street Address / Building / Unit</label>
                                <input type="text" name="address_line1" id="edit_address_line1" class="form-control" required>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Address Line 2 (Optional)</label>
                                <input type="text" name="address_line2" id="edit_address_line2" class="form-control">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Barangay</label>
                                <input type="text" name="barangay" id="edit_barangay" class="form-control" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">City / Municipality</label>
                                <input type="text" name="city" id="edit_city" class="form-control" required>
                            </div>
                            
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Province</label>
                                <input type="text" name="province" id="edit_province" class="form-control" required>
                            </div>
                            
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" id="edit_postal_code" class="form-control" required>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Delivery Instructions (Optional)</label>
                                <textarea name="delivery_instructions" id="edit_delivery_instructions" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-primary-custom">Update Address</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

     <!-- Footer - Add this exactly as shown -->
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

    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Edit address function
        function editAddress(address) {
            console.log('Editing address:', address); // For debugging
            
            // Set form action URL - using the correct route
            document.getElementById('editAddressForm').action = '/addresses/' + address.id;
            
            // Fill form fields with address data
            document.getElementById('edit_address_type').value = address.address_type;
            document.getElementById('edit_recipient_name').value = address.recipient_name;
            document.getElementById('edit_recipient_phone').value = address.recipient_phone;
            document.getElementById('edit_address_line1').value = address.address_line1;
            document.getElementById('edit_address_line2').value = address.address_line2 || '';
            document.getElementById('edit_barangay').value = address.barangay;
            document.getElementById('edit_city').value = address.city;
            document.getElementById('edit_province').value = address.province;
            document.getElementById('edit_postal_code').value = address.postal_code;
            document.getElementById('edit_delivery_instructions').value = address.delivery_instructions || '';
            document.getElementById('edit_defaultAddress').checked = address.is_default == 1;
            
            // Show the modal
            var editModal = new bootstrap.Modal(document.getElementById('editAddressModal'));
            editModal.show();
        }

        // Debug: Check if Bootstrap is loaded
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap is not loaded!');
            } else {
                console.log('Bootstrap is loaded successfully');
            }
            
            // Test if modal can be opened programmatically
            var addModalButton = document.querySelector('[data-bs-target="#addAddressModal"]');
            if (addModalButton) {
                console.log('Add address button found');
            } else {
                console.error('Add address button not found');
            }
        });

    </script>

    
</body>
</html>