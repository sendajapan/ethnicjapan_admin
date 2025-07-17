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

    public function createLot(Request $request, Shipment $shipment, int $c, int $i): Lot
    {
        $lot = new Lot();

        $lot->shipment_id = $shipment->id;
        $lot->lot_number = $request->input('lot_number')[$c][$i];
        $lot->container_no = substr(substr($request->input('lot_unique')[$c][$i], -2), 0, 1);
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
            echo $exception->getMessage();
        }

        return $lot;
    }

}
