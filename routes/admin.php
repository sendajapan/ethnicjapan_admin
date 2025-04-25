<?php
/**
 * Admin Routes
 */

use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\PartCategoryController;
use App\Http\Controllers\Admin\PartController;
use App\Http\Controllers\Admin\PartSubCategoryController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])
    ->name('dashboard');

Route::resource('category', CategoryController::class);
Route::resource('provider', ProviderController::class);
Route::resource('customer', CustomerController::class);
Route::resource('item', ItemController::class);
Route::resource('purchase', PurchaseController::class);


/* Shipment */
Route::get("shipment/pending", [ShipmentController::class, 'pendingShipments'])->name('shipment.pending');
Route::get('shipment/receive-request/{id}', [ShipmentController::class, 'handleReceiveRequest'])->name('shipment.receive.request');
Route::post('shipment/receive-request/update/{id}', [ShipmentController::class, 'updateReceiveRequest'])->name('shipment.receive.update');
Route::resource('shipment', ShipmentController::class);

/* Vehicle */
Route::get('/vehicle/models', [VehicleController::class, 'getModels'])->name('vehicle.models');
Route::resource('vehicle', VehicleController::class);

/* Part */
Route::get('part/by-group', [PartController::class, 'getPartsByGroup'])->name('part.group');
Route::get('part/print/{vehicleId}', [PartController::class, 'print'])->name('part.print');
Route::resource('part', PartController::class);

/* Part Category */
Route::resource('part-category', PartCategoryController::class);

/* Part Category */
Route::resource('part-sub-category', PartSubCategoryController::class);

/* Cart */
Route::post('cart/proceedCheckout', [CartController::class, 'proceedCheckout'])->name('cart.proceed-checkout');
Route::get('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::resource('cart', CartController::class);

/* Costs */
Route::resource('cost', CostController::class);

/* Sale */
Route::get('sale', [SaleController::class, 'index'])->name('sale.index');
