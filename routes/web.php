<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StrawberryProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\AdminTestimonialController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\Admin\AdminFAQController;
use App\Http\Controllers\PasswordResetController;

// Public routes
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password reset
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public routes - tidak perlu login
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Testimonial routes - index bisa diakses tanpa login
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

// Testimonial routes - create memerlukan login (HARUS sebelum route dengan parameter)
Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create')->middleware('auth');

// Testimonial routes - store memerlukan login
Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store')->middleware(['auth', 'throttle:10,1']);

// Testimonial routes - show bisa diakses tanpa login (setelah create)
Route::get('/testimonials/{testimonial}', [TestimonialController::class, 'show'])->name('testimonials.show');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('strawberry-products', StrawberryProductController::class);
    Route::patch('strawberry-products/{strawberryProduct}/status', [StrawberryProductController::class, 'updateStatus'])->name('strawberry-products.update-status');
    Route::patch('strawberry-products/{strawberryProduct}/add-stock', [StrawberryProductController::class, 'addStock'])->name('strawberry-products.add-stock');
});

// User product routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/products', [UserProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [UserProductController::class, 'show'])->name('products.show');
});

// FAQ routes
Route::get('/faq', [FAQController::class, 'index'])->name('faqs.index');

// Contact routes
Route::get('/kontak', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store')->middleware('throttle:10,1');

// Education pages
Route::get('/edukasi/perawatan-strawberry', function () {
    return view('education.strawberry-care');
})->name('education.strawberry-care');

Route::get('/edukasi/pengendalian-hama', function () {
    return redirect()->route('education.strawberry-care', [], 301);
})->name('education.pest-control');


// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/summary', [AdminReportController::class, 'downloadSummary'])->name('reports.summary');
    
    // Admin testimonial routes
    Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials/{testimonial}/reply', [AdminTestimonialController::class, 'reply'])->name('testimonials.reply');
    Route::delete('/testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');
    
    // Admin contact routes
    Route::get('/contact', [App\Http\Controllers\AdminContactController::class, 'index'])->name('contact.index');
    Route::get('/contact/create', [App\Http\Controllers\AdminContactController::class, 'create'])->name('contact.create');
    Route::post('/contact', [App\Http\Controllers\AdminContactController::class, 'store'])->name('contact.store');
    Route::get('/contact/{contactInfo}/edit', [App\Http\Controllers\AdminContactController::class, 'edit'])->name('contact.edit');
    Route::put('/contact/{contactInfo}', [App\Http\Controllers\AdminContactController::class, 'update'])->name('contact.update');
    Route::delete('/contact/{contactInfo}', [App\Http\Controllers\AdminContactController::class, 'destroy'])->name('contact.destroy');
    Route::patch('/contact/{contactInfo}/set-active', [App\Http\Controllers\AdminContactController::class, 'setActive'])->name('contact.set-active');
    
    // Admin product introduction routes
    Route::get('/product-introduction', [App\Http\Controllers\AdminProductIntroductionController::class, 'index'])->name('product-introduction.index');
    Route::get('/product-introduction/create', [App\Http\Controllers\AdminProductIntroductionController::class, 'create'])->name('product-introduction.create');
    Route::post('/product-introduction', [App\Http\Controllers\AdminProductIntroductionController::class, 'store'])->name('product-introduction.store');
    Route::get('/product-introduction/{id}/edit', [App\Http\Controllers\AdminProductIntroductionController::class, 'edit'])->name('product-introduction.edit');
    Route::put('/product-introduction/{id}', [App\Http\Controllers\AdminProductIntroductionController::class, 'update'])->name('product-introduction.update');
    Route::delete('/product-introduction/{id}', [App\Http\Controllers\AdminProductIntroductionController::class, 'destroy'])->name('product-introduction.destroy');
    Route::post('/product-introduction/{id}/set-active', [App\Http\Controllers\AdminProductIntroductionController::class, 'setActive'])->name('product-introduction.set-active');
    
    // Admin FAQ routes
    Route::resource('faqs', AdminFAQController::class);

    // Notification Settings routes
    Route::get('/notification-settings', [App\Http\Controllers\NotificationSettingController::class, 'index'])->name('notification-settings.index');
    Route::put('/notification-settings/{notificationSetting}', [App\Http\Controllers\NotificationSettingController::class, 'update'])->name('notification-settings.update');
    Route::post('/notification-settings/test', [App\Http\Controllers\NotificationSettingController::class, 'testSend'])->name('notification-settings.test');

    // In-App Notification routes
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
});// Sales Data routes - hanya untuk admin
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/sales-data', [App\Http\Controllers\SalesDataController::class, 'index'])->name('sales-data.index');
    Route::post('/sales-data', [App\Http\Controllers\SalesDataController::class, 'store'])->name('sales-data.store');
    Route::post('/sales-data/upload-excel', [App\Http\Controllers\SalesDataController::class, 'uploadExcel'])->name('sales-data.upload-excel');
    Route::get('/sales-data/generate-report', [App\Http\Controllers\SalesDataController::class, 'generateReport'])->name('sales-data.generate-report');
    Route::get('/sales-data/download-report', [App\Http\Controllers\SalesDataController::class, 'downloadReport'])->name('sales-data.download-report');
    Route::get('/sales-data/{id}/edit', [App\Http\Controllers\SalesDataController::class, 'edit'])->name('sales-data.edit');
    Route::put('/sales-data/{id}', [App\Http\Controllers\SalesDataController::class, 'update'])->name('sales-data.update');
    Route::delete('/sales-data/{id}', [App\Http\Controllers\SalesDataController::class, 'destroy'])->name('sales-data.destroy');
    
    // Forecast routes
    Route::get('/forecast', [App\Http\Controllers\ForecastController::class, 'index'])->name('forecast.index');
    Route::get('/forecast/prediction', [App\Http\Controllers\ForecastController::class, 'getPrediction'])->name('forecast.prediction');
});
