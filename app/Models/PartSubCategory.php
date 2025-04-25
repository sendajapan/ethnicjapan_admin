<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PartSubCategory extends Model
{
    use HasFactory;

    public function partCategory(): BelongsTo
    {
        return $this->belongsTo(PartCategory::class);
    }

    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class)
            ->withPivot(['quantity_sold', 'price_at_sale', 'created_at', 'updated_at']);
    }
}
