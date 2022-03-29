<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CategoryController::class, 'index']);

Route::get('create-account', [RegisterController::class, 'create'])->middleware('guest');
Route::post('create-account', [RegisterController::class, 'store'])->middleware('guest');
Route::get('login', [SessionController::class, 'create'])->middleware('guest');
Route::post('login', [SessionController::class, 'store'])->middleware('guest');
Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('{category:slug}', [ProductController::class, 'index']);
Route::get('{category:slug}/{product:slug}', [ProductController::class, 'show']);
