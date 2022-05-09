<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::name('home')->get('/', [CategoryController::class, 'index']);
//Registration
Route::get('create-account', [RegisterController::class, 'create'])->middleware('guest');
Route::post('create-account', [RegisterController::class, 'store'])->middleware('guest');
//Sessions
Route::get('login', [SessionController::class, 'create'])->middleware('guest');
Route::post('login', [SessionController::class, 'store'])->middleware('guest');
Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth');
//User
Route::get('user{user:id}', [UserController::class, 'show']);
Route::get('user{user:id}/edit', [UserController::class, 'edit'])->middleware('auth');
Route::patch('user{user:id}', [UserController::class, 'update'])->middleware('auth');
//Products
Route::get('{category:slug}/products', [ProductController::class, 'index'])->name('products');
Route::get('{category:slug}/products/create', [ProductController::class, 'create'])->middleware('auth');
Route::post('{category:slug}/products', [ProductController::class, 'store'])->middleware('auth');
Route::get('products/{product:slug}', [ProductController::class, 'show'])->name('product');
Route::get('products/{product:slug}/edit', [ProductController::class, 'edit'])->middleware('auth');
Route::patch('products/{product:slug}', [ProductController::class, 'update'])->middleware('auth');
Route::delete('products/{product:slug}', [ProductController::class, 'destroy'])->middleware('auth');
//Comments
Route::post('{product:id}/comment', [CommentController::class, 'store'])->middleware('auth');
Route::delete('comment/{comment:id}', [CommentController::class, 'destroy'])->middleware('auth');
Route::patch('comment/{comment:id}', [CommentController::class, 'update'])->middleware('auth');
//Favorites
Route::post('favorites/{product:id}', [FavoritesController::class, 'store'])->middleware('auth');
Route::delete('favorites/{product:id}', [FavoritesController::class, 'destroy'])->middleware('auth');
//Email verification
Route::controller(EmailVerificationController::class)->middleware(['auth'])->name('verification.')
    ->prefix('email')->group(function () {
        Route::get('/verify/{id}/{hash}', 'verify')->middleware(['signed'])->name('verify');
        Route::post('/verification-notification', 'send')
            ->middleware(['can:not-verified', 'throttle:2,1'])->name('send');
    });
//Password reset
Route::controller(ResetPasswordController::class)->name('password.')->group(function () {
    Route::get('/forgot-password', 'requestEmail');
    Route::post('/forgot-password', 'sendEmail')->name('email')->middleware('throttle:2,1');;
    Route::get('/reset-password/{token}', 'reset')->name('reset');
    Route::post('/reset-password', 'update')->name('update');
});
