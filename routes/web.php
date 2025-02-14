<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;
use Livewire\Livewire;
use Mews\Captcha\Facades\Captcha;


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
});

// User
Route::middleware(['role:User', 'auth', 'verified'])->group(function () {
    Route::middleware('hasChannel')->group(function () {
        Route::get('/channel/create', \App\Livewire\Channel\Create::class)->name('user.channel.create');
        Route::view('/channel', 'user.channel')->name('user.channel');
        Route::view('/channel/edit', 'user.channel.edit')->name('user.channel.edit');
        Route::view('/channel/dashboard', 'user.channel.dashboard')->name('user.channel.dashboard');

        Route::get('/channel/content/create', \App\Livewire\Video\VideoContentCreate::class)->name('user.content.create');
    });

    Route::view('/user/dashboard', 'user.dashboard')->name('user.dashboard');
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


//SECURITYYYY

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
