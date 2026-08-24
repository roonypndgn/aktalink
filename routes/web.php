<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('layouts.app');
});

Route::get('/login', [AuthController::class, 'showLoginForm']);