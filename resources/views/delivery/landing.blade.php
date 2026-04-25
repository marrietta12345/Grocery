<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Delivery Partner | Grocery Mart</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--slate-50) 0%, white 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .navbar-brand {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--dark) !important;
        }
        
        .brand-icon {
            height: 35px;
            margin-right: 10px;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            border-radius: 32px;
            padding: 4rem 2rem;
            margin: 2rem 0;
            color: white;
            text-align: center;
        }
        
        .hero-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .hero-title {
            font-family: 'Outfit', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        
        .benefit-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
            height: 100%;
            border: 1px solid var(--slate-200);
        }
        
        .benefit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }
        
        .benefit-icon {
            width: 70px;
            height: 70px;
            background: rgba(40, 167, 69, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
        }
        
        .benefit-icon i {
            font-size: 2rem;
            color: var(--primary);
        }
        
        .benefit-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            color: var(--dark);
        }
        
        .benefit-description {
            font-size: 0.9rem;
            color: var(--slate-500);
            line-height: 1.5;
        }
        
        .requirement-list {
            list-style: none;
            padding: 0;
        }
        
        .requirement-list li {
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--slate-200);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .requirement-list li:last-child {
            border-bottom: none;
        }
        
        .requirement-list li i {
            color: var(--primary);
            font-size: 1.2rem;
        }
        
        .cta-button {
            background: var(--dark);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            font-size: 1.1rem;
        }
        
        .cta-button:hover {
            background: var(--primary);
            transform: translateY(-2px);
            color: white;
        }
        
        .footer {
            background: white;
            border-top: 1px solid var(--slate-200);
            padding: 3rem 1.5rem 1.5rem;
            margin-top: 3rem;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            .hero-section {
                padding: 2rem;
            }
            .benefit-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('welcome') }}">
                <img src="{{ asset('grocery-logo.png') }}" alt="Grocery Mart" class="brand-icon">
                Grocery Mart
            </a>
            <div class="ms-auto">
                <a href="{{ route('login') }}" class="btn btn-outline-success me-2">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-success">Sign Up</a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-icon">
                <i class="bi bi-truck"></i>
            </div>
            <h1 class="hero-title">Join Our Delivery Team</h1>
            <p class="lead mb-4">Earn money delivering groceries to customers in your area</p>
            <a href="{{ route('register') }}?role=delivery" class="cta-button">
                <i class="bi bi-person-plus"></i> Apply Now
            </a>
        </div>
        
        <!-- Benefits Section -->
        <h2 class="text-center mb-4">Why Deliver With Us?</h2>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <h3 class="benefit-title">Competitive Earnings</h3>
                    <p class="benefit-description">Earn competitive delivery fees plus tips. Keep 100% of your tips!</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h3 class="benefit-title">Flexible Schedule</h3>
                    <p class="benefit-description">Work when you want - choose your own hours. No minimum hours required.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h3 class="benefit-title">Ratings & Bonuses</h3>
                    <p class="benefit-description">Earn bonuses for excellent service and high customer ratings.</p>
                </div>
            </div>
        </div>
        
        <!-- Requirements Section -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="bg-white rounded-4 p-4 h-100 border">
                    <h3 class="mb-4"><i class="bi bi-check-circle-fill text-success me-2"></i> Requirements</h3>
                    <ul class="requirement-list">
                        <li><i class="bi bi-check-circle-fill"></i> Valid driver's license</li>
                        <li><i class="bi bi-check-circle-fill"></i> Reliable vehicle (motorcycle, car, or bicycle)</li>
                        <li><i class="bi bi-check-circle-fill"></i> Smartphone with GPS</li>
                        <li><i class="bi bi-check-circle-fill"></i> 18 years or older</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-white rounded-4 p-4 h-100 border">
                    <h3 class="mb-4"><i class="bi bi-star-fill text-warning me-2"></i> What You'll Need</h3>
                    <ul class="requirement-list">
                        <li><i class="bi bi-phone"></i> Smartphone with internet</li>
                        <li><i class="bi bi-map"></i> Knowledge of local areas</li>
                        <li><i class="bi bi-credit-card"></i> Bank account for payments</li>
                        <li><i class="bi bi-emoji-smile"></i> Friendly and professional attitude</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="text-center mt-5 pt-4">
            <h3>Ready to Start Delivering?</h3>
            <p class="text-muted mb-4">Join our team and start earning today!</p>
            <a href="{{ route('register') }}?role=delivery" class="cta-button">
                <i class="bi bi-person-plus"></i> Sign Up as Delivery Partner
            </a>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Grocery Mart</h5>
                    <p class="text-muted">Your trusted online grocery store. Fresh products delivered to your doorstep.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <p><a href="{{ route('welcome') }}" class="text-decoration-none text-muted"><i class="bi bi-house-door"></i> Home</a></p>
                    <p><a href="{{ route('login') }}" class="text-decoration-none text-muted"><i class="bi bi-box-arrow-in-right"></i> Sign In</a></p>
                    <p><a href="{{ route('register') }}" class="text-decoration-none text-muted"><i class="bi bi-person-plus"></i> Sign Up</a></p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Connect With Us</h5>
                    <p><i class="bi bi-facebook"></i> <a href="#" class="text-decoration-none text-muted">Facebook</a></p>
                    <p><i class="bi bi-instagram"></i> <a href="#" class="text-decoration-none text-muted">Instagram</a></p>
                    <p><i class="bi bi-envelope"></i> <a href="mailto:support@grocerymart.com" class="text-decoration-none text-muted">support@grocerymart.com</a></p>
                </div>
            </div>
            <hr class="my-4">
            <p class="text-center text-muted small mb-0">© {{ date('Y') }} Grocery Mart. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>