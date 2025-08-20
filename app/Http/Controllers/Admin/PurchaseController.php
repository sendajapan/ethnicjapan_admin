<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ShipmentsDataTable;
use App\Http\Controllers\Controller;
use App\Models\lot_photos;
use App\Models\Lot;
use App\Models\purchase;
use App\Models\PurchaseItem;
use App\Models\PurchaseCosts;
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
     * Create a new controllers instance.
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

            if ($request->has('costs')) {
                foreach ($request->input('costs') as $costData) {
                    if (!empty($costData['cost_name']) && !empty($costData['cost_amount'])) {
                        PurchaseCosts::create([
                            'shipment_id' => $shipment->id,
                            'cost_date' => $costData['cost_date'],
                            'cost_name' => $costData['cost_name'],
                            'cost_amount' => $costData['cost_amount'],
                            'description' => $costData['description'],
                        ]);
                    }
                }
            }

            $lotNumbers = $request->input('lot_number', []);

            for ($c = 1; $c <= 9; $c++) {
                for ($i = 1; $i <= 9; $i++) {
                    if (!empty($lotNumbers[$c][$i])) {
                        try {
                            $this->purchaseService->createLot($request, $shipment, $c, $i);
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
        $shipment = Shipment::where('id', $id)
            ->with(['lots.item', 'purchase_costs', 'provider'])
            ->firstOrFail()
            ->toArray();


        foreach($shipment['lots'] as $key=>$lot){
            if($lot['lot_unique']!=''){
                $photos = lot_photos::where('lot_unique', $lot['lot_unique'])->get()->toArray();
                $shipment['lots'][$key]['photos'] = $photos;
            }

        }

        return view('admin.purchase.detail', compact('shipment'));
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


    public function delete_lot_photo(){
        lot_photos::where('id', $_GET['id'])->delete();
    }


    public function delete_complete_lot(){
//        lot::where('lot_unique', $_GET['id'])->delete();
        echo $_GET('id');

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
            ->with(['lots', 'purchase_costs'])
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

            if ($request->has('costs')) {
                $submittedCostIds = [];
                foreach ($request->input('costs') as $costData) {
                    if (!empty($costData['cost_name']) && !empty($costData['cost_amount'])) {
                        if (!empty($costData['id'])) {
                            // Update existing cost
                            $cost = PurchaseCosts::find($costData['id']);
                            if ($cost) {
                                $cost->update($costData);
                                $submittedCostIds[] = $costData['id'];
                            }
                        } else {
                            // Create new cost
                            $newCost = new PurchaseCosts($costData);
                            $newCost->shipment_id = $updatedShipment->id;
                            $newCost->save();
                            $submittedCostIds[] = $newCost->id;
                        }
                    }
                }

                // Delete removed costs
                $existingCostIds = PurchaseCosts::where('shipment_id', $updatedShipment->id)->pluck('id')->toArray();
                $costsToDelete = array_diff($existingCostIds, $submittedCostIds);
                if (!empty($costsToDelete)) {
                    PurchaseCosts::destroy($costsToDelete);
                }
            } else {
                // If no costs are submitted, delete all existing costs for this shipment
                PurchaseCosts::where('shipment_id', $updatedShipment->id)->delete();
            }

            if ($request->has('lot_number')) {
                foreach ($request->input('lot_number') as $container => $containerData) {
                    foreach ($containerData as $lot => $lotData) {
                        if (!empty($lotData)) {
                            $this->purchaseService->createLot($request, $updatedShipment, $container, $lot);
                        }
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
            DB::transaction(function () use ($id) {
                $shipment = Shipment::where('id', $id)->firstOrFail();

                // Gather lot_uniques for this shipment
                $lotUniques = Lot::where('shipment_id', $shipment->id)
                    ->pluck('lot_unique')
                    ->filter()
                    ->toArray();

                // Delete lot photos for all lots in this shipment
                if (!empty($lotUniques)) {
                    lot_photos::whereIn('lot_unique', $lotUniques)->delete();
                }

                // Delete purchase costs for this shipment
                PurchaseCosts::where('shipment_id', $shipment->id)->delete();

                // Delete lots for this shipment
                Lot::where('shipment_id', $shipment->id)->delete();

                // Finally delete the shipment
                $shipment->delete();
            });
        } catch (Exception $exception) {
            return response(array('code' => 403, 'status' => 'failed', 'message' => $exception->getMessage()), 403, array('Content-Type' => 'application/json'));
        }

        return response(array('code' => 200,
            'status' => 'success',
            'message' => 'Purchase deleted successfully!!!',
        ), 200, array('Content-Type' => 'application/json'));
    }
}
