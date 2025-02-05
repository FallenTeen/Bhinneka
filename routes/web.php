<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::view('/', 'landing')->name('home');
Route::view('/content', 'content')->name('content');
Route::view('/pricing', 'landing')->name('pricing');
Route::middleware(['auth', 'role.redirect', 'verified'])->get('/dashboard', function () {})->name('dashboard');

// Admin
Route::middleware(['role:Admin', 'auth', 'verified'])->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
});

// Creator
Route::middleware(['role:Creator', 'auth', 'verified'])->group(function () {
    Route::view('/creator/dashboard', 'creator.dashboard')->name('creator.dashboard');
});

// Investor
Route::middleware(['role:Investor', 'auth', 'verified'])->group(function () {
    Route::view('/investor/dashboard', 'investor.dashboard')->name('investor.dashboard');
});
Route::view('profile', 'admin.profile')->name('profile');

require __DIR__ . '/auth.php';
