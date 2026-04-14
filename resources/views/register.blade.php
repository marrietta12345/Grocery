<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account | Grocery Mart</title>

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
--delivery-gradient: linear-gradient(135deg, #1a472a, #2d6a4f);
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

.brand-logo {
height: 210px;
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

.brand-side p {
font-weight: 300;
opacity: 0.8;
font-size: 1.15rem;
line-height: 1.6;
}

/* Form Side */
.form-side {
flex: 1.2;
display: flex;
align-items: center;
justify-content: center;
padding: 40px;
background: white;
overflow-y: auto;
}

.form-content {
width: 100%;
max-width: 450px;
padding: 20px 0;
}

.form-content h2 {
font-family: 'Outfit', sans-serif;
font-weight: 700;
color: var(--dark);
margin-bottom: 8px;
font-size: 2.2rem;
}

.subtitle {
color: var(--slate-500);
margin-bottom: 32px;
font-size: 0.95rem;
}

/* Role Selection */
.role-selection {
    margin-bottom: 24px;
}

.role-label {
    font-weight: 600;
    font-size: 0.85rem;
    color: var(--dark);
    margin-bottom: 12px;
    display: block;
}

.role-options {
    display: flex;
    gap: 1rem;
    background: var(--slate-50);
    padding: 0.5rem;
    border-radius: 60px;
}

.role-option {
    flex: 1;
    text-align: center;
    padding: 0.6rem;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--slate-600);
    background: transparent;
    border: none;
}

.role-option.active {
    background: white;
    color: var(--dark);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.role-option i {
    margin-right: 0.5rem;
}

.role-option:hover:not(.active) {
    background: rgba(255, 255, 255, 0.5);
}

/* Inputs */
.input-wrapper {
position: relative;
margin-bottom: 18px;
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
}

.form-control {
height: 52px;
border-radius: 12px;
border: 1.5px solid var(--slate-200);
padding-left: 48px;
font-weight: 500;
transition: all 0.2s;
font-size: 0.95rem;
}

.form-control:focus {
border-color: var(--primary);
box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.1);
outline: none;
}

.input-wrapper:focus-within .input-icon {
color: var(--primary);
}

select.form-control {
    padding-left: 48px;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
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
display: flex;
align-items: center;
justify-content: center;
gap: 8px;
}

.btn-primary-custom:hover {
background-color: var(--primary);
transform: translateY(-1px);
box-shadow: 0 10px 15px -3px rgba(40, 167, 69, 0.2);
}

.btn-delivery-custom {
    background: linear-gradient(135deg, #1a472a, #2d6a4f);
    color: white;
    border: none;
    height: 52px;
    border-radius: 12px;
    font-weight: 700;
    width: 100%;
    margin-top: 10px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-delivery-custom:hover {
    background: linear-gradient(135deg, #2d6a4f, #40916c);
    transform: translateY(-1px);
    box-shadow: 0 10px 15px -3px rgba(64, 145, 108, 0.3);
}

/* Responsive */
@media (max-width: 992px) {
.brand-side { display: none; }
}
</style>
</head>

<body>

<div class="main-container">

<!-- Left Branding -->
<div class="brand-side">
<div class="brand-content">
<img src="grocery-logo.png" alt="Grocery Logo" class="brand-logo">
<h1>Welcome to Grocery</h1>
<p>Start shopping fresh groceries delivered right to your door. Delicious selections await!</p>
</div>
</div>

<!-- Right Form -->
<div class="form-side">
<div class="form-content">

<h2>Create Account</h2>
<p class="subtitle">Sign up for Grocery Mart and start adding items to your cart in seconds.</p>

<form action="{{ route('register.store') }}" method="POST">
@csrf

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Role Selection -->
<div class="role-selection">
    <label class="role-label">I want to sign up as</label>
    <div class="role-options">
        <button type="button" class="role-option active" data-role="customer" id="customerRoleBtn">
            <i class="bi bi-person"></i> Customer
        </button>
        <button type="button" class="role-option" data-role="delivery" id="deliveryRoleBtn">
            <i class="bi bi-truck"></i> Delivery Personnel
        </button>
    </div>
    <input type="hidden" name="role" id="roleInput" value="user">
</div>

<div class="input-wrapper">
<label class="form-label">First Name</label>
<i class="bi bi-person input-icon"></i>
<input type="text" name="first_name" class="form-control" placeholder="First name" value="{{ old('first_name') }}" required autofocus>
@error('first_name')
    <small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="input-wrapper">
<label class="form-label">Middle Name (Optional)</label>
<i class="bi bi-person input-icon"></i>
<input type="text" name="middle_name" class="form-control" placeholder="Middle name" value="{{ old('middle_name') }}">
</div>

<div class="input-wrapper">
<label class="form-label">Last Name</label>
<i class="bi bi-person input-icon"></i>
<input type="text" name="last_name" class="form-control" placeholder="Last name" value="{{ old('last_name') }}" required>
@error('last_name')
    <small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="input-wrapper">
<label class="form-label">Email Address</label>
<i class="bi bi-envelope input-icon"></i>
<input type="email" name="email" class="form-control" placeholder="name@gmail.com" value="{{ old('email') }}" required>
@error('email')
    <small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="input-wrapper">
<label class="form-label">Password</label>
<i class="bi bi-lock input-icon"></i>
<input type="password" name="password" id="passwordInput" class="form-control" style="padding-right:45px;" placeholder="••••••••" required>
<button type="button" class="password-toggle" onclick="togglePassword('passwordInput','toggleIcon')">
<i class="bi bi-eye" id="toggleIcon"></i>
</button>
@error('password')
    <small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="input-wrapper">
<label class="form-label">Confirm Password</label>
<i class="bi bi-shield-check input-icon"></i>
<input type="password" name="password_confirmation" id="confirmPasswordInput" class="form-control" style="padding-right:45px;" placeholder="••••••••" required>
<button type="button" class="password-toggle" onclick="togglePassword('confirmPasswordInput','toggleConfirmIcon')">
<i class="bi bi-eye" id="toggleConfirmIcon"></i>
</button>
</div>

<!-- Delivery Personnel Fields (hidden by default) -->
<div id="deliveryFields" style="display: none;">
    <div class="input-wrapper">
        <label class="form-label">Phone Number</label>
        <i class="bi bi-phone input-icon"></i>
        <input type="text" name="phone_number" class="form-control" placeholder="09123456789" value="{{ old('phone_number') }}">
        @error('phone_number')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="input-wrapper">
        <label class="form-label">Vehicle Type</label>
        <i class="bi bi-bicycle input-icon"></i>
        <select name="vehicle_type" class="form-control">
            <option value="">Select vehicle type</option>
            <option value="motorcycle" {{ old('vehicle_type') == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
            <option value="car" {{ old('vehicle_type') == 'car' ? 'selected' : '' }}>Car</option>
            <option value="bicycle" {{ old('vehicle_type') == 'bicycle' ? 'selected' : '' }}>Bicycle</option>
        </select>
        @error('vehicle_type')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="input-wrapper">
        <label class="form-label">License Plate</label>
        <i class="bi bi-card-text input-icon"></i>
        <input type="text" name="license_plate" class="form-control" placeholder="ABC-1234" value="{{ old('license_plate') }}">
        @error('license_plate')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<!-- Register Button -->
<button type="submit" class="btn-primary-custom" id="submitBtn">
<i class="bi bi-person-plus"></i> Register
</button>

</form>

<p class="text-center mt-4 text-muted small">
  Already have an account?
  <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color:var(--dark)">
    Login
  </a>
</p>

</div>
</div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = "password";
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

// Role switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const customerBtn = document.getElementById('customerRoleBtn');
    const deliveryBtn = document.getElementById('deliveryRoleBtn');
    const roleInput = document.getElementById('roleInput');
    const submitBtn = document.getElementById('submitBtn');
    const deliveryFields = document.getElementById('deliveryFields');
    const phoneField = document.querySelector('input[name="phone_number"]');
    const vehicleField = document.querySelector('select[name="vehicle_type"]');
    const plateField = document.querySelector('input[name="license_plate"]');
    
    function setActiveRole(role) {
        if (role === 'customer') {
            customerBtn.classList.add('active');
            deliveryBtn.classList.remove('active');
            roleInput.value = 'user';
            submitBtn.innerHTML = '<i class="bi bi-person-plus"></i> Register';
            submitBtn.className = 'btn-primary-custom';
            submitBtn.style.background = 'var(--dark)';
            deliveryFields.style.display = 'none';
            
            // Remove required attributes
            if (phoneField) phoneField.required = false;
            if (vehicleField) vehicleField.required = false;
            if (plateField) plateField.required = false;
        } else {
            customerBtn.classList.remove('active');
            deliveryBtn.classList.add('active');
            roleInput.value = 'delivery';
            submitBtn.innerHTML = '<i class="bi bi-truck"></i> Register';
            submitBtn.className = 'btn-delivery-custom';
            submitBtn.style.background = 'linear-gradient(135deg, #1a472a, #2d6a4f)';
            deliveryFields.style.display = 'block';
            
            // Add required attributes
            if (phoneField) phoneField.required = true;
            if (vehicleField) vehicleField.required = true;
            if (plateField) plateField.required = true;
        }
    }
    
    // Add click handlers
    customerBtn.addEventListener('click', function() {
        setActiveRole('customer');
    });
    
    deliveryBtn.addEventListener('click', function() {
        setActiveRole('delivery');
    });
    
    // Check URL parameter for role
    const urlParams = new URLSearchParams(window.location.search);
    const roleParam = urlParams.get('role');
    if (roleParam === 'delivery') {
        setActiveRole('delivery');
    }
    
    // Preserve form data on validation error
    if (roleInput.value === 'delivery') {
        setActiveRole('delivery');
    }
});

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<!-- Bootstrap JS for alerts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>