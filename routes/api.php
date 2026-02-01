<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SuggestionController;

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {

        Route::post('/store', 'store')->name('auth.store');
        Route::post('/authenticate', 'authenticate')->name('auth.authenticate');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/destroy', 'destroy')->name('auth.destroy');
            Route::post('/destroy_all', 'destroyAll')->name('auth.destroyAll');
            Route::post('/user', 'user')->name('auth.user');
        });
    });

Route::middleware('auth:sanctum')
    ->controller(FormController::class)
    ->prefix('forms')
    ->group(function () {
        Route::get('/', 'index')->name('forms.index');
        Route::post('/', 'store')->name('forms.store');
    });

Route::middleware('auth:sanctum')
    ->controller(SuggestionController::class)
    ->prefix('forms')
    ->group(function () {
        Route::get('{form}/suggestions', 'index')->name('forms.suggestions');
        Route::post('{formId}/suggestions/analyze', 'analyzeTopics')->name('forms.summarize');
    });






