<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\BankTransaction;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $loanAccounts = Accounts::where('account_type', 'loan')->get();
        $totalLoanAmount = 0;
        
        foreach($loanAccounts as $account) {
            $account->total_amount = BankTransaction::where('accounts_id', $account->id)->sum('usd_amount') ?? 0;
            $totalLoanAmount += $account->total_amount;
        }
        
        return view('admin.dashboard', compact('loanAccounts', 'totalLoanAmount'));
    }
}
