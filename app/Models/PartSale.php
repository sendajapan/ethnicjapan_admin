<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PartSale extends Pivot
{
    protected $table = 'part_sale';
    public $incrementing = true;
    protected $fillable = ['part_id', 'sale_id', 'quantity_sold', 'price_at_sale'];

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}
