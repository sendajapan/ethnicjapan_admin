<?php
/**
 * Admin Routes
 */

use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\BankTransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\PortsController;
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
Route::get("provider/detail/{id}", [ProviderController::class, 'detail'])->name('provider.detail');
Route::resource('provider', ProviderController::class);
Route::resource('customer', CustomerController::class);
Route::get("item/detail/{id}", [ItemController::class, 'detail'])->name('item.detail');
Route::resource('item', ItemController::class);

Route::post("purchase/upload_lot_photo", [PurchaseController::class, 'upload_lot_photo']);
Route::get("purchase/delete_lot_photo", [PurchaseController::class, 'delete_lot_photo']);
Route::get("purchase/delete_complete_lot", [PurchaseController::class, 'delete_complete_lot']);

/** Purchase Routes */
Route::get("purchase/detail/{id}", [PurchaseController::class, 'detail'])->name('purchase.detail');
Route::resource('purchase', PurchaseController::class);

Route::get("bank/detail/{id}", [BankAccountController::class, 'detail'])->name('bank.detail');
Route::resource('bank', BankAccountController::class);

Route::get("transactions/report/{type}/{id}", [BankTransactionController::class, 'report'])->name('transactions.report');
Route::post("transactions/report/{type}/{id}", [BankTransactionController::class, 'report'])->name('transactions.report');
Route::get("transactions/detail/{id}", [BankTransactionController::class, 'detail'])->name('transactions.detail');
Route::resource('transactions', BankTransactionController::class);

Route::resource('ports', PortsController::class);

Route::get("accounts/detail/{id}", [AccountsController::class, 'detail'])->name('accounts.detail');
Route::resource('accounts', AccountsController::class);


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
