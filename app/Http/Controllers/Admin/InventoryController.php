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
        // Get all lots with their related item and photos
        $inventory = Lot::with(['item'])
            ->selectRaw('
                item_id,
                SUM(total_packages) as total_packages,
                SUM(total_qty) as total_qty,
                SUM(total_price) as total_cost,
                type_of_package,
                MAX(lot_unique) as sample_lot_unique
            ')
            ->groupBy('item_id', 'type_of_package')
            ->get();

        // Add photos for each inventory item
        foreach ($inventory as $key => $item) {
            $photo = lot_photos::where('lot_unique', $item->sample_lot_unique)->first();
            $inventory[$key]['photo'] = $photo;
        }

        return view('admin.inventory.index', compact('inventory'));
    }
}
