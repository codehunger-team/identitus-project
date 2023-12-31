<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\ReviewController;
use App\Http\Controllers\Front\AjaxController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\DocusignController;
use App\Http\Controllers\Front\EnquiryController;
use App\Http\Controllers\Front\CounterOfferController;
use App\Http\Controllers\Front\FrontPageController;
use App\Http\Controllers\Front\SiteMapController;
use Illuminate\Support\Facades\Auth;



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


Route::get('/', [FrontPageController::class, 'home'])->name('homepage');

Route::get('domain-typeahead', [FrontController::class, 'domainSearchTypeahead'])->name('domain.search.typeahead');

Auth::routes(['verify' => true]);

Route::post('/register/check-if-account-exists', [RegisterController::class, 'checkIfAccountExists'])->name('register.check.account');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//review terms
Route::get('review-terms/{id}', [ReviewController::class, 'index'])->name('review.terms');

//counter offer
Route::post('counter', [CounterOfferController::class, 'counterLease'])->name('counter');
Route::get('counter/edit/{id}', [CounterOfferController::class, 'editCounter'])->name('edit.counter');
Route::get('counter/{domain}', [CounterOfferController::class, 'counterOffer'])->middleware('auth')->name('counter.offer');
Route::post('counter/contract', [CounterOfferController::class, 'counterContract'])->name('counter.contract');
Route::get('accept/offer/{id}', [CounterOfferController::class, 'acceptOffer'])->name('accept.offer');
Route::get('update/counter-offer/{id}', [CounterOfferController::class, 'updateCounterOffer'])->name('update.counter.offer');

//Add to Cart
Route::get('checkout', [AjaxController::class, 'cart_contents'])->name('checkout');
Route::get('ajax/add-to-cart/buy/{domain}', [AjaxController::class, 'add_to_cart_buy'])->name('ajax.add-to-cart.buy');
Route::get('ajax/add-to-cart/{domain}', [AjaxController::class, 'add_to_cart'])->name('ajax.add.to.cart');
Route::get('/cart/remove/particular-item/{id}', [AjaxController::class, 'cart_remove_item'])->name('ajax.remove.to.cart');

//user
Route::post('user/review/update', [FrontController::class, 'user_update'])->name('user.review.update');

//checkout
Route::get('checkout/credit-card', [CheckoutController::class, 'credit_card'])->name('checkout.credit.card');
Route::post('checkout/credit-card', [CheckoutController::class, 'credit_card_processing'])->name('checkout.credit.card.processing');
Route::get('checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');


//Standard pages
Route::get('about', [FrontController::class, 'about'])->name('about');
Route::get('q-and-a', [FrontController::class, 'qa'])->name('qa');
Route::get('membership', [FrontController::class, 'membership'])->name('membership');
Route::get('tos', [FrontController::class, 'tos'])->name('tos');
Route::get('privacy-policy', [FrontController::class, 'privacy'])->name('privacy');
Route::get('cookie-policy', [FrontController::class, 'cookie'])->name('cookie');
Route::get('disclaimer', [FrontController::class, 'disclaimer'])->name('disclaimer');
Route::get('ccpa-do-not-sell', [FrontController::class, 'ccpa'])->name('ccpa');

// Static Pages
Route::get('/fees', [FrontPageController::class, 'feesPage'])->name('fees');
Route::get('/domain-owners', [FrontPageController::class, 'domainOwners'])->name('domain.owners');
Route::get('/domain-renters', [FrontPageController::class, 'domainLessees'])->name('domain.renters');

//Docusign
Route::get('docusign', [DocusignController::class, 'index'])->name('docusign');
Route::get('docusign/callback', [DocusignController::class, 'callback'])->name('docusign.redirect');
Route::get('sign/document/{domain}', [DocusignController::class, 'signDocument'])->name('sign.document');

//Enquiry Controller
Route::post('send/enquiry', [EnquiryController::class, 'sendEnquiry'])->name('send.enquiry');

//site Map Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/page-sitemap.xml', [SitemapController::class, 'pageSitemap']);
Route::get('/domain-sitemap.xml', [SitemapController::class, 'domainSitemap']);

//domain Filter
Route::get('domains', [FrontController::class, 'all_domains'])->name('domains');
Route::post('ajax/domain_filtering', [FrontController::class, 'domain_filtering'])->name('ajax.domainfiltering');

Route::get('fix-contract-issue', [FrontController::class, 'fix_contract_issue'])->name('fix-contract-issue');

Route::get('{domain}', [FrontController::class, 'domainInfo'])->name('domain.details');


