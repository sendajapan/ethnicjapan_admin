<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lot;
use App\Models\Item;
use App\Models\lot_photos;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        $inventory = Lot::with(['item', 'shipment.purchase_costs'])
            ->selectRaw('
                item_id,
                MAX(lot_unique) as sample_lot_unique
            ')
            ->groupBy('item_id')
            ->get();

        foreach ($inventory as $key => $item) {
            $lots = Lot::with(['shipment.purchase_costs'])
                ->where('item_id', $item->item_id)
                ->get();           
            $inventory[$key]['lots'] = $lots;
            $photo = lot_photos::where('lot_unique', $item->sample_lot_unique)->first();
            $inventory[$key]['photo'] = $photo;
        }

        return view('admin.inventory.index', compact('inventory'));
    }
}
