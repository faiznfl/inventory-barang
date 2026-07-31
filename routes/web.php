<?php

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

Route::get('/products', function () {
    return view('products.index');
})->name('products.index');

Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');

Route::get('/suppliers', function () {
    return view('suppliers.index');
})->name('suppliers.index');

Route::get('/stock-transactions', function () {
    return view('stock-transactions.index');
})->name('stock-transactions.index');

Route::get('/reports', function () {
    return view('reports.index');
})->name('reports.index');
