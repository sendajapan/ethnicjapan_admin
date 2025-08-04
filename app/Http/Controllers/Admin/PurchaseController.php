<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ShipmentsDataTable;
use App\Http\Controllers\Controller;
use App\Models\lot_photos;
use App\Models\Lot;
use App\Models\purchase;
use App\Models\PurchaseItem;
use App\Models\Shipment;
use App\Services\PurchaseService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    protected PurchaseService $purchaseService;

    /**
     * Create a new controller instance.
     */
    public function __construct(){
        $this->purchaseService = new PurchaseService();
    }

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
            $shipment = $this->purchaseService->createShipment($request);
            $shipment->save();

            $lotNumbers = $request->input('lot_number', []);

            for ($c = 1; $c <= 9; $c++) {
                for ($i = 1; $i <= 9; $i++) {
                    if (!empty($lotNumbers[$c][$i])) {
                        try {
                            $lot = $this->purchaseService->createLot($request, $shipment, $c, $i);
                            $lot->save();
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
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
        $data = Shipment::where('id', $id)->firstOrFail();
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
    public function edit(string $id): View
    {
        $shipment = Shipment::where('id', $id)
            ->with('lots')
            ->firstOrFail()->toArray();


        foreach($shipment['lots'] as $key=>$lot){
            if($lot['lot_unique']!=''){
                $photos = lot_photos::where('lot_unique', $lot['lot_unique'])->get()->toArray();
                $shipment['lots'][$key]['photos'] = $photos;
            }

        }

        return view('admin.purchase.edit', compact('shipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'provider_id' => 'required|integer|max:255',
            'invoice_number' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'commercial_invoice' => 'file|mimes:jpg,png,pdf|max:20480'
        ]);

        DB::beginTransaction();

        if(isset($_POST['photos'])){
            if(count($_POST['photos'])>0){
                foreach($_POST['photos'] as $lot_unique => $photo) {
                    lot_photos::where('lot_unique', $lot_unique)->delete();
                }

                foreach($_POST['photos'] as $lot_unique => $photo){
                    foreach($photo as $p) {
                        $lot_photos = new lot_photos();
                        $lot_photos->lot_unique = $lot_unique;
                        $lot_photos->photo_url = $p;
                        $lot_photos->save();
                        DB::commit();
                    }
                }
            }
        }

        try {

            $updatedShipment = $this->purchaseService->updateShipment($request, Shipment::where('id', $id)->firstOrFail());
            $updatedShipment->save();

            // Delete existing lots from the shipment
            Lot::where('shipment_id', $updatedShipment->id)->delete();

            // for debugging purposes : echo "container $container: { lot $lot: value -> {$lotData}}<br>";
            foreach ($request->input('lot_number') as $container => $containerData) {
                foreach ($containerData as $lot => $lotData) {
                    if (!empty($lotData)) {
                        $lot = $this->purchaseService->createLot($request, $updatedShipment, $container, $lot);
                        $lot->save();
                    }
                }
            }

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating ' . $updatedShipment->invoice_number . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.purchase.index')->with('success', $updatedShipment->invoice_number . ' updated successfully.');
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
