<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\ReviewController;
use App\Http\Controllers\Front\AjaxController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\DocusignController;
use App\Http\Controllers\Front\EnquiryController;



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

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//review terms
Route::get('review-terms/{id}',[ReviewController::class, 'index'])->name('review.terms');
Route::post('counter',[ReviewController::class, 'counterLease'])->name('counter');
Route::get('counter/edit/{id}',[ReviewController::class, 'editCounter'])->name('edit.counter');

//Add to Cart
Route::get('checkout',[AjaxController::class, 'cart_contents'])->name('checkout');
Route::get('ajax/add-to-cart/buy/{domain}',[AjaxController::class, 'add_to_cart_buy'])->name('ajax.add-to-cart.buy');
Route::get('ajax/add-to-cart/{domain}',[AjaxController::class, 'add_to_cart'])->name('ajax.add.to.cart');
Route::get('/cart/remove/particular-item/{id}',[AjaxController::class, 'cart_remove_item'])->name('ajax.remove.to.cart');

//user
Route::post('user/review/update',[FrontController::class, 'user_update'])->name('user.review.update');

//checkout
Route::get('checkout/credit-card',[CheckoutController::class, 'credit_card'])->name('checkout.credit.card');
Route::post('checkout/credit-card', [CheckoutController::class, 'credit_card_processing'])->name('checkout.credit.card.processing');
Route::get('checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('about',[FrontController::class, 'about'])->name('about');
Route::get('q-and-a',[FrontController::class, 'qa'])->name('qa');

//Docusign
Route::get('docusign',[DocusignController::class,'index'])->name('docusign');
Route::get('docusign/callback',[DocusignController::class,'callback'])->name('docusign.redirect');
Route::get('sign/document/{domain}',[DocusignController::class,'signDocument'])->name('sign.document');

//Enquiry Controller
Route::post('send/enquiry', [EnquiryController::class, 'sendEnquiry'])->name('send.enquiry');

//domain Filter
Route::get('domains',[FrontController::class, 'all_domains'])->name('domains');
Route::post('ajax/domain_filtering', [FrontController::class, 'domain_filtering'])->name('ajax.domainfiltering');
Route::get('{domain}', [FrontController::class, 'domainInfo'])->name('domain.details');
