<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Delivery\DeliveryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\Admin\ReportController;

// ==================== PUBLIC ROUTES ====================

// Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Login Routes
Route::get('/login', function () {
    return view('welcome');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.store');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Delivery Partner Landing Page
Route::get('/become-delivery-partner', function () {
    return view('delivery.landing');
})->name('delivery.landing');

// Public Contact & FAQ Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/faq', [ContactController::class, 'faq'])->name('faq');

// ==================== PRODUCT ROUTES ====================
Route::middleware(['auth'])->prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductsController::class, 'index'])->name('index');
    Route::get('/{product}', [ProductsController::class, 'show'])->name('show');
});

// ==================== CART ROUTES ====================
Route::middleware(['auth'])->prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/item/{cartItem}', [CartController::class, 'update'])->name('update');
    Route::delete('/item/{cartItem}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/apply-promo', [CartController::class, 'applyPromo'])->name('apply-promo');
    Route::post('/remove-promo', [CartController::class, 'removePromo'])->name('remove-promo');
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
});

// ==================== ORDER ROUTES ====================
Route::middleware(['auth'])->prefix('order')->name('order.')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/place', [OrderController::class, 'placeOrder'])->name('place');
    Route::get('/confirmation/{order}', [OrderController::class, 'confirmation'])->name('confirmation');
    Route::get('/history', [OrderController::class, 'history'])->name('history');
    Route::get('/{order}', [OrderController::class, 'show'])->name('details');
    Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    Route::get('/tracking-data/{order}', [OrderController::class, 'getTrackingData'])->name('tracking.data');

    Route::post('/{order}/confirm-received', [OrderController::class, 'confirmReceived'])->name('confirm-received');
});

// ==================== PAYMENT ROUTES ====================
Route::middleware(['auth'])->prefix('payment')->name('payment.')->group(function () {
    Route::get('/process/{order}/{method}', [PaymentController::class, 'process'])->name('process');
    Route::post('/callback', [PaymentController::class, 'callback'])->name('callback');
    Route::post('/webhook', [PaymentController::class, 'webhook'])->name('webhook');
    Route::get('/receipt/{order}', [PaymentController::class, 'receipt'])->name('receipt');
});

// ==================== RATING ROUTES ====================
Route::middleware(['auth'])->prefix('ratings')->name('ratings.')->group(function () {
    Route::get('/my-ratings', [RatingController::class, 'myRatings'])->name('my-ratings');
    Route::get('/product/{product}', [RatingController::class, 'productRatings'])->name('product');
    Route::prefix('order/{order}/product/{product}')->group(function () {
        Route::get('/create', [RatingController::class, 'create'])->name('create');
        Route::post('/', [RatingController::class, 'store'])->name('store');
        Route::get('/user', [RatingController::class, 'getUserRating'])->name('get-user-rating');
    });
    Route::prefix('rating/{rating}')->group(function () {
        Route::put('/', [RatingController::class, 'update'])->name('update');
        Route::delete('/', [RatingController::class, 'destroy'])->name('destroy');
    });
});

// ==================== DELIVERY ROUTES ====================
Route::middleware(['auth'])->prefix('delivery')->name('delivery.')->group(function () {
    // Dashboard and main routes
    Route::get('/dashboard', [DeliveryController::class, 'dashboard'])->name('dashboard');
    Route::get('/available', [DeliveryController::class, 'availableDeliveries'])->name('available');
    Route::get('/get-available-orders', [DeliveryController::class, 'getAvailableOrders'])->name('get-available-orders');
    
    // Delivery assignment and pickup
    Route::post('/assign-and-pickup', [DeliveryController::class, 'assignAndPickup'])->name('assign-and-pickup');
    Route::post('/accept/{deliveryId}', [DeliveryController::class, 'acceptDelivery'])->name('accept');
    Route::post('/mark-out-for-delivery/{orderId}', [DeliveryController::class, 'markAsOutForDelivery'])->name('mark-out-for-delivery');
    
    // Delivery management
    Route::put('/update-status/{deliveryId}', [DeliveryController::class, 'updateStatus'])->name('update-status');
    Route::get('/show/{deliveryId}', [DeliveryController::class, 'showDelivery'])->name('show');
    Route::get('/show-order/{orderId}', [DeliveryController::class, 'showOrder'])->name('show-order');
    
    // Location tracking
    Route::post('/update-location', [DeliveryController::class, 'updateLocation'])->name('update-location');
    
    // Availability toggle
    Route::post('/toggle-availability', [DeliveryController::class, 'toggleAvailability'])->name('toggle-availability');
});

// ==================== PROTECTED USER ROUTES ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/landing', function () {
        return view('landing');
    })->name('landing');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/addresses', [ProfileController::class, 'storeAddress'])->name('addresses.store');
    Route::put('/addresses/{address}', [ProfileController::class, 'updateAddress'])->name('addresses.update');
    Route::delete('/addresses/{address}', [ProfileController::class, 'deleteAddress'])->name('addresses.delete');
    Route::post('/addresses/{address}/default', [ProfileController::class, 'setDefaultAddress'])->name('addresses.default');
    
    // Track order for customer
    Route::get('/track-order/{order}', [DeliveryController::class, 'trackOrder'])->name('track-order');
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::post('/products/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('products.bulk-delete');
    Route::post('/products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::post('/products/{product}/toggle-active', [ProductController::class, 'toggleActive'])->name('products.toggle-active');
    Route::post('/products/{product}/update-stock', [ProductController::class, 'updateStock'])->name('products.update-stock');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/update-order', [CategoryController::class, 'updateOrder'])->name('categories.update-order');
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/export', [AdminOrderController::class, 'export'])->name('export');
        Route::post('/bulk-update', [AdminOrderController::class, 'bulkUpdate'])->name('bulk-update');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [AdminOrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [AdminOrderController::class, 'update'])->name('update');
        Route::post('/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('cancel');
        Route::delete('/{order}', [AdminOrderController::class, 'destroy'])->name('destroy');
        Route::post('/{order}/items', [AdminOrderController::class, 'updateItems'])->name('update-items');
    });
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/export', [UserController::class, 'export'])->name('export');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    });
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/sales/export', [ReportController::class, 'exportSales'])->name('sales.export');
        Route::get('/inventory', [ReportController::class, 'inventory'])->name('inventory');
        Route::get('/inventory/export', [ReportController::class, 'exportInventory'])->name('inventory.export');
    });
});