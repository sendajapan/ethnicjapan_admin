<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseCosts extends Model
{
    protected $table = 'purchase_costs';
    public $timestamps = false;

    protected $fillable = [
        'shipment_id',
        'cost_date',
        'cost_name',
        'cost_amount',
        'description',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'shipment_id');
    }
}
