<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    public function purchasedItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function provider(): BelongsTo
    {
     return $this->belongsTo(Provider::class);
    }
}
