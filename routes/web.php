<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth:admin'])->name('admin.dashboard');

Route::resource('admin/products', ProductController::class)->middleware(['auth:admin']);
Route::get('product', [FrontendController::class,'index'])->middleware(['auth'])->name('product.index');
Route::get('cart', [FrontendController::class,'cart'])->middleware(['auth']);
Route::get('order', [FrontendController::class,'my_order'])->middleware(['auth'])->name('my_order');
Route::post('add-item-cart', [FrontendController::class,'add_cart'])->middleware(['auth'])->name("add.cart");
Route::post('delete-item-cart', [FrontendController::class,'delete_cart'])->middleware(['auth'])->name("delete.cart");
Route::post('add-order', [FrontendController::class,'add_order'])->middleware(['auth'])->name("add.order");


require __DIR__.'/adminauth.php';



