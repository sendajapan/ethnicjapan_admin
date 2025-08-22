<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\BankTransaction;
use App\Models\Sale;
use App\Models\Provider;
use App\Models\Customer;
use App\Models\Shipment;
use App\Models\Lot;
use App\Models\PurchaseCosts;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $allAccounts = Accounts::all();
        $accountsWithBalance = collect();
        $totalAmount = 0;
        
        foreach($allAccounts as $account) {
            $balance = 0;
            
            if ($account->account_type == 'Customer') {
                $customer = Customer::where('account_id', $account->id)->first();
                if ($customer) {
                    $balance = Sale::where('customer_id', $customer->id)->sum('sale_amount') ?? 0;
                }
            } elseif ($account->account_type == 'Provider') {
                $provider = Provider::where('account_id', $account->id)->first();
                if ($provider) {
                    $shipments = Shipment::where('provider_id', $provider->id)->get();
                    foreach($shipments as $shipment) {
                        $lotsTotal = Lot::where('shipment_id', $shipment->id)->sum('total_price') ?? 0;
                        $costsTotal = PurchaseCosts::where('shipment_id', $shipment->id)->sum('cost_amount') ?? 0;
                        $balance -= ($lotsTotal + $costsTotal);
                    }
                }
            }
            
            $transactions = BankTransaction::where('accounts_id', $account->id)->get();
            foreach($transactions as $t) {
                if($t->type == 'CR') {
                    $balance += $t->final_amount;
                } else {
                    $balance -= $t->final_amount;
                }
            }

            
            
            if ($balance != 0) {
                $account->total_amount = $balance;
                $accountsWithBalance->push($account);
                $totalAmount += $balance;
            }
        }
        
        return view('admin.dashboard', compact('accountsWithBalance', 'totalAmount'));
    }
}
