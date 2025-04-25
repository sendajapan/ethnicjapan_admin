<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ShipmentsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard(ShipmentsDataTable $dataTable)
    {
        $totalSale = Sale::sum('price_at_sale');
        $currentMonthSale = Sale::whereYear('sold_at', Carbon::now()->year)
            ->whereMonth('sold_at', Carbon::now()->month)
            ->sum('price_at_sale');

        return $dataTable->with(['limit' => 10, 'disablePagination' => true])->render('admin.dashboard',
            [
                'totalSale' => $totalSale,
                'currentMonthSale' => $currentMonthSale,
            ]
        );
    }

}
