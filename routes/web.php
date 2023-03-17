<?php

use App\Http\Controllers\SignPdfController;
use Illuminate\Support\Facades\Route;

Route::name('sign-pdf.')->group(function () {
    Route::get('/', [SignPdfController::class, 'create'])->name('create');
    Route::post('/store', [SignPdfController::class, 'store'])->name('store');
    Route::get('/datatable', [SignPdfController::class, 'datatable'])->name('datatable');
    Route::get('/datatable-api', [SignPdfController::class, 'datatableApi'])->name('datatable-api');
});
