<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/store', [AuthController::class, 'store'])->name('store');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');

Route::post('/destroy', [AuthController::class, 'destroy'])->name('destroy')->middleware('auth:sanctum');
Route::post('/destroy_all', [AuthController::class, 'destroyAll'])->name('destroyAll')->middleware('auth:sanctum');
Route::post('/user', [AuthController::class, 'user'])->name('user')->middleware('auth:sanctum');


