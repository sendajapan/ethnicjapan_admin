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
    /**
     * Display a listing of the inventory.
     */
    public function index(): View
    {
        // Get all lots with their related item, shipment and photos
        $inventory = Lot::with(['item', 'shipment.purchase_costs'])
            ->selectRaw('
                item_id,
                MAX(lot_unique) as sample_lot_unique
            ')
            ->groupBy('item_id')
            ->get();

        // Add detailed lots and photos for each inventory item
        foreach ($inventory as $key => $item) {
            // Get all lots for this item with shipment and purchase costs
            $lots = Lot::with(['shipment.purchase_costs'])
                ->where('item_id', $item->item_id)
                ->get();
            
            $inventory[$key]['lots'] = $lots;
            
            // Get photo for this item
            $photo = lot_photos::where('lot_unique', $item->sample_lot_unique)->first();
            $inventory[$key]['photo'] = $photo;
        }

        return view('admin.inventory.index', compact('inventory'));
    }
}
