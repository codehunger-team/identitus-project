<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\LeaseController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\OptionExpirationController;
use App\Http\Controllers\Admin\GracePeriodController;


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

Route::prefix('admin')->middleware('auth')->group(function() {
    //Dashboard Route
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    //Commission Route
    Route::get('set-commission/{id}',[CommissionController::class, 'setCommission'])->name('admin.set.commission');
    Route::get('add-commission/',[CommissionController::class, 'addCommission'])->name('admin.add.commission');
    Route::get('set-domain-commission',[CommissionController::class, 'setDomainCommission'])->name('set.domain.commission');
    Route::post('store-domain-commission',[CommissionController::class, 'storeDomainCommission'])->name('store.domain.commission');
    Route::get('set-contract-commission',[CommissionController::class, 'setContractCommission'])->name('set.contract.commission');
    Route::post('store-contract-commission',[CommissionController::class, 'storeContractCommission'])->name('store.contract.commission');
    Route::get('remove-domain-commission',[CommissionController::class, 'removeDomainCommission'])->name('domain.commission.remove');

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
    Route::post('add-terms',[DomainController::class, 'add_terms'])->name('admin.add.terms');

     //Active and Inactive lease
    Route::get('active-lease',[LeaseController::class, 'activeLease'])->name('admin.active.lease');
    Route::get('inactive-lease', [LeaseController::class, 'inActiveLease'])->name('admin.inactive.lease');

    // Category Related
    Route::get('categories', [AdminController::class, 'categories_overview'])->name('admin.category');
    Route::post('add_category', [AdminController::class, 'add_category'])->name('admin.add.category');
    Route::post('update_category', [AdminController::class, 'update_category'])->name('admin.update.category');

    // Period Related
    Route::get('admin/period-types', 'Admin@period_overview');
    Route::post('admin/add-period', 'Admin@add_period');
    Route::get('admin/edit-period/{id}', 'Admin@edit_period');
    Route::any('admin/remove-period/{id}', 'Admin@remove_period');
    Route::post('admin/update-period', 'Admin@update_period');


    // Option Expiration
    Route::get('admin/option-expiration', 'Admin@option_overview');
    Route::post('admin/add-option', 'Admin@add_option');
    Route::get('admin/edit-option/{id}', 'Admin@edit_option');
    Route::any('admin/remove-option/{id}', 'Admin@remove_option');
    Route::post('admin/update-option', 'Admin@update_option');

    // Grace Period
    Route::get('admin/grace-period', 'Admin@grace_overview');
    Route::post('admin/add-grace', 'Admin@add_grace');
    Route::get('admin/edit-grace/{id}', 'Admin@edit_grace');
    Route::any('admin/remove-grace/{id}', 'Admin@remove_grace');
    Route::post('admin/update-grace', 'Admin@update_grace');

});
