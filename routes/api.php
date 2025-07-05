<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::post('authenticate', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('authenticate');
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('user', [\App\Http\Controllers\AuthController::class, 'user'])->name('user');
});
