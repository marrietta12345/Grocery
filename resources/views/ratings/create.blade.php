<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Product | Grocery Mart</title>
    
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
        
        .rating-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .rating-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--slate-200);
        }
        
        .product-info {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--slate-200);
        }
        
        .product-image {
            width: 120px;
            height: 120px;
            margin: 0 auto 1rem;
            background: var(--slate-100);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
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
        
        .product-name {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .order-number {
            color: var(--slate-500);
            font-size: 0.9rem;
        }
        
        /* Star Rating */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }
        
        .star-rating input {
            display: none;
        }
        
        .star-rating label {
            font-size: 2.5rem;
            color: var(--slate-300);
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #ffc107;
        }
        
        .rating-text {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: var(--slate-600);
        }
        
        /* Form Styles */
        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--slate-700);
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border-radius: 12px;
            border: 1.5px solid var(--slate-200);
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.1);
            outline: none;
        }
        
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
        
        /* Image Preview */
        .image-preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .image-preview {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--slate-200);
        }
        
        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .image-preview:hover .remove-image {
            opacity: 1;
        }
        
        /* Buttons */
        .btn-submit {
            width: 100%;
            background: var(--dark);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        
        .btn-submit:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }
        
        .btn-cancel {
            width: 100%;
            background: white;
            border: 1.5px solid var(--slate-200);
            color: var(--slate-600);
            padding: 1rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        
        .btn-cancel:hover {
            border-color: var(--danger);
            color: var(--danger);
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
        
        @media (max-width: 768px) {
            .rating-card {
                padding: 1.5rem;
            }
            
            .star-rating label {
                font-size: 2rem;
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
            <div class="rating-container">
                <div class="rating-card">
                    <div class="product-info">
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <i class="bi bi-box"></i>
                            @endif
                        </div>
                        <h2 class="product-name">{{ $product->name }}</h2>
                        <p class="order-number">Order #{{ $order->order_number }}</p>
                        <p class="text-muted">Rate your experience with this product</p>
                    </div>
                    
                    <form action="{{ route('ratings.store', [$order, $product]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Star Rating -->
                        <div class="star-rating">
                            <input type="radio" name="rating" value="5" id="star5" required>
                            <label for="star5" class="bi bi-star"></label>
                            
                            <input type="radio" name="rating" value="4" id="star4">
                            <label for="star4" class="bi bi-star"></label>
                            
                            <input type="radio" name="rating" value="3" id="star3">
                            <label for="star3" class="bi bi-star"></label>
                            
                            <input type="radio" name="rating" value="2" id="star2">
                            <label for="star2" class="bi bi-star"></label>
                            
                            <input type="radio" name="rating" value="1" id="star1">
                            <label for="star1" class="bi bi-star"></label>
                        </div>
                        
                        <div class="rating-text" id="ratingText">Click to rate</div>
                        
                        <!-- Review Title -->
                        <div class="mb-3">
                            <label class="form-label">Review Title (Optional)</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g., Great product!">
                        </div>
                        
                        <!-- Review Content -->
                        <div class="mb-3">
                            <label class="form-label">Your Review</label>
                            <textarea name="review" class="form-control" rows="5" 
                                      placeholder="Share your experience with this product..."></textarea>
                        </div>
                        
                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label class="form-label">Add Photos (Optional)</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*" id="imageUpload">
                            <small class="text-muted">You can upload up to 5 images (Max 2MB each)</small>
                            
                            <div class="image-preview-container" id="imagePreviewContainer"></div>
                        </div>
                        
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check-circle me-2"></i>Submit Review
                        </button>
                        
                        <a href="{{ route('order.details', $order) }}" class="btn-cancel">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                    </form>
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
        // Star rating text
        const ratingTexts = {
            1: 'Poor - Not satisfied at all',
            2: 'Fair - Could be better',
            3: 'Good - Satisfied',
            4: 'Very Good - Happy with product',
            5: 'Excellent - Highly recommended!'
        };
        
        document.querySelectorAll('input[name="rating"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const rating = this.value;
                document.getElementById('ratingText').textContent = ratingTexts[rating];
            });
        });
        
        // Image preview
        const imageUpload = document.getElementById('imageUpload');
        const previewContainer = document.getElementById('imagePreviewContainer');
        let imageFiles = [];
        
        imageUpload.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            imageFiles = [...imageFiles, ...files].slice(0, 5);
            
            // Update file input
            const dataTransfer = new DataTransfer();
            imageFiles.forEach(file => dataTransfer.items.add(file));
            imageUpload.files = dataTransfer.files;
            
            // Update preview
            previewContainer.innerHTML = '';
            imageFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'image-preview';
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <span class="remove-image" onclick="removeImage(${index})">
                            <i class="bi bi-x"></i>
                        </span>
                    `;
                    previewContainer.appendChild(preview);
                };
                reader.readAsDataURL(file);
            });
        });
        
        function removeImage(index) {
            imageFiles.splice(index, 1);
            
            // Update file input
            const dataTransfer = new DataTransfer();
            imageFiles.forEach(file => dataTransfer.items.add(file));
            imageUpload.files = dataTransfer.files;
            
            // Re-render preview
            previewContainer.innerHTML = '';
            imageFiles.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'image-preview';
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <span class="remove-image" onclick="removeImage(${idx})">
                            <i class="bi bi-x"></i>
                        </span>
                    `;
                    previewContainer.appendChild(preview);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
</body>
</html>