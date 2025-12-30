<?php

use App\Login;
use Illuminate\Support\Facades\Route;

Route::post('/login', [Login::class, 'post'])->name('login');

Route::post('/register', [Login::class, 'register'])->name('register');

Route::middleware(['auth:sanctum'])->post('/fields', [\App\Http\Controllers\FieldController::class, 'store'])->name('fields.store');
Route::middleware(['auth:sanctum'])->get('/fields', [\App\Http\Controllers\FieldController::class, 'getAll'])->name('fields.get');

Route::post('/detection', [\App\Http\Controllers\DetectionController::class, 'detect'])->name('detection.detect');

