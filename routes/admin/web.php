<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\GracePeriodController;
use App\Http\Controllers\Admin\LeaseController;
use App\Http\Controllers\Admin\OptionExpirationController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DnsController;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::prefix('admin')->middleware('auth','isAdmin')->group(function () {
    //Dashboard Route
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    //order route
    Route::get('admin/view-order/{order}', [AdminController::class, 'view_order'])->name('admin.view.order');
    Route::get('admin/delete-order/{order}', [AdminController::class, 'delete_order'])->name('admin.delete.order');

    //Commission Route
    Route::get('set-commission/{id}', [CommissionController::class, 'setCommission'])->name('admin.set.commission');
    Route::get('add-commission/', [CommissionController::class, 'addCommission'])->name('admin.add.commission');
    Route::get('set-domain-commission', [CommissionController::class, 'setDomainCommission'])->name('set.domain.commission');
    Route::post('store-domain-commission', [CommissionController::class, 'storeDomainCommission'])->name('store.domain.commission');
    Route::get('set-contract-commission', [CommissionController::class, 'setContractCommission'])->name('set.contract.commission');
    Route::post('store-contract-commission', [CommissionController::class, 'storeContractCommission'])->name('store.contract.commission');
    Route::get('remove-domain-commission', [CommissionController::class, 'removeDomainCommission'])->name('domain.commission.remove');

    //domain Route
    Route::get('domains', [DomainController::class, 'domains_overview'])->name('admin.domain');
    Route::get('add-domain', [DomainController::class, 'add_domain'])->name('admin.add.domain');
    Route::get('bulk-domains', [DomainController::class, 'bulk_upload'])->name('admin.bulk.upload');
    Route::post('bulk-domains', [DomainController::class, 'bulk_upload_process'])->name('admin.bulk.upload.process');
    Route::post('add-domain', [DomainController::class, 'add_domain_process'])->name('admin.add.domain.process');
    Route::post('manage-domain/{domain}', [DomainController::class, 'manage_domain_update'])->name('admin.manage.domain.update');
    Route::get('manage-domain/{domain}', [DomainController::class, 'manage_domain'])->name('admin.manage.domain');

    //Terms per domain
    Route::get('set-terms/{id}', [DomainController::class, 'set_terms'])->name('admin.set.terms');
    Route::post('add-terms', [DomainController::class, 'add_terms'])->name('admin.add.terms');

    //Active and Inactive lease
    Route::get('active-lease', [LeaseController::class, 'activeLease'])->name('admin.active.lease');
    Route::get('inactive-lease', [LeaseController::class, 'inActiveLease'])->name('admin.inactive.lease');

    // Category Related
    Route::get('categories', [AdminController::class, 'categories_overview'])->name('admin.category');
    Route::post('add_category', [AdminController::class, 'add_category'])->name('admin.add.category');
    Route::post('update_category', [AdminController::class, 'update_category'])->name('admin.update.category');

    // Period Related
    Route::get('period-types', [PeriodController::class, 'period_overview'])->name('admin.period');
    Route::post('add-period', [PeriodController::class, 'add_period'])->name('admin.add.period');
    Route::get('edit-period/{id}', [PeriodController::class, 'edit_period'])->name('admin.edit.period');
    Route::any('remove-period/{id}', [PeriodController::class, 'remove_period'])->name('admin.remove.period');
    Route::post('update-period', [PeriodController::class, 'update_period'])->name('admin.update.period');

    // Option Expiration
    Route::get('option-expiration', [OptionExpirationController::class, 'option_overview'])->name('admin.option');
    Route::post('add-option', [OptionExpirationController::class, 'add_option'])->name('admin.add.option');
    Route::get('edit-option/{id}', [OptionExpirationController::class, 'edit_option'])->name('admin.edit.option');
    Route::any('remove-option/{id}', [OptionExpirationController::class, 'remove_option'])->name('admin.remove.option');
    Route::post('update-option', [OptionExpirationController::class, 'update_option'])->name('admin.update.option');

    // Grace Period
    Route::get('grace-period', [GracePeriodController::class, 'grace_overview'])->name('admin.grace');
    Route::post('add-grace', [GracePeriodController::class, 'add_grace'])->name('admin.add.grace');
    Route::get('edit-grace/{id}', [GracePeriodController::class, 'edit_grace'])->name('admin.edit.grace');
    Route::any('remove-grace/{id}', [GracePeriodController::class, 'remove_grace'])->name('admin.remove.grace');
    Route::post('update-grace', [GracePeriodController::class, 'update_grace'])->name('admin.update.grace');

    // CMS
    Route::get('cms', [AdminController::class, 'pages'])->name('admin.cms');
    Route::post('cms', [AdminController::class, 'create_page'])->name('admin.create.page');
    Route::get('cms-edit/{id}', [AdminController::class, 'edit_page'])->name('admin.edit.page');
    Route::post('cms-edit/{id}', [AdminController::class, 'update_page'])->name('admin.update.page');
    Route::delete('cms-delete/{id}', [AdminController::class, 'delete_page'])->name('admin.delete.page');

    // navigation
    Route::get('navigation', [AdminController::class, 'navigation'])->name('admin.navigation');
    Route::post('navigation', [AdminController::class, 'navigation_save'])->name('admin.add.navigation');
    Route::get('navigation/edit/{id}', [AdminController::class, 'navigation_edit'])->name('admin.edit.navigation');
    Route::post('navigation/edit/{id}', [AdminController::class, 'navigation_update'])->name('admin.update.navigation');
    Route::delete('navigation/delete/{id}', [AdminController::class, 'navigation_delete'])->name('admin.delete.navigation');
    Route::get('navigation-ajax-sort', [AdminController::class, 'navigation_ajax_sort'])->name('admin.ajax.sort.navigation');

    //admin user route
    Route::get('users',[UserController::class, 'registered_user_list'])->name('admin.users');
    Route::get('remove-user/{id}',[UserController::class, 'remove_users'])->name('admin.remove.user');
    Route::get('approve-user-vendor/{id}',[UserController::class, 'approve_user_vendor'])->name('admin.approval.vendor');
    Route::post('vendor-approval',[UserController::class, 'vendor_approval'])->name('admin.vendor.approval');

    //configuration route
    Route::get('configuration', [AdminController::class, 'configuration_overview'])->name('admin.configuration');
    Route::post('configuration', [AdminController::class, 'configuration_show'])->name('admin.show.configuration');
    
    //logout
    Route::any('logout', [AdminController::class, 'logout'])->name('admin.logout');

    //set Dns admin.nameserver.store
    Route::get('admin/set-dns/{id}',[DnsController::class, 'set_dns'])->name('admin.nameserver.set');
    Route::get('admin/view-dns/{id}',[DnsController::class, 'view_dns'])->name('admin.nameserver.view');
    Route::post('admin/store-dns',[DnsController::class, 'store_dns'])->name('admin.nameserver.store');

    // Release Lessor Payment
    Route::get('/admin/release-payment/{id}',[PaymentController::class, 'release_payment'])->name('admin.release.payment');
   
});
