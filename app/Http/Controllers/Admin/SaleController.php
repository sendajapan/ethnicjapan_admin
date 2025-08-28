<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
use App\DataTables\SalesDataTable;
use App\Http\Controllers\Controller;
use App\Models\sale;
use App\Models\SaleItem;
use App\Models\Lot;
use App\Models\LotTracking;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(SalesDataTable $dataTable)
    {
        return $dataTable->render('admin.sale.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.sale.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|max:255',
            'sale_no' => 'required|string|max:255',
            'sale_date' => 'required|date',
            'sale_invoice' => 'file|mimes:jpg,png,pdf|max:20480'
        ]);

        if ($request->hasFile('sale_invoice')) {
            $filePath = $request->file('sale_invoice')->store('uploads/sale', 'public');
        }

        DB::beginTransaction();
        try {
            $sale = new Sale();
            $sale->customer_id = $request->input('customer_id');
            $sale->sale_no = $request->input('sale_no');
            $sale->sale_date = $request->input('sale_date');
            $sale->total_sale = 0;
            if(isset($filePath)){
                if(!empty($filePath)){
                    $sale->sale_invoice = $filePath;
                }
            }
            $sale->save();
            $sale_id = $sale->id;

            $subtotal = 0;
            foreach($request->input('item_id') as $key=> $value){
                if(($request->input('item_id')[$key]) && ($request->input('item_qty')[$key]) && ($request->input('item_unit_price')[$key]) && ($request->input('item_line_price')[$key])){

                    $saleItems = new SaleItem();
                    $saleItems->sale_id = $sale_id;
                    $saleItems->item_id = $request->input('item_id')[$key];
                    $saleItems->item_description = $request->input('item_description')[$key] ?? '';
                    $saleItems->item_qty = $request->input('item_qty')[$key];
                    $saleItems->item_unit = $request->input('item_unit')[$key] ?? 'Package';
                    $saleItems->item_unit_price = $request->input('item_unit_price')[$key];
                    $saleItems->item_line_price = $request->input('item_line_price')[$key];

                    $saleItems->save();
                                        $this->createLotTrackingEntries(
                        $saleItems->id,
                        $request->input('item_id')[$key],
                        $request->input('item_qty')[$key]
                    );
                    
                    $subtotal += $request->input('item_line_price')[$key];
                }
            }
            
            $tax = $subtotal * 0.08;
            $totalWithTax = $subtotal + $tax;           
            $sale->net_sale = $subtotal;
            $sale->tax = $tax;
            $sale->total_sale = $totalWithTax;
            $sale->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $sale->sale_no . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.sale.index')->with('success', $sale->sale_no . ' inserted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Sale::with('saledItems')->where('id', $id)->firstOrFail();
        $items = \App\Models\Item::all();
        return view('admin.sale.edit', compact('data', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'customer_id' => 'required|integer|max:255',
            'sale_no' => 'required|string|max:255',
            'sale_date' => 'required|date',
            'sale_invoice' => 'file|mimes:jpg,png,pdf|max:20480'
        ]);

        if ($request->hasFile('sale_invoice')) {
            $filePath = $request->file('sale_invoice')->store('uploads/sale', 'public');
        }

        DB::beginTransaction();
        try {
            $sale->customer_id = $request->input('customer_id');
            $sale->sale_no = $request->input('sale_no');
            $sale->sale_date = $request->input('sale_date');

            if(isset($filePath)){
                if(!empty($filePath)){
                    $sale->sale_invoice = $filePath;
                }
            }

            $sale_id = $sale->id;
            $existingSaleItems = $sale->salesItems()->get()->keyBy('id');
            $processedItemIds = [];

            $subtotal = 0;
            foreach($request->input('item_id') as $key=> $value){
                if(($request->input('item_id')[$key]) && ($request->input('item_qty')[$key]) && ($request->input('item_unit_price')[$key]) && ($request->input('item_line_price')[$key])){
                    
                    $saleItemId = $request->input('sale_item_id')[$key] ?? null;
                    $saleItems = null;
                    
                    if ($saleItemId && isset($existingSaleItems[$saleItemId])) {
                        $saleItems = $existingSaleItems[$saleItemId];
                        $processedItemIds[] = $saleItemId;
                        
                        LotTracking::where('sale_item_id', $saleItems->id)->delete();
                    } else {
                        // Create new sale item
                        $saleItems = new SaleItem();
                        $saleItems->sale_id = $sale_id;
                    }
                    
                    $saleItems->item_id = $request->input('item_id')[$key];
                    $saleItems->item_description = $request->input('item_description')[$key] ?? '';
                    $saleItems->item_qty = $request->input('item_qty')[$key];
                    $saleItems->item_unit = $request->input('item_unit')[$key] ?? 'Package';
                    $saleItems->item_unit_price = $request->input('item_unit_price')[$key];
                    $saleItems->item_line_price = $request->input('item_line_price')[$key];

                    $saleItems->save();
                                        $this->createLotTrackingEntries(
                        $saleItems->id,
                        $request->input('item_id')[$key],
                        $request->input('item_qty')[$key]
                    );
                    
                    $subtotal += $request->input('item_line_price')[$key];
                }
            }
                        foreach ($existingSaleItems as $existingItem) {
                if (!in_array($existingItem->id, $processedItemIds)) {
                    LotTracking::where('sale_item_id', $existingItem->id)->delete();
                    $existingItem->delete();
                }
            }
            
            $tax = $subtotal * 0.08;
            $totalWithTax = $subtotal + $tax;
            $sale->net_sale = $subtotal;
            $sale->tax = $tax;
            $sale->total_sale = $totalWithTax;
            $sale->update();

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data ' . $sale->sale_no . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.sale.index')->with('success', $sale->sale_no . ' updated successfully.');

    }

    /**
     * Get sale details for modal display
     */
    public function details(string $id)
    {
        $sale = Sale::with(['salesItems.item', 'customer'])->findOrFail($id);
        $subtotal = $sale->salesItems->sum('item_line_price');
        $tax = $subtotal * 0.08;
        $totalWithTax = $subtotal + $tax;     
        return view('admin.sale.details-modal', compact('sale', 'subtotal', 'tax', 'totalWithTax'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sale = Sale::where('id', $id)->firstOrFail();
            $saleItems = $sale->salesItems()->get();
            foreach ($saleItems as $saleItem) {
                LotTracking::where('sale_item_id', $saleItem->id)->delete();
            }          
            $sale->salesItems()->delete();
            $sale->delete();
        } catch (Exception $exception) {
            return response(array('code' => 403, 'status' => 'failed', 'message' => $exception->getMessage()), 403, array('Content-Type' => 'application/json'));
        }

        return response(array('code' => 200,
            'status' => 'success',
            'message' => 'Sale deleted successfully!!!',
        ), 200, array('Content-Type' => 'application/json'));
    }

    private function createLotTrackingEntries($saleItemId, $itemId, $quantity)
    {
        $remainingQty = floatval($quantity);    
        // Get available lots
        $lots = Lot::where('item_id', $itemId)
            ->orderBy('created_at', 'asc')
            ->get();
            
            


        foreach ($lots as $lot) {
            if ($remainingQty <= 0) break;
                        $soldFromLot = LotTracking::where('lot_unique', $lot->lot_unique)->sum('item_quantity');
            $availableInLot = floatval($lot->total_qty) - floatval($soldFromLot);          
            if ($availableInLot > 0) {
                $takeFromLot = min($remainingQty, $availableInLot);              
                // Create tracking entry
                LotTracking::create([
                    'sale_item_id' => $saleItemId,
                    'item_id' => $itemId,
                    'lot_unique' => $lot->lot_unique,
                    'item_quantity' => $takeFromLot
                ]);
                
                $remainingQty -= $takeFromLot;
            }
        }





                if ($remainingQty > 0) {
            LotTracking::create([
                'sale_item_id' => $saleItemId,
                'item_id' => $itemId,
                'lot_unique' => null,
                'item_quantity' => $remainingQty
            ]);
        }
    }
}
