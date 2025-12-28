<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public function render()
    {
        return view('livewire.product-list', [
            'products' => Product::where('is_active', true)->get(),
        ]);
    }
}
