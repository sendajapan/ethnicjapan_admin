<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lot extends Model
{
    protected $fillable = [
        'shipment_id',
        'lot_unique',
        'lot_number',
        'container_no',
        'item_id',
        'package_kg',
        'type_of_package',
        'total_packages',
        'unit',
        'total_qty',
        'price_per_unit',
        'total_price',
        'manufacture_date',
        'crop_year',
        'shelf_life',
        'best_before',
        'surveyor_name',
        'loading_date',
        'item_description',
        'lot_comment',
        'loading_report',
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
