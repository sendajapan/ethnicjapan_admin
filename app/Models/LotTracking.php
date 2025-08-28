<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotTracking extends Model
{
    use HasFactory;

    protected $table = 'lot_tracking';

    protected $fillable = [
        'sale_item_id',
        'item_id',
        'lot_unique',
        'item_quantity',
    ];

    /**
     * Get the sale item that owns the lot tracking.
     */
    public function saleItem()
    {
        return $this->belongsTo(SaleItem::class);
    }

    /**
     * Get the item that owns the lot tracking.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
