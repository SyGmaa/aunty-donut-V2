<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\Session; // Or use a Cart ServiceFacade if available
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $product;

    // Stores the count for each flavor: [variant_id => count]
    public array $selectedVariants = [];

    public function mount(Product $product)
    {
        $this->product = $product;

        // Initialize counts to 0 for all available variants
        if ($this->product->is_bundle) {
            foreach ($this->product->variants as $variant) {
                $this->selectedVariants[$variant->id] = 0;
            }
        }
    }

    public function getSelectedCountProperty(): int
    {
        return array_sum($this->selectedVariants);
    }

    public function getIsFullProperty(): bool
    {
        if (! $this->product->is_bundle) {
            return true; // Single products are always "ready"
        }

        return $this->selectedCount === $this->product->bundle_size;
    }

    public function increment($variantId)
    {
        if ($this->isFull) {
            // Optional: Notification or flash message that box is full
            return;
        }

        if (! isset($this->selectedVariants[$variantId])) {
            $this->selectedVariants[$variantId] = 0;
        }

        // Optional: Check individual variant stock here if needed

        $this->selectedVariants[$variantId]++;
    }

    public function decrement($variantId)
    {
        if (($this->selectedVariants[$variantId] ?? 0) > 0) {
            $this->selectedVariants[$variantId]--;
        }
    }

    public function addToCart()
    {
        if (! $this->isFull) {
            $this->dispatch('notify', 'Please complete your selection first!');
            return;
        }

        // Prepare info for Cart
        // In a real app, you'd likely depend on a Cart package (like Gloudemans/shoppingcart)
        // or a database-driven Cart model.
        // Here I will demonstrate the logic of resolving the flavors into a list for storage.

        $cartItemData = [
            'product_id' => $this->product->id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'quantity' => 1, // Buying 1 box
            'attributes' => [],
        ];

        if ($this->product->is_bundle) {
            // Convert [1 => 2, 5 => 4] into [1, 1, 5, 5, 5, 5] (List of IDs)
            // or a nice list of names ['Choco', 'Choco', 'Berry', ...]

            $variantIds = [];
            foreach ($this->selectedVariants as $vid => $count) {
                for ($i = 0; $i < $count; $i++) {
                    $variantIds[] = $vid;
                }
            }

            // Store this in the cart attributes or special field
            $cartItemData['attributes']['selected_variants'] = $variantIds;

            // Add extra prices if variants have them?
            // (Current requirement didn't specify, but good to note)
        }

        // SIMULATION: Add to session cart for now
        $cart = session()->get('cart', []);
        $cart[] = $cartItemData;
        session()->put('cart', $cart);

        $this->dispatch('cart-updated'); // Event to update header cart count

        // Reset selection or redirect
        $this->resetSelection();

        session()->flash('success', 'Added to cart!');
    }

    public function resetSelection()
    {
        if ($this->product->is_bundle) {
            foreach ($this->selectedVariants as $key => $val) {
                $this->selectedVariants[$key] = 0;
            }
        }
    }

    public function render()
    {
        return view('livewire.product-detail');
    }
}
