<?php

use App\Http\Controllers\User\Lessee\UserSettingController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('user')->middleware('auth')->group(function () {
    Route::post('update', [UserSettingController::class, 'userUpdate'])->name('user.update');
    Route::get('settings', [UserSettingController::class, 'index'])->name('user.settings');
    Route::get('profile', [UserSettingController::class, 'userProfile'])->name('user.profile');
    Route::get('orders', [UserSettingController::class, 'userOrders'])->name('user.orders');
    Route::get('rental-agreement', [UserSettingController::class, 'rentalAgreement'])->name('user.rental.agreement');
    Route::get('set-dns/{id}', [UserSettingController::class, 'addDns'])->name('user.add.dns');
    Route::post('nameserver-route', [UserSettingController::class, 'storeDns'])->name('nameserver.store');
    Route::get('view-order/{domain}', [UserSettingController::class, 'view_order'])->name('view.order');
    Route::get('set-terms/{id}', [UserSettingController::class, 'set_terms'])->name('set.terms');
    Route::get('logout', [UserSettingController::class, 'logout'])->name('user.logout');
});
