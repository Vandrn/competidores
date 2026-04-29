<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromoController;

Route::get('/', fn()=>redirect()->route('promos.index'));

Route::controller(PromoController::class)->group(function () {
    Route::get('/promos', 'index')->name('promos.index');
    Route::post('/promos', 'store')->name('promos.store');
    Route::get('/promos/{promo}', 'show')->name('promos.show');          // JSON para el modal
    Route::delete('/promos/{promo}', 'destroy')->name('promos.destroy'); // opcional
});
