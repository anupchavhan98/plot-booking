<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PlotController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/', fn() => redirect()->route('public.plots'));

// Public Routes (no auth required)
Route::get('/plots', [App\Http\Controllers\PublicController::class, 'plots'])->name('public.plots');
Route::post('/book-plot', [App\Http\Controllers\PublicController::class, 'bookPlot'])->name('public.book.plot');


// Guest Routes (Login, Forgot Password, etc.)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout & Change Password (accessible to all roles)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change.post');

    // Admin Routes Only
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Plots
        Route::resource('plots', PlotController::class);
        Route::patch('plots/{plot}/status', [PlotController::class, 'changeStatus'])->name('plots.status');
        Route::get('plots/layout/view', fn() => view('admin.plots.layout'))->name('plots.layout');

        // Customers
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');

        // Agents
        Route::get('agents', [AgentController::class, 'index'])->name('agents.index');
        Route::get('agents/create', [AgentController::class, 'create'])->name('agents.create');
        Route::post('agents', [AgentController::class, 'store'])->name('agents.store');

        // Bookings
        Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');

        // Payments & Reports (placeholder routes)
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });
});

// Default Redirect
// Route::get('/', function () {
//     return redirect()->route('login');
// });


// Customer Routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', fn() => view('customer.dashboard'))->name('dashboard');
    Route::get('/bookings', fn() => view('customer.bookings'))->name('bookings');
});

// Agent Routes
Route::middleware(['auth', 'role:agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', fn() => view('agent.dashboard'))->name('dashboard');
    Route::get('/bookings', fn() => view('agent.bookings'))->name('bookings');
    Route::get('/commission', fn() => view('agent.commission'))->name('commission');
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);



