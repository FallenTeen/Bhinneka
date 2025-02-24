<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;

Broadcast::routes(['middleware' => ['web', 'auth']]);

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/captcha/refresh', function (Request $request) {
    return response()->json(['captcha' => captcha_src()]);
});

Route::view('/', 'landing')->name('home');
Route::view('/content', 'content')->name('content');
Route::view('/pricing', 'landing')->name('pricing');
Route::view('/channels/{slug}', 'channelshow')->name('channel.show');
Route::view('/content/{slug}', 'contentshow')->name('content.show');
Route::view('profile', 'admin.profile')->name('profile');
Route::middleware(['auth', 'role.redirect', 'verified'])->get('/dashboard', function () { })->name('dashboard');

Route::get('/thumbnail/{encrypted}', function ($encrypted) {
    try {
        $url = Crypt::decryptString($encrypted);
        return redirect($url);
    } catch (\Exception $e) {
        abort(404);
    }
})->where('encrypted', '.*')->name('thumbnail');

// Admin
Route::middleware(['role:Admin', 'auth', 'verified'])->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/admin/review-dokumen-daftar', 'admin.review-dokumen-daftar')->name('admin.review-dokumen-daftar');
});

// User
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/user/dashboard', 'user.dashboard')->name('user.dashboard');
    Route::get('/channel/create', \App\Livewire\Channel\Create::class)
        ->middleware('accesser')
        ->name('user.channel.create');
    Route::get('/investor-profile/create', \App\Livewire\Investor\Create::class)
        ->middleware('accesser')
        ->name('user.investor.create');

});
// Jembatan boy
Route::view('/waiting', 'verification-pending')->middleware('accesser')->name('waiting');
// Creator
Route::middleware(['auth', 'verified', 'accesser', 'role:Creator'])->group(function () {
    Route::view('/creator/dashboard', 'creator.dashboard')->name('creator.dashboard');
    Route::view('/channel', 'creator.channel')->name('creator.channel');
    Route::view('/channel/chats', 'creator.chat')->name('channel.chat');
    Route::get('/channel/content/create', \App\Livewire\Video\VideoContentCreate::class)
        ->name('creator.content.create');
});

// Investor
Route::middleware(['role:Investor', 'auth', 'accesser', 'verified'])->group(function () {
    Route::view('/investor/dashboard', 'investor.dashboard')->name('investor.dashboard');
    Route::view('/investor', 'investor.investor-profile')->name('investor.profile');
    Route::view('/investor/postindex', 'investor.post-index')->name('investor.post.index');
    Route::view('/investor/appliance', 'investor.appliance')->name('investor.appliance');
    Route::view('/investor/postcreate', 'investor.post-create')->name('investor.post.create');
    Route::view('/investor/chats', 'investor.chat')->name('investor.chat');
});

// Investor Public Routes
Route::middleware(['auth', 'verified', 'role:1,2,3'])->group(function () {
    Route::view('/investors', 'investor')->name('investor');
    Route::view('/investors/{slug}', 'investorshow')->name('investor.show');
});

// Thumbnail Security
Route::get('/thumbnail/{encodedUrl}', function ($encodedUrl) {
    try {
        $thumbnailUrl = Crypt::decryptString($encodedUrl);
        if (!str_contains($thumbnailUrl, 'https://drive.google.com/thumbnail')) {
            abort(403);
        }
        $imageContents = file_get_contents($thumbnailUrl);
        return response($imageContents)->header('Content-Type', 'image/jpeg');
    } catch (\Exception $e) {
        return abort(404);
    }
})->name('thumbnail');

require __DIR__ . '/auth.php';