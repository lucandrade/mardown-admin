<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/', [Controllers\PostsController::class, 'index']);
Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [Controllers\AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [Controllers\AdminPostsController::class, 'index']);
    Route::get('/admin/create', function () {
        return view('admin/post-form');
    });
    Route::post('/admin', [Controllers\AdminPostsController::class, 'create']);
    Route::get('/admin/{id}', [Controllers\AdminPostsController::class, 'get']);
    Route::post('/admin/{id}', [Controllers\AdminPostsController::class, 'update']);
});
