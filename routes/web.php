<?php

use App\Http\Controllers\MarketingController;
use Illuminate\Support\Facades\Route;

Route::controller(MarketingController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/features', 'features')->name('features');
    Route::get('/modules', 'modules')->name('modules');
    Route::get('/pricing', 'pricing')->name('pricing');
    Route::get('/security', 'security')->name('security');
    Route::get('/demo', 'demo')->name('demo');
});