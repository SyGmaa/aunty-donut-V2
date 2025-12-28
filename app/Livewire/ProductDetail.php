<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Variant;
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart($selections = [], $quantity = 1)
    {
        // Validation Logic for Bundle
        if ($this->product->is_bundle) {
            $totalSelected = array_sum($selections);
            if ($totalSelected !== $this->product->bundle_size) {
                $this->dispatch('notify', 'Selection count mismatch! Please try again.');
                return;
            }
        }

        // Prepare variant IDs from selections (simulated or real)
        $variantIds = [];
        if (is_array($selections)) {
            foreach ($selections as $vid => $count) {
                for ($i = 0; $i < $count; $i++) {
                    $variantIds[] = (int) $vid;
                }
            }
        } elseif (is_numeric($selections)) {
            // Handle legacy single selection if passed (fallback)
            $variantIds[] = (int) $selections;
        }

        // Determine quantity
        // For Bundles: Quantity is usually 1 (one box) unless specified otherwise.
        // For Singles: Quantity is the count of items selected (count($variantIds)) OR passed quantity.
        $finalQuantity = $quantity;

        if (!$this->product->is_bundle && !empty($variantIds)) {
            // If we are adding multiple single items via the selection grid
            $finalQuantity = count($variantIds);
        }

        $cartItemData = [
            'product_id' => $this->product->id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'quantity' => $finalQuantity,
            'attributes' => [
                'selected_variants' => $variantIds
            ],
        ];

        $cart = session()->get('cart', []);
        $cart[] = $cartItemData;
        session()->put('cart', $cart);

        $this->dispatch('cart-updated');
        session()->flash('success', 'Added ' . $finalQuantity . ' items to cart!');
    }

    public function render()
    {
        return view('livewire.product-detail');
    }
}
