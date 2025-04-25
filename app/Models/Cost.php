<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cost extends Model
{
    use HasFactory;

    public function shipments(): BelongsToMany {
        return $this->belongsToMany(Shipment::class)
            ->withPivot('amount')
            ->withTimestamps();
    }
}
