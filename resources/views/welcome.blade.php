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
--danger: #ef4444;
--delivery-gradient: linear-gradient(135deg, #1a472a, #2d6a4f);
}

body,html{
height:100%;
margin:0;
font-family:'Plus Jakarta Sans',sans-serif;
background:white;
}

.main-container{
display:flex;
height:100vh;
}

/* Branding Side */
.brand-side{
flex:1;
background:var(--dark);
background-image:radial-gradient(circle at 20% 30%,rgba(40,167,69,0.2) 0%,transparent 70%);
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
color:white;
padding:40px;
text-align:center;
}

.brand-content{
max-width:400px;
}

/* Cart Icon Logo */
.brand-logo-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.05) 100%);
    border-radius: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    transition: transform 0.3s ease;
    border: 2px solid rgba(255,255,255,0.2);
}

.brand-logo-icon:hover {
    transform: scale(1.05);
    border-color: rgba(255,255,255,0.4);
}

.brand-logo-icon i {
    font-size: 4.5rem;
    color: white;
}

.brand-side h1{
font-family:'Outfit',sans-serif;
font-size:3.2rem;
font-weight:700;
margin-top: 0;
}

.brand-side p{
opacity:.8;
font-size:1.15rem;
line-height:1.6;
}

/* Form Side */
.form-side{
flex:1.2;
display:flex;
align-items:center;
justify-content:center;
padding:40px;
}

.form-content{
width:100%;
max-width:400px;
}

.form-content h2{
font-family:'Outfit',sans-serif;
font-weight:700;
color:var(--dark);
font-size:2.2rem;
margin-bottom:8px;
}

.subtitle{
color:var(--slate-500);
margin-bottom:32px;
}

/* Role Toggle Buttons */
.role-toggle {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    background: var(--slate-50);
    padding: 0.5rem;
    border-radius: 60px;
}

.role-btn {
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

.role-btn.active {
    background: white;
    color: var(--dark);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.role-btn i {
    margin-right: 0.5rem;
}

.role-btn:hover:not(.active) {
    background: rgba(255, 255, 255, 0.5);
}

/* Inputs */
.form-label{
font-weight:600;
font-size:.85rem;
margin-bottom:8px;
display:block;
}

.input-wrapper{
position:relative;
margin-bottom:20px;
}

.input-icon{
position:absolute;
left:16px;
top:52px;
transform:translateY(-50%);
color:var(--slate-400);
font-size:1.15rem;
}

.password-toggle{
position:absolute;
right:12px;
top:52px;
transform:translateY(-50%);
background:none;
border:none;
color:var(--slate-400);
cursor:pointer;
}

.form-control{
height:52px;
border-radius:12px;
border:1.5px solid var(--slate-200);
padding-left:48px;
padding-right:45px;
font-weight:500;
}

.form-control:focus{
border-color:var(--primary);
box-shadow:0 0 0 4px rgba(40,167,69,.1);
outline:none;
}

.btn-primary-custom{
background:var(--dark);
color:white;
border:none;
height:52px;
border-radius:12px;
font-weight:700;
width:100%;
margin-top:10px;
transition:.3s;
display:flex;
align-items:center;
justify-content:center;
gap:8px;
}

.btn-primary-custom:hover{
background:var(--primary);
transform:translateY(-1px);
box-shadow:0 10px 15px -3px rgba(40,167,69,.2);
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
    transition: .3s;
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

.btn-secondary-custom {
    background: transparent;
    border: 1.5px solid var(--dark);
    color: var(--dark);
    height:52px;
    border-radius:12px;
    font-weight:700;
    width:100%;
    margin-top:10px;
    transition:.3s;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
}

.btn-secondary-custom:hover {
    background: var(--dark);
    color: white;
    transform:translateY(-1px);
}

.btn-google{
background:white;
border:1.5px solid var(--slate-200);
height:52px;
border-radius:12px;
width:100%;
display:flex;
align-items:center;
justify-content:center;
gap:10px;
font-weight:600;
color:var(--dark);
margin-top:24px;
}

.divider{
text-align:center;
margin:24px 0;
position:relative;
}

.divider::before{
content:"";
position:absolute;
top:50%;
left:0;
width:100%;
height:1px;
background:var(--slate-200);
}

.divider span{
background:white;
padding:0 15px;
position:relative;
color:var(--slate-500);
font-size:.75rem;
font-weight:700;
}

.alert-custom{
border-radius:12px;
font-size:.85rem;
padding:12px;
margin-bottom:20px;
border:none;
}

/* Delivery Partner Link */
.delivery-partner {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--slate-200);
}

.delivery-partner a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
}

.delivery-partner a:hover {
    text-decoration: underline;
}

.delivery-partner i {
    margin-right: 0.5rem;
}

@media(max-width:992px){
.brand-side{
display:none;
}
}

</style>
</head>

<body>

<div class="main-container">

<!-- Branding Side with Cart Icon Logo -->
<div class="brand-side">
<div class="brand-content">
    <!-- Simple Cart Icon Logo -->
    <div class="brand-logo-icon">
        <i class="bi bi-cart-fill"></i>
    </div>
    <h1>Grocery Mart</h1>
    <p>
        Shop fresh groceries with ease and convenience – everything you need, all in one place.
    </p>
</div>
</div>

<!-- Login Form -->
<div class="form-side">
<div class="form-content">

<h2>Welcome Back</h2>
<p class="subtitle">
Sign in to continue shopping your favourite items.
</p>

<!-- Role Selection Toggle -->
<div class="role-toggle">
    <button type="button" class="role-btn active" data-role="customer" id="customerRoleBtn">
        <i class="bi bi-person"></i> Customer
    </button>
    <button type="button" class="role-btn" data-role="delivery" id="deliveryRoleBtn">
        <i class="bi bi-truck"></i> Delivery
    </button>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="alert alert-success alert-custom">
<i class="bi bi-check-circle-fill me-2"></i>
{{ session('success') }}
</div>
@endif

<!-- Error Message -->
@if($errors->any())
<div class="alert alert-danger alert-custom text-danger bg-danger bg-opacity-10">
<i class="bi bi-exclamation-circle-fill me-2"></i>
@foreach ($errors->all() as $error)
{{ $error }}
@endforeach
</div>
@endif

<form action="{{ route('login.store') }}" method="POST" id="loginForm">
@csrf

<!-- Hidden role input -->
<input type="hidden" name="role" id="roleInput" value="customer">

<div class="input-wrapper">
<label class="form-label">Email Address</label>
<i class="bi bi-envelope input-icon"></i>
<input type="email" name="email" class="form-control" placeholder="name@gmail.com" value="{{ old('email') }}" required>
</div>

<div class="input-wrapper">
<div class="d-flex justify-content-between">
<label class="form-label">Password</label>
<a href="#" onclick="clearPassword(event)" class="text-decoration-none small fw-bold" style="color:var(--primary)">
Forgot?
</a>
</div>
<i class="bi bi-lock input-icon"></i>
<input type="password" name="password" id="passwordInput" class="form-control" placeholder="••••••••" required>
<button type="button" class="password-toggle" onclick="togglePassword()">
<i class="bi bi-eye" id="toggleIcon"></i>
</button>
</div>

<button type="submit" class="btn-primary-custom" id="submitBtn">
<i class="bi bi-box-arrow-in-right"></i>
Sign In
</button>
</form>

<div class="divider">
<span>OR CONTINUE WITH</span>
</div>

<button type="button" class="btn-google">
<img src="https://www.google.com/favicon.ico" width="18">
Google Account
</button>

<p class="text-center mt-4 text-muted small">
Don't have an account?
<a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color:var(--dark)">
Sign Up
</a>
</p>

<!-- Delivery Partner Link -->
<div class="delivery-partner">
    <i class="bi bi-truck"></i>
    Want to deliver with us? 
    <a href="{{ route('delivery.landing') }}">Become a Delivery Partner</a>
</div>

</div>
</div>
</div>

<script>

function togglePassword(){
    const input=document.getElementById('passwordInput');
    const icon=document.getElementById('toggleIcon');
    
    if(input.type==="password"){
        input.type="text";
        icon.classList.replace('bi-eye','bi-eye-slash');
    }else{
        input.type="password";
        icon.classList.replace('bi-eye-slash','bi-eye');
    }
}

function clearPassword(event){
    event.preventDefault();
    const pass=document.getElementById("passwordInput");
    pass.value="";
    pass.focus();
}

// Role switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const customerBtn = document.getElementById('customerRoleBtn');
    const deliveryBtn = document.getElementById('deliveryRoleBtn');
    const roleInput = document.getElementById('roleInput');
    const submitBtn = document.getElementById('submitBtn');
    
    // Function to update UI based on selected role
    function setActiveRole(role) {
        if (role === 'customer') {
            customerBtn.classList.add('active');
            deliveryBtn.classList.remove('active');
            roleInput.value = 'customer';
            submitBtn.innerHTML = '<i class="bi bi-box-arrow-in-right"></i> Sign In';
            submitBtn.className = 'btn-primary-custom';
            submitBtn.style.background = '';
        } else {
            customerBtn.classList.remove('active');
            deliveryBtn.classList.add('active');
            roleInput.value = 'delivery';
            submitBtn.innerHTML = '<i class="bi bi-truck"></i> Sign In';
            submitBtn.className = 'btn-delivery-custom';
            submitBtn.style.background = '';
        }
        
        // Debug: Log the current role value being sent
        console.log('Selected role:', roleInput.value);
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
    const roleParam = urlParams.get('type');
    if (roleParam === 'delivery') {
        setActiveRole('delivery');
    }
    
    // Debug: Log form submission
    const form = document.getElementById('loginForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submitted with role:', roleInput.value);
        });
    }
});

// Add loading state on form submit
document.getElementById('loginForm')?.addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Signing in...';
});

</script>

</body>
</html>