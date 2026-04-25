<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Grocery Mart</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #28a745;
            --dark: #155724;
            --slate-50: #f8fafc;
            --slate-200: #e2e8f0;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: white;
        }

        .main-container {
            display: flex;
            height: 100vh;
        }

        /* Branding Side */
        .brand-side {
            flex: 1;
            background: var(--dark);
            background-image: radial-gradient(circle at 20% 30%, rgba(40, 167, 69, 0.2) 0%, transparent 70%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            text-align: center;
        }

        .brand-content { 
            max-width: 400px; 
        }

        /* BIGGER LOGO STYLE */
        .brand-logo {
            height: 210px; /* Increased from 120px */
            width: auto;
            filter: brightness(0) invert(1);
            margin-bottom: 24px;
            transition: transform 0.3s ease;
        }

        .brand-logo:hover {
            transform: scale(1.05);
        }

        .brand-side h1 { 
            font-family: 'Outfit', sans-serif; 
            font-size: 3.2rem; 
            font-weight: 700; 
            margin-top: 0; 
        }

        .brand-side p { font-weight: 300; opacity: 0.8; font-size: 1.15rem; line-height: 1.6; }

        /* Form Side */
        .form-side {
            flex: 1.2;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: white;
        }

        .form-content { width: 100%; max-width: 400px; }
        .form-content h2 { font-family: 'Outfit', sans-serif; font-weight: 700; color: var(--dark); margin-bottom: 8px; font-size: 2.2rem; }
        .subtitle { color: var(--slate-500); margin-bottom: 32px; font-size: 0.95rem; }

        /* Input Styling */
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--dark);
            margin-bottom: 8px;
            display: block;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 52px; 
            transform: translateY(-50%);
            color: var(--slate-400);
            font-size: 1.15rem;
            z-index: 10;
            pointer-events: none;
            transition: color 0.2s;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 52px;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--slate-400);
            cursor: pointer;
            z-index: 11;
            padding: 5px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .form-control {
            height: 52px;
            border-radius: 12px;
            border: 1.5px solid var(--slate-200);
            padding-left: 48px;
            padding-right: 45px;
            font-weight: 500;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--primary);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        /* Buttons */
        .btn-primary-custom {
            background-color: var(--dark);
            color: white;
            border: none;
            height: 52px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
        }

        .btn-google {
            background: white;
            border: 1.5px solid var(--slate-200);
            height: 52px;
            border-radius: 12px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 600;
            color: var(--dark);
            margin-top: 24px;
            transition: background 0.2s;
        }

        .btn-google:hover { background: var(--slate-50); }

        .divider {
            text-align: center;
            margin: 24px 0;
            position: relative;
        }

        .divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background: var(--slate-200);
            z-index: 1;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            z-index: 2;
            color: var(--slate-500);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        @media (max-width: 992px) {
            .brand-side { display: none; }
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="brand-side">
        <div class="brand-content">
            <img src="grocery-logo.png" alt="Grocery Logo" class="brand-logo">
            <h1>Grocery Mart</h1>
            <p>Shop fresh groceries with ease and convenience – everything you need, all in one place.</p>
        </div>
    </div>

    <div class="form-side">
        <div class="form-content">
            <h2>Welcome Back</h2>
            <p class="subtitle">Sign in to continue shopping your favourite items.</p>

            <form action="{{ route('login.store') }}" method="POST">
                @csrf

                <div class="input-wrapper">
                    <label class="form-label">Email Address</label>
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control" placeholder="name@company.com" required>
                </div>

                <div class="input-wrapper">
                    <div class="d-flex justify-content-between">
                        <label class="form-label">Password</label>
                        <a href="#" class="text-decoration-none small fw-bold" style="color: var(--primary)">Forgot?</a>
                    </div>
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="••••••••" required>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>

                <button type="submit" class="btn-primary-custom">Sign In</button>

                <div class="divider"><span>OR CONTINUE WITH</span></div>

                <button type="button" class="btn-google">
                    <img src="https://www.google.com/favicon.ico" width="18" alt="Google">
                    Google Account
                </button>
            </form>

            <p class="text-center mt-4 text-muted small">
                Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: var(--dark)">Sign Up</a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('toggleIcon');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>

</body>
</html>