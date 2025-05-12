<?php
/**
 * Admin Routes
 */

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\PurchaseReportController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SaleReportController;
use App\Http\Controllers\Admin\StockController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])
    ->name('dashboard');

Route::resource('category', CategoryController::class);
Route::resource('provider', ProviderController::class);
Route::resource('customer', CustomerController::class);
Route::resource('item', ItemController::class);
Route::resource('purchase', PurchaseController::class);
Route::resource('sale', SaleController::class);
Route::resource('stock', StockController::class);
Route::resource('purchase_report', PurchaseReportController::class);
Route::resource('sale_report', SaleReportController::class);










/* Shipment
Route::get("shipment/pending", [ShipmentController::class, 'pendingShipments'])->name('shipment.pending');
Route::get('shipment/receive-request/{id}', [ShipmentController::class, 'handleReceiveRequest'])->name('shipment.receive.request');
Route::post('shipment/receive-request/update/{id}', [ShipmentController::class, 'updateReceiveRequest'])->name('shipment.receive.update');
Route::resource('shipment', ShipmentController::class);
*/
/* Vehicle
Route::get('/vehicle/models', [VehicleController::class, 'getModels'])->name('vehicle.models');
Route::resource('vehicle', VehicleController::class);
*/
/* Part
Route::get('part/by-group', [PartController::class, 'getPartsByGroup'])->name('part.group');
Route::get('part/print/{vehicleId}', [PartController::class, 'print'])->name('part.print');
Route::resource('part', PartController::class);
*/
/* Part Category
Route::resource('part-category', PartCategoryController::class);
*/
