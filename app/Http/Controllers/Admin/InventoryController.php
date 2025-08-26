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

        $shipmentCharges = [];
        $shipmentOtherCosts = [];
        
        foreach($inventory as $item) {
            $shipmentId = $item['lots'][0]->shipment->id ?? 0;
            if (!isset($shipmentCharges[$shipmentId])) {
                $totalOtherExtra = 0;
                $totalOtherExtra_qty = 0;
                $totalPurchaseCosts = 0;

                foreach($inventory as $invItem) {
                    if(($invItem['lots'][0]->shipment->id ?? 0) == $shipmentId) {
                        foreach($invItem['lots'] as $lot) {
                            $totalOtherExtra_qty += $lot['total_qty'];
                        }
                    }
                }

                if(!empty($item['lots'][0]->shipment->purchase_costs)) {
                    foreach($item['lots'][0]->shipment->purchase_costs as $cost) {
                        $totalOtherExtra += $cost['cost_amount'] * $item['lots'][0]->shipment->exchange_rate;
                        $totalPurchaseCosts += $cost['cost_amount'];
                    }
                    $shipmentCharges[$shipmentId] = round($totalOtherExtra / $totalOtherExtra_qty);
                    
                    $exchangeRate = $item['lots'][0]->shipment->exchange_rate;
                    $shipmentOtherCosts[$shipmentId] = ($totalPurchaseCosts * $exchangeRate) / $totalOtherExtra_qty;
                } else {
                    $shipmentCharges[$shipmentId] = 0;
                    $shipmentOtherCosts[$shipmentId] = 0;
                }
            }
        }

        foreach($inventory as $key => $item) {
            $shipmentId = $item['lots'][0]->shipment->id ?? 0;
            $inventory[$key]['extra_shipment_charges'] = $shipmentCharges[$shipmentId] ?? 0;
            $inventory[$key]['other_costs_per_kg'] = $shipmentOtherCosts[$shipmentId] ?? 0;
            
            foreach($item['lots'] as $lotIndex => $lot) {
                $cif = $lot['total_price'] * number_format($lot->shipment->exchange_rate ?? 1, 2);
                $cifyen = $cif / $lot['total_qty'];
                $finalCostPerKg = $cifyen + ($shipmentCharges[$shipmentId] ?? 0);
                $lotOtherCosts = ($shipmentOtherCosts[$shipmentId] ?? 0) * $lot['total_qty'];
                
                $inventory[$key]['lots'][$lotIndex]['cif'] = $cif;
                $inventory[$key]['lots'][$lotIndex]['cifyen'] = $cifyen;
                $inventory[$key]['lots'][$lotIndex]['final_cost_per_kg'] = $finalCostPerKg;
                $inventory[$key]['lots'][$lotIndex]['lot_other_costs'] = $lotOtherCosts;
            }
            
            $productTotalQty = 0;
            $productTotalCost = 0;
            $productTotalCifYen = 0;
            $productTotalOtherCosts = 0;
            
            foreach($item['lots'] as $lot) {
                $productTotalQty += $lot['total_qty'];
                $productTotalCost += $lot['total_price'];
                $productTotalCifYen += $lot['total_price'] * number_format($lot->shipment->exchange_rate ?? 1, 2);
                $productTotalOtherCosts += ($shipmentOtherCosts[$shipmentId] ?? 0) * $lot['total_qty'];
            }
            
            $inventory[$key]['product_totals'] = [
                'qty' => $productTotalQty,
                'cost' => $productTotalCost,
                'cif_yen' => $productTotalCifYen,
                'other_costs' => $productTotalOtherCosts
            ];
        }

        $totalQty = 0;
        $totalCost = 0;
        $totalCifYen = 0;
        $totalOtherCosts = 0;

        foreach($inventory as $invItem) {
            foreach($invItem['lots'] as $invLot) {
                $totalQty += $invLot['total_qty'];
                $totalCost += $invLot['total_price'];
                $totalCifYen += $invLot['total_price'] * number_format($invLot->shipment->exchange_rate ?? 1, 2);
            }
            
            $shipmentId = $invItem['lots'][0]->shipment->id ?? 0;
            $productOtherCostsPerKg = $shipmentOtherCosts[$shipmentId] ?? 0;
            foreach($invItem['lots'] as $lot) {
                $totalOtherCosts += $productOtherCostsPerKg * $lot['total_qty'];
            }
        }

        $grandTotals = [
            'qty' => $totalQty,
            'cost' => $totalCost,
            'cif_yen' => $totalCifYen,
            'other_costs' => $totalOtherCosts
        ];

        return view('admin.inventory.index', compact('inventory', 'grandTotals'));
    }
}
