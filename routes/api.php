<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

route::prefix('user')->group(function () {
    route::post('register', [App\Http\Controllers\UserController::class, 'store'])
        ->name('register');
    route::post('login', [App\Http\Controllers\UserController::class, 'login']);
    Route::middleware('auth:sanctum')->put('/update/{id}', [App\Http\Controllers\UserController::class, 'update']);
    Route::post('logout', [App\Http\Controllers\UserController::class, 'logout'])->middleware('auth:sanctum');
});