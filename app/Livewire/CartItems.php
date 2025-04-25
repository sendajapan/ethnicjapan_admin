<?php

namespace App\Livewire;

use Livewire\Component;

class CartItems extends Component
{
    public string $bookingId = 'hello';


    public $count = 1;

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function render()
    {
        return view('livewire.cart-items');
    }
}
