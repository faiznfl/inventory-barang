<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function () {
    return redirect()->route('password.check-email')->with('status', "We've sent a password reset link to your email address.");
})->name('password.email');

Route::get('/check-email', function () {
    return view('auth.check-email');
})->name('password.check-email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', function () {
    return redirect()->route('password.updated');
})->name('password.update');

Route::get('/password-updated', function () {
    return view('auth.password-updated');
})->name('password.updated');

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);

Route::resource('suppliers', SupplierController::class);

Route::get('/stock-transactions', [StockTransactionController::class, 'index'])->name('stock-transactions.index');
Route::post('/stock-transactions', [StockTransactionController::class, 'store'])->name('stock-transactions.store');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])->name('reports.export.csv');
Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

Route::post('/roles', [UserController::class, 'storeRole'])->name('roles.store');
Route::put('/roles/{role}', [UserController::class, 'updateRole'])->name('roles.update');
Route::delete('/roles/{role}', [UserController::class, 'destroyRole'])->name('roles.destroy');
