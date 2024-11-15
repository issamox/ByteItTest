<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

Route::redirect('/', '/products');

Route::resource('products', ProductController::class);

Route::get('products/{product}/buy', [ProductController::class, 'buyView'])->name('products.buy');
Route::post('products/{product}/buy', [ProductController::class, 'buy'])->name('products.buy');

Route::get('products/{product}/sell', [ProductController::class, 'sellView'])->name('products.sell');
Route::post('products/{product}/sell', [ProductController::class, 'sell'])->name('products.sell');

Route::get('getProducts/export', function () {
    return Excel::download(new ProductsExport, 'products.xlsx');
})->name('products.export');
