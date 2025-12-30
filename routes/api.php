<?php

use App\Login;
use Illuminate\Support\Facades\Route;

Route::post('/login', [Login::class, 'post'])->name('login');

Route::post('/register', [Login::class, 'register'])->name('register');

Route::middleware(['auth:sanctum'])->post('/fields', [\App\Http\Controllers\FieldController::class, 'store'])->name('fields.store');
Route::middleware(['auth:sanctum'])->get('/fields', [\App\Http\Controllers\FieldController::class, 'getAll'])->name('fields.get');

Route::post('/detection', [\App\Http\Controllers\DetectionController::class, 'detect'])->name('detection.detect');

Route::post('/models/upload', [\App\Http\Controllers\ModelController::class, 'upload'])->name('models.upload');

Route::post('/models/classification-checker', [\App\Http\Controllers\ModelController::class, 'checkClasses'])->name('models.classification-checker');

Route::prefix('classification')->group(function () {
  Route::post('/', [\App\Http\Controllers\ClassificationController::class, 'add'])
    ->name('classification.add');
  Route::get('/', [\App\Http\Controllers\ClassificationController::class, 'getAll'])
    ->name('classification.getAll');
});

Route::get('/models', [\App\Http\Controllers\ModelController::class, 'getAll'])->name('models.getAll');
