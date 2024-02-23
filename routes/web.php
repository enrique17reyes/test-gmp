<?php

use App\Http\Controllers\productsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products',[productsController::class,'index'])->name('index');
Route::get('/products-list',[productsController::class,"get_products"])->name('get_products');
Route::post('/products/store',[productsController::class,"store"])->name('store');

Route::get('/tabla-export',[productsController::class,'tabla_export'])->name('tabla_export');

Route::get('/export',[productsController::class,'export'])->name('export');

Route::post('/products/dup',[productsController::class,"dup"])->name('dup');
