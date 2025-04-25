<?php

namespace App\Utils;

use App\Enums\ShipmentStatus;

class ColorUtils
{
    public static array $badgeClasses = [
        ShipmentStatus::PENDING->value => 'badge-soft-warning',
        ShipmentStatus::IN_TRANSIT->value => 'badge-soft-info',
        ShipmentStatus::RECEIVED->value => 'badge-soft-success',
        ShipmentStatus::CANCELLED->value => 'badge-soft-danger',
    ];
}
