<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Lessee\UserSettingController;
use App\Http\Controllers\User\Lessor\DomainController;
use App\Http\Controllers\User\Lessor\LeaseController;
use App\Http\Controllers\User\Lessor\LessorController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\User\Lessor\OrderController;

/*
|--------------------------------------------------------------------------
| User Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//lessee routes
Route::prefix('user')->middleware('auth','verified')->group(function () {
    Route::post('update', [UserSettingController::class, 'userUpdate'])->name('user.update');
    Route::get('settings', [UserSettingController::class, 'index'])->name('user.settings');
    Route::get('profile', [UserSettingController::class, 'userProfile'])->name('user.profile');
    Route::get('orders', [UserSettingController::class, 'userOrders'])->name('user.orders');
    Route::get('rental-agreement', [UserSettingController::class, 'rentalAgreement'])->name('user.rental.agreement');
    Route::get('become-vendor', [UserSettingController::class, 'becomeVendor'])->name('user.become.vendor');
    Route::get('show-contract/{domainId}', [UserSettingController::class, 'showContract'])->name('user.show.contract');
    Route::get('set-dns/{id}', [UserSettingController::class, 'addDns'])->name('user.add.dns');
    Route::post('nameserver/store', [UserSettingController::class, 'storeDns'])->name('nameserver.store');
    Route::get('view-order/{domain}', [UserSettingController::class, 'view_order'])->name('view.order');
    Route::get('view-terms/{id}', [UserSettingController::class, 'viewTerms'])->name('view.terms');
    Route::get('logout', [UserSettingController::class, 'logout'])->name('user.logout');

    //  these StripeController routes are neither lessee routes nor lessor routes
    Route::get('/stripe-connect/redirect', [StripeController::class, 'stripeConnectRedirect'])->name('user.stripe-connect.redirect');
    Route::get('stripe-connect/revoke', [StripeController::class, 'revokeStripe'])->name('user.revoke.stripe');
    Route::get('/stripe-connect', [StripeController::class, 'stripeConnect'])->name('user.stripe-connect');
   
});
 
//lessor routes
Route::prefix('user')->middleware('auth','vendorApproval','verified')->group(function () {
    Route::get('view-dns/{id}', [LessorController::class, 'viewDns'])->name('view.dns');
    Route::get('active-lease', [LeaseController::class, 'activeLease'])->name('user.active.lease');
    Route::get('inactive-lease', [LeaseController::class, 'inactiveLease'])->name('user.inactive.lease');

    Route::get('domain', [DomainController::class, 'domain'])->name('user.domains');
    Route::get('add/domain', [DomainController::class, 'addDomain'])->name('add.domain');
    Route::post('store/domain', [DomainController::class, 'storeDomain'])->name('store.domain');
   
    Route::post('add-terms', [DomainController::class, 'add_terms'])->name('add-terms');
    Route::post('store-terms',[DomainController::class,'storeUpdateTerms'])->name('store.terms');
    Route::get('decline-terms',[DomainController::class,'declineTerms'])->name('decline.terms');
    Route::get('set-terms/{id}', [DomainController::class, 'set_terms'])->name('set.terms');
   
    Route::get('manage-domain/{domain}', [DomainController::class, 'manage_domain'])->name('manage.domain');
    Route::post('domain-update/{domain}', [DomainController::class, 'manage_domain_update'])->name('domain.update');
    Route::get('delete-domain/{domain}', [DomainController::class, 'domain_delete'])->name('domain.delete');

    Route::get('seller/orders', [OrderController::class, 'userSellerOrders'])->name('user.seller.orders');
    Route::get('seller-view-orders/{id}', [OrderController::class, 'userSellerViewOrders'])->name('user.view.orders');
    Route::get('destroy-order/{id}', [OrderController::class, 'destroyOrder'])->name('user.destroy.order');

   
   
    Route::get('close/negotiation/{domain}',[DomainController::class, 'close_negotiation'])->name('close.negotiation');
});

