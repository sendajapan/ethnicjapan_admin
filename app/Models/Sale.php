<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    use HasFactory;

    public function parts(): BelongsToMany
    {
        return $this->belongsToMany(Part::class)->withPivot(['quantity_sold', 'price_at_sale', 'created_at', 'updated_at']);
    }
}
