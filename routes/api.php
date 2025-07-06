<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('user', [AuthController::class, 'user'])->name('user');
});

Route::group(['prefix' => 'post', 'as' => 'post.', 'middleware' => ['auth:sanctum']], function () {
    Route::get('latest', [PostController::class, 'latest'])->name('latest');
    Route::get('by-user', [PostController::class, 'byUser'])->name('by_user');
    Route::get('{id}/detail', [PostController::class, 'detail'])->name('detail');
    Route::post('/', [PostController::class, 'create'])->name('create');
    Route::post('/{id}', [PostController::class, 'like'])->name('like');
    Route::delete('{id}', [PostController::class, 'delete'])->name('delete');
    Route::group(['prefix' => '{post_id}/like', 'as' => 'like.'], function () {
        Route::post('/', [PostLikeController::class, 'like'])->name('like');
        Route::delete('/', [PostLikeController::class, 'unlike'])->name('unlike');
    });
    Route::group(['prefix' => '{post_id}/comment', 'as' => 'comment.'], function () {
        Route::get('/', [PostCommentController::class, 'index'])->name('index');
        Route::post('/', [PostCommentController::class, 'store'])->name('store');
    });
});
