<?php
/**
 * Vendor Routes
 */

use App\Http\Controllers\Vendor\HomeController as VendorHomeController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [VendorHomeController::class, 'index'])
    ->name('dashboard');
