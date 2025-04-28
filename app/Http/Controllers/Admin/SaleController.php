<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
use App\DataTables\SalesDataTable;
use App\Http\Controllers\Controller;
use App\Models\sale;
use App\Models\SaleItem;
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

        // Return success response
        DB::beginTransaction();
        try {
            $sale = new Sale();
            $sale->customer_id = $request->input('customer_id');
            $sale->sale_no = $request->input('sale_no');
            $sale->sale_date = $request->input('sale_date');
            $sale->sale_amount = $request->input('sale_amount');
            if(isset($filePath)){
                if(!empty($filePath)){
                    $sale->sale_invoice = $filePath;
                }
            }
            $sale->save();
            $sale_id = $sale->id;

            foreach($request->input('item_id') as $key=> $value){
                if(($request->input('item_id')[$key]) && ($request->input('item_qty')[$key]) && ($request->input('item_unit_price')[$key]) && ($request->input('item_line_price')[$key])){

                    $saleItems = new SaleItem();
                    $saleItems->sale_id = $sale_id;
                    $saleItems->item_id = $request->input('item_id')[$key];
                    $saleItems->item_description = $request->input('item_description')[$key];
                    $saleItems->item_qty = $request->input('item_qty')[$key];
                    $saleItems->item_unit_price = $request->input('item_unit_price')[$key];
                    $saleItems->item_line_price = $request->input('item_line_price')[$key];

                    $saleItems->save();
                }
            }
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
        $data = Sale::where('id', $id)->firstOrFail();
        //dd($data);
        return view('admin.sale.edit', compact('data'));
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
            $sale->sale_amount = $request->input('sale_amount');

            if(isset($filePath)){
                if(!empty($filePath)){
                    $sale->sale_invoice = $filePath;
                }
            }

            $sale->update();
            $sale_id = $sale->id;

            $sale->salesItems()->delete();

            foreach($request->input('item_id') as $key=> $value){
                if(($request->input('item_id')[$key]) && ($request->input('item_qty')[$key]) && ($request->input('item_unit_price')[$key]) && ($request->input('item_line_price')[$key])){
                    $saleItems = new SaleItem();
                    $saleItems->sale_id = $sale_id;
                    $saleItems->item_id = $request->input('item_id')[$key];
                    $saleItems->item_description = $request->input('item_description')[$key];
                    $saleItems->item_qty = $request->input('item_qty')[$key];
                    $saleItems->item_unit_price = $request->input('item_unit_price')[$key];
                    $saleItems->item_line_price = $request->input('item_line_price')[$key];

                    $saleItems->save();
                }
            }

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data ' . $sale->sale_no . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.sale.index')->with('success', $sale->sale_no . ' updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sale = Sale::where('id', $id)->firstOrFail();
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
}
