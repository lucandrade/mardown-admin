<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [Controllers\AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [Controllers\AdminPostsController::class, 'index']);
    Route::post('/admin', [Controllers\AdminPostsController::class, 'create']);
    Route::get('/admin/{id}', [Controllers\AdminPostsController::class, 'get']);
    Route::post('/admin/{id}', [Controllers\AdminPostsController::class, 'update']);
});
