<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
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
Route::get('user{user:id}/edit', [UserController::class, 'edit'])->middleware('can:currentUser');
Route::patch('user{user:id}', [UserController::class, 'update'])->middleware('can:currentUser');
//Products
Route::name('products')->get('{category:slug}/products', [ProductController::class, 'index']);
Route::get('{category:slug}/products/create', [ProductController::class, 'create'])->middleware('auth');
Route::post('{category:slug}/products', [ProductController::class, 'store'])->middleware('auth');
Route::name('product')->get('products/{product:slug}', [ProductController::class, 'show']);


//Comments
Route::post('{product:id}/comment', [CommentController::class, 'store'])->middleware('auth');
Route::delete('comment/{comment:id}', [CommentController::class, 'destroy'])->middleware('auth');
Route::patch('comment/{comment:id}', [CommentController::class, 'update'])->middleware('auth');
//Favorites
Route::post('favorites/{product:id}', [FavoritesController::class, 'store'])->middleware('auth');
Route::delete('favorites/{product:id}', [FavoritesController::class, 'destroy'])->middleware('auth');

