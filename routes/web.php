<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/admin/orders/{order}/print', [OrderController::class, 'print'])
    ->middleware('auth')
    ->name('orders.print');
Route::get('/admin/orders/print-summary', [OrderController::class, 'printSummary'])
    ->middleware('auth')
    ->name('orders.print-summary');
