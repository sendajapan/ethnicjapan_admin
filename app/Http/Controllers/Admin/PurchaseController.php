<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
use App\DataTables\PurchasesDataTable;
use App\Http\Controllers\Controller;
use App\Models\purchase;
use App\Models\PurchaseItem;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(PurchasesDataTable $dataTable)
    {
        return $dataTable->render('admin.purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.purchase.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'provider_id' => 'required|integer|max:255',
            'purchase_no' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'purchase_invoice' => 'file|mimes:jpg,png,pdf|max:20480'
        ]);

        if ($request->hasFile('purchase_invoice')) {
            $filePath = $request->file('purchase_invoice')->store('uploads/purchase', 'public');
        }

        // Return success response
        DB::beginTransaction();
        try {
            $purchase = new Purchase();
            $purchase->provider_id = $request->input('provider_id');
            $purchase->purchase_no = $request->input('purchase_no');
            $purchase->purchase_date = $request->input('purchase_date');
            $purchase->purchase_amount = $request->input('purchase_amount');
            if(isset($filePath)){
                if(!empty($filePath)){
                    $purchase->purchase_invoice = $filePath;
                }
            }
            $purchase->save();
            $purchase_id = $purchase->id;

            foreach($request->input('item_id') as $key=> $value){
                if(($request->input('item_id')[$key]) && ($request->input('item_qty')[$key]) && ($request->input('item_unit_price')[$key]) && ($request->input('item_line_price')[$key])){

                    $purchaseItems = new PurchaseItem();
                    $purchaseItems->purchase_id = $purchase_id;
                    $purchaseItems->item_id = $request->input('item_id')[$key];
                    $purchaseItems->item_description = $request->input('item_description')[$key];
                    $purchaseItems->item_qty = $request->input('item_qty')[$key];
                    $purchaseItems->item_unit_price = $request->input('item_unit_price')[$key];
                    $purchaseItems->item_line_price = $request->input('item_line_price')[$key];

                    $purchaseItems->save();
                }
            }
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $purchase->purchase_no . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.purchase.index')->with('success', $purchase->purchase_no . ' inserted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Purchase::where('id', $id)->firstOrFail();
        //dd($data);
        return view('admin.purchase.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'provider_id' => 'required|integer|max:255',
            'purchase_no' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'purchase_invoice' => 'file|mimes:jpg,png,pdf|max:20480'
        ]);

        if ($request->hasFile('purchase_invoice')) {
            $filePath = $request->file('purchase_invoice')->store('uploads/purchase', 'public');
        }

        DB::beginTransaction();
        try {
            $purchase->provider_id = $request->input('provider_id');
            $purchase->purchase_no = $request->input('purchase_no');
            $purchase->purchase_date = $request->input('purchase_date');
            $purchase->purchase_amount = $request->input('purchase_amount');

            if(isset($filePath)){
                if(!empty($filePath)){
                    $purchase->purchase_invoice = $filePath;
                }
            }

            $purchase->update();
            $purchase_id = $purchase->id;

            $purchase->purchasedItems()->delete();

            foreach($request->input('item_id') as $key=> $value){
                if(($request->input('item_id')[$key]) && ($request->input('item_qty')[$key]) && ($request->input('item_unit_price')[$key]) && ($request->input('item_line_price')[$key])){
                    $purchaseItems = new PurchaseItem();
                    $purchaseItems->purchase_id = $purchase_id;
                    $purchaseItems->item_id = $request->input('item_id')[$key];
                    $purchaseItems->item_description = $request->input('item_description')[$key];
                    $purchaseItems->item_qty = $request->input('item_qty')[$key];
                    $purchaseItems->item_unit_price = $request->input('item_unit_price')[$key];
                    $purchaseItems->item_line_price = $request->input('item_line_price')[$key];

                    $purchaseItems->save();
                }
            }

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data ' . $purchase->purchase_no . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.purchase.index')->with('success', $purchase->purchase_no . ' updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $purchase = Purchase::where('id', $id)->firstOrFail();
            $purchase->purchasedItems()->delete();
            $purchase->delete();
        } catch (Exception $exception) {
            return response(array('code' => 403, 'status' => 'failed', 'message' => $exception->getMessage()), 403, array('Content-Type' => 'application/json'));
        }

        return response(array('code' => 200,
            'status' => 'success',
            'message' => 'Purchase deleted successfully!!!',
        ), 200, array('Content-Type' => 'application/json'));
    }
}
