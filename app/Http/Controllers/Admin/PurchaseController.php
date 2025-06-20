<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
use App\DataTables\PurchasesDataTable;
use App\DataTables\ShipmentsDataTable;
use App\Http\Controllers\Controller;
use App\Models\lot_photos;
use App\Models\lots;
use App\Models\purchase;
use App\Models\PurchaseItem;
use App\Models\shipments;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(ShipmentsDataTable $dataTable)
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
            'invoice_number' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'commercial_invoice' => 'file|mimes:jpg,png,pdf|max:20480'
        ]);


        // Return success response
        DB::beginTransaction();
        try {
            $shipment = new shipments();

            $shipment->invoice_number = $request->input('invoice_number');
            $shipment->invoice_date = $request->input('invoice_date');
            $shipment->port_of_loading = $request->input('port_of_loading');
            $shipment->port_of_landing = $request->input('port_of_landing');
            $shipment->country_of_destination = $request->input('country_of_destination');
            $shipment->incoterm = $request->input('incoterm');
            $shipment->provider_id = $request->input('provider_id');
            $shipment->container_type = $request->input('container_type');
            $shipment->bl_number = $request->input('bl_number');
            $shipment->shipping_line = $request->input('shipping_line');
            $shipment->vessel = $request->input('vessel');
            $shipment->eta = $request->input('eta');
            $shipment->etd = $request->input('etd');
            $shipment->freight = $request->input('freight');
            $shipment->insurance = $request->input('insurance');
            $shipment->exchange_rate = $request->input('exchange_rate');
            $shipment->duties = $request->input('duties');
            $shipment->tax = $request->input('tax');
            $shipment->unpack = $request->input('unpack');
            $shipment->transport = $request->input('transport');
            $shipment->penalty = $request->input('penalty');
            $shipment->other_fee = $request->input('other_fee');
            $shipment->shipment_comment = $request->input('shipment_comment');

            if ($request->hasFile('commercial_invoice')) {
                $filePath = '';
                $filePath = $request->file('commercial_invoice')->store('uploads/purchase', 'public');
                $shipment->commercial_invoice = $filePath;
            }
            if ($request->hasFile('bl_telex_release')) {
                $filePath = '';
                $filePath = $request->file('bl_telex_release')->store('uploads/purchase', 'public');
                $shipment->bl_telex_release = $filePath;
            }
            if ($request->hasFile('packing_list')) {
                $filePath = '';
                $filePath = $request->file('packing_list')->store('uploads/purchase', 'public');
                $shipment->packing_list = $filePath;
            }
            if ($request->hasFile('origin_certificate')) {
                $filePath = '';
                $filePath = $request->file('origin_certificate')->store('uploads/purchase', 'public');
                $shipment->origin_certificate = $filePath;
            }
            if ($request->hasFile('phytosanitary')) {
                $filePath = '';
                $filePath = $request->file('phytosanitary')->store('uploads/purchase', 'public');
                $shipment->phytosanitary = $filePath;
            }

            $shipment->save();
            $shipment_id = $shipment->id;



            for($c=1; $c<=3; $c++){
                for($i=1; $i<=5; $i++){

                    if($request->input('lot_number')[$c][$i]!='') {

                    $lot = new lots();

                    $lot->shipments_id = $shipment_id;
                    $lot->lot_number = $request->input('lot_number')[$c][$i];
                    $lot->container_no = substr(substr($request->input('lot_unique')[$c][$i],-2),0,1);
                    $lot->lot_unique = $request->input('lot_unique')[$c][$i];
                    $lot->item_id = $request->input('item_id')[$c][$i];
                    $lot->package_kg = $request->input('package_kg')[$c][$i];
                    $lot->type_of_package = $request->input('type_of_package')[$c][$i];
                    $lot->total_packages = $request->input('total_packages')[$c][$i];
                    $lot->unit = $request->input('unit')[$c][$i];

                    $lot->total_qty = $request->input('total_qty')[$c][$i];
                    $lot->price_per_unit = $request->input('price_per_unit')[$c][$i];
                    $lot->total_price = $request->input('total_price')[$c][$i];
                    $lot->manufacture_date = $request->input('manufacture_date')[$c][$i];
                    $lot->crop_year = $request->input('crop_year')[$c][$i];
                    $lot->shelf_life = $request->input('shelf_life')[$c][$i];
                    $lot->best_before = $request->input('best_before')[$c][$i];
                    $lot->surveyor_name = $request->input('surveyor_name')[$c][$i];
                    $lot->loading_date = $request->input('loading_date')[$c][$i];
                    $lot->item_description = $request->input('item_description')[$c][$i];
                    $lot->lot_comment = $request->input('lot_comment')[$c][$i];

                        try {
                            if ($request->file('loading_report')[$c][$i]) {
                                $filePath = '';
                                $filePath = $request->file('loading_report')[$c][$i]->store('uploads/purchase', 'public');
                                $shipment->loading_report = $filePath;
                            }

                        } catch (Exception $exception) {

                        }

                    $lot->save();

                }

                }
            }

            DB::commit();

        } catch (Exception $exception) {

            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $shipment->invoice_number . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.purchase.index')->with('success', $shipment->invoice_number . ' inserted successfully.');
    }


    public function detail(string $id)
    {
        $data = shipments::where('id', $id)->firstOrFail();
        return view('admin.purchase.detail', compact('data'));
    }


    public function upload_lot_photo(Request $request)
    {


        if ($request->hasFile('lot_photos')) {

            $filePath = $request->file('lot_photos')->store('uploads/lot_photos', 'public');
            if(isset($filePath)){
                if(!empty($filePath)){

                    $lot_photos = new lot_photos();
                    $lot_photos->lot_unique = $_GET['lot_unique'];
                    $lot_photos->photo_url = $filePath;
                    $lot_photos->save();
                    DB::commit();


                    return $filePath;
                }
            }

        }

    }


    public function delete_lot_photo()
    {
        //
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
        $data = shipments::where('id', $id)->firstOrFail();
        print "<pre>";
        print_r($data);
        exit;
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
                    $purchaseItems->item_hts_code = $request->input('item_hts_code')[$key];
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
