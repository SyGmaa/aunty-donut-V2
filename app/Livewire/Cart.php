<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Variant;

class Cart extends Component
{
    public $items = [];
    public $total = 0;

    protected $listeners = [
        'cart-updated' => 'loadCart',
        'cart-opened' => 'loadCart',
    ];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->items = session()->get('cart', []);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = collect($this->items)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function removeItem($index)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            // Re-index array to prevent gaps
            $cart = array_values($cart);
            session()->put('cart', $cart);
        }

        $this->loadCart();
        $this->dispatch('cart-updated'); // Update count in header if needed
    }

    public function getVariantNames($item)
    {
        if (empty($item['attributes']['selected_variants'])) {
            return [];
        }

        $variantIds = $item['attributes']['selected_variants'];
        // Fetch variant names efficiently
        // In a real optimized app, we might store names in session to avoid N+1, 
        // but for now let's fetch.
        $variants = Variant::whereIn('id', $variantIds)->pluck('name', 'id');

        $names = [];
        foreach ($variantIds as $id) {
            if (isset($variants[$id])) {
                $names[] = $variants[$id];
            }
        }

        return $names;
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
