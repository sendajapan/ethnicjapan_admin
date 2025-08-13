<?php

namespace App\Services;

use App\Models\Lot;
use App\Models\Shipment;
use Exception;
use Illuminate\Http\Request;

class PurchaseService
{
    public function prepareDataFromRequest(Request $request, Shipment $shipment): Shipment
    {
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

        return $shipment;
    }

    public function createShipment(Request $request): Shipment
    {
        return $this->prepareDataFromRequest($request, new Shipment());
    }

    public function updateShipment(Request $request, Shipment $shipment): Shipment
    {
        return $this->prepareDataFromRequest($request, $shipment);
    }

    public function createLot(Request $request, Shipment $shipment, int $c, int $i): void
    {
        $lotData = [
            'shipment_id' => $shipment->id,
            'lot_number' => $request->input('lot_number')[$c][$i],
            'container_no' => substr(substr($request->input('lot_unique')[$c][$i], -2), 0, 1),
            'item_id' => $request->input('item_id')[$c][$i],
            'package_kg' => $request->input('package_kg')[$c][$i],
            'type_of_package' => $request->input('type_of_package')[$c][$i],
            'total_packages' => $request->input('total_packages')[$c][$i],
            'unit' => $request->input('unit')[$c][$i],
            'total_qty' => $request->input('total_qty')[$c][$i],
            'price_per_unit' => $request->input('price_per_unit')[$c][$i],
            'total_price' => $request->input('total_price')[$c][$i],
            'manufacture_date' => $request->input('manufacture_date')[$c][$i],
            'crop_year' => $request->input('crop_year')[$c][$i],
            'shelf_life' => $request->input('shelf_life')[$c][$i],
            'best_before' => $request->input('best_before')[$c][$i],
            'surveyor_name' => $request->input('surveyor_name')[$c][$i],
            'loading_date' => $request->input('loading_date')[$c][$i],
            'item_description' => $request->input('item_description')[$c][$i],
            'lot_comment' => $request->input('lot_comment')[$c][$i],
        ];

        // Only add the loading_report to the data array if a new file is uploaded.
        // This prevents updateOrCreate from overwriting an existing path with null.
        $fileInputName = "loading_report.{$c}.{$i}";
        if ($request->hasFile($fileInputName) && $request->file($fileInputName)->isValid()) {
            try {
                $filePath = $request->file($fileInputName)->store('uploads/purchase', 'public');
                $lotData['loading_report'] = $filePath;
            } catch (Exception $exception) {
                // Log error
            }
        }

        Lot::updateOrCreate(
            ['lot_unique' => $request->input('lot_unique')[$c][$i]],
            $lotData
        );
    }

}
