<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSellingUnit extends Model
{
    use HasFactory;

    protected $table = 'data_selling_units';

    protected $fillable = [
        'unit_type',
        'unit_power',
    ];

    protected $casts = [
        'unit_power' => 'decimal:2',
    ];
}

