<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


route::prefix('user')->group(function () {
    route::post('register', [App\Http\Controllers\UserController::class, 'store'])
        ->name('register');
    route::post('login', [App\Http\Controllers\UserController::class, 'login']);

    // Protected routes
    Route::put('update/{id}', [App\Http\Controllers\UserController::class, 'update'])->middleware('auth:sanctum');
    route::post('upload/{id}  ', [App\Http\Controllers\UserController::class, 'uploadImage'])->middleware('auth:sanctum');
    Route::post('logout', [App\Http\Controllers\UserController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->middleware('auth:sanctum');
});


Route::prefix('merchant')->group(function () {
    Route::get('/', [App\Http\Controllers\MerchantController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/{id}', [App\Http\Controllers\MerchantController::class, 'show'])->middleware('auth:sanctum');
    Route::get('/detail/{id}', [App\Http\Controllers\MerchantController::class, 'detail'])->middleware('auth:sanctum');
    Route::post('/', [App\Http\Controllers\MerchantController::class, 'store'])->middleware('auth:sanctum');
    Route::post('location/update/{id}', [App\Http\Controllers\MerchantController::class, 'updateLocation'])->middleware('auth:sanctum');
    Route::put('/{id}', [App\Http\Controllers\MerchantController::class, 'update'])->middleware('auth:sanctum');
});