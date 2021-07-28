<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/login', [Controllers\AuthController::class, 'login']);
