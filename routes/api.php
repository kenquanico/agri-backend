<?php

use App\Login;
use Illuminate\Support\Facades\Route;

Route::post('/login', [Login::class, 'post'])->name('login');

Route::post('/register', [Login::class, 'register'])->name('register');
