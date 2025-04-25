<?php

namespace App\Services;

use App\Models\Vehicle;

class VehicleService
{
    public function storeVehiclesFromShipment($shipmentId, $vehicleData): Vehicle
    {
        $vehicle = new Vehicle();
        $vehicle->shipment_id = $shipmentId;
        $vehicle->input_date = $vehicleData->input_date;
        $vehicle->provider_name = $vehicleData->provider_name;
        $vehicle->origin_id = $vehicleData->origin_id;
        $vehicle->make_id = $vehicleData->make_id;
        $vehicle->make_title = $vehicleData->make_title;
        $vehicle->model_id = $vehicleData->model_id;
        $vehicle->model_title = $vehicleData->model_title;
        $vehicle->grade = $vehicleData->grade;
        $vehicle->chassis_model = $vehicleData->chassis_model;
        $vehicle->chassis_number = $vehicleData->chassis_number;
        $vehicle->veh_fuel = $vehicleData->veh_fuel;
        $vehicle->veh_trans = $vehicleData->veh_trans;
        $vehicle->veh_traction = $vehicleData->veh_traction;
        $vehicle->veh_km = $vehicleData->veh_km;
        $vehicle->veh_cc = $vehicleData->veh_cc;
        $vehicle->veh_year = $vehicleData->veh_year;
        $vehicle->veh_month = $vehicleData->veh_month;
        $vehicle->veh_color = $vehicleData->veh_color;
        $vehicle->gross_weight = $vehicleData->gross_weight;
        $vehicle->net_weight = $vehicleData->net_weight;
        $vehicle->veh_length = $vehicleData->veh_length;
        $vehicle->veh_height = $vehicleData->veh_height;
        $vehicle->veh_width = $vehicleData->veh_width;
        $vehicle->other_info = $vehicleData->other_info;
        $vehicle->engine_type = $vehicleData->engine_type;
        $vehicle->engine_no = $vehicleData->engine_no;
        $vehicle->purchase_price = $vehicleData->purchase_price;

        $vehicle->save();

        return $vehicle;
    }

}
