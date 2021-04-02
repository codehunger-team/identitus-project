<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\DomainController;

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

});
