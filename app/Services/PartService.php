<?php

namespace App\Services;

use App\Models\Part;
use App\Models\PartCategory;
use Illuminate\Database\Eloquent\Collection;

class PartService
{
    protected Collection $partCategories;

    public function __construct()
    {
        $this->partCategories = PartCategory::all();
    }

    public function storeVehicleParts($vehicleId): void
    {
        foreach ($this->partCategories as $partCategory) {
            $part = new Part();
            $part->vehicle_id = $vehicleId;
            $part->part_category_id = $partCategory->id;
            $part->quantity = $partCategory->quantity;
            $part->price = $partCategory->price;
            $part->save();
        }
    }
}
