<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PartCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }

    public function partSubCategories(): HasMany
    {
        return $this->hasMany(PartSubCategory::class);
    }

    public function getPartDetails(): PartNameSummary
    {
        $totalQuantity = $this->parts->sum(function (Part $part) {
            return $part->quantity;
        });

        $totalSold = $this->parts->sum(function (Part $part) {
            return $part->sales->sum(function (Sale $sale) {
                return $sale->pivot->quantity_sold;
            });
        });

        $remainingQuantity = $totalQuantity - $totalSold;

        $totalSoldPrice = $this->parts->sum(function (Part $part) {
            return $part->sales->sum(function (Sale $sale) {
                return $sale->pivot->price_at_sale * $sale->pivot->quantity_sold;
            });
        });

        $totalDiscount = $this->parts->flatMap(function ($part) {
            return $part->sales->pluck('pivot.discount_percentage');
        })->sum();

        return new PartNameSummary(
            $this->name,
            $totalQuantity,
            $totalSold,
            $remainingQuantity,
            $totalSoldPrice,
            $totalDiscount
        );
    }
}
