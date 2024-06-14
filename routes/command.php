<?php

use Illuminate\Support\Facades\Route;

Route::get('optimize-clear', function () {
    \Artisan::call('optimize:clear');

    flashSuccess('Cache cleared successfully');

    return to_route('frontend.index');
})->name('app.optimize-clear');

Route::get('migrate/data', function () {
    \Artisan::call('migrate');

    flashSuccess('App updated successfully');

    return to_route('frontend.index');
});
