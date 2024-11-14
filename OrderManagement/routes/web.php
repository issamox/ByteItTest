<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::resource('products', ProductController::class)->except(['show']);
Route::resource('clients', ClientController::class)->except(['show']);
Route::resource('orders', OrderController::class)->except(['show']);

Route::get('/orders/{order}/pdf', [OrderController::class, 'generatePDF'])->name('orders.pdf');
Route::get('/orders/export', [OrderController::class, 'exportCsv'])->name('orders.export');
