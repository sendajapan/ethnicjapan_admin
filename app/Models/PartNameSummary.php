<?php

namespace App\Models;

class PartNameSummary
{
    public $part_name;
    public $total_quantity;
    public $total_sold;
    public $remaining_quantity;
    public $total_sold_price;
    public $total_discount;

    public function __construct($part_name, $total_quantity, $total_sold, $remaining_quantity,
                                $total_sold_price, $total_discount)
    {
        $this->part_name = $part_name;
        $this->total_quantity = $total_quantity;
        $this->total_sold = $total_sold;
        $this->remaining_quantity = $remaining_quantity;
        $this->total_sold_price = $total_sold_price;
        $this->total_discount = $total_discount;
    }
}
