<?php

use Grafikr\ShopifyApp\Http\Controllers\AppController;
use Grafikr\ShopifyApp\Http\Controllers\OAuthController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;

Route::middleware([StartSession::class])->group(function () {
    Route::get('/', AppController::class)->name('initialize');
    Route::get('app', [AppController::class, 'app'])->name('app');
    Route::get('redirect', [AppController::class, 'redirect'])->name('app.redirect');
    Route::get('login', [AppController::class, 'login'])->name('app.login');

    Route::prefix('oauth')->name('oauth.')->group(function () {
        Route::get('redirect', [OAuthController::class, 'redirect'])->name('redirect');
        Route::get('callback', [OAuthController::class, 'callback'])->name('callback');
    });
});
