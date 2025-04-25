<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function purchasedItems(): void
    {
        $this->hasMany(PurchaseItem::class);
    }
}
