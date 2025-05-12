<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\PurchaseItem;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $purchases = PurchaseItem::get();
        //$purchasedItems = $purchases->purchasedItems;
        //echo $purchases->purchasedItems->count();

        foreach($purchases as $p){
            $purchase_info_all[$p->item_id][]  = $p->item_qty;
        }
        foreach($purchase_info_all as $item_id => $item_qty){
            $purchased_qty_total_history[$item_id] = array_sum($item_qty);
        }


        $sales = SaleItem::all();
        foreach($sales as $p){
            $sales_info_all[$p->item_id][]  = $p->item_qty;
        }
        foreach($sales_info_all as $item_id => $item_qty){
            $sales_qty_total_history[$item_id] = array_sum($item_qty);
        }

        $remaining_qty = $purchased_qty_total_history;
        foreach($purchased_qty_total_history as $key=>$value){
            $remaining_qty[$key] = $purchased_qty_total_history[$key] - $sales_qty_total_history[$key];
        }

        $items = Item::all();

        foreach($items as $p){
            $itemData[$p->id]['name']  = $p->item_name;
            $itemData[$p->id]['price']  = $p->default_price;
        }

        foreach($remaining_qty as $key=>$value){
            $row['item_name'] = $itemData[$key]['name'];
            $row['item_qty'] = $value;
            $row['default_price'] = $itemData[$key]['price'];
            $data[] = $row;
        }

        return view('admin.stock.index', compact('data'));
    }

}
