<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::resource('products', ProductController::class)->except(['show']);
Route::resource('clients', ClientController::class)->except(['show']);
