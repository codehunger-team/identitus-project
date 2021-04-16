<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\ReviewController;
use App\Http\Controllers\Front\AjaxController;



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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('set-commission/{id}', [CommissionController::class, 'setCommission'])->name('admin.set.commission');

//domain Filter
Route::get('domains',[FrontController::class, 'all_domains'])->name('domains');
Route::post('ajax/domain_filtering', [FrontController::class, 'domain_filtering'])->name('ajax.domainfiltering');

//review terms
Route::get('review-terms/{id}',[ReviewController::class, 'index'])->name('review.terms');

//Add to Cart
Route::get('checkout',[AjaxController::class, 'cart_contents'])->name('checkout');
Route::get('ajax/add-to-cart/buy/{domain}',[AjaxController::class, 'add_to_cart_buy'])->name('ajax.add-to-cart.buy');
Route::get('ajax/add-to-cart/{domain}',[AjaxController::class, 'add_to_cart'])->name('ajax.add.to.cart');
Route::get('/cart/remove/particular-item/{id}',[AjaxController::class, 'cart_remove_item'])->name('ajax.remove.to.cart');

//user
Route::post('user/review/update',[FrontController::class, 'user_update'])->name('user.review.update');


