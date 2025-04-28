<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');

    }

}
