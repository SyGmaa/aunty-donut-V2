<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;

class Checkout extends Component
{
    public $name;
    public $phone;
    public $address;
    public $notes;
    public $items = [];
    public $total = 0;

    protected $rules = [
        'name' => 'required|min:3',
        'phone' => 'required|numeric|digits_between:10,13',
        'address' => 'required|min:5',
    ];

    public function mount()
    {
        $this->items = session()->get('cart', []);

        if (empty($this->items)) {
            return redirect()->route('home');
        }

        // Collect all variant IDs from all items
        $allVariantIds = [];
        foreach ($this->items as $item) {
            if (!empty($item['attributes']['selected_variants'])) {
                $allVariantIds = array_merge($allVariantIds, $item['attributes']['selected_variants']);
            }
        }
        $allVariantIds = array_unique($allVariantIds);

        // Fetch variant names
        $variants = \App\Models\Variant::whereIn('id', $allVariantIds)->pluck('name', 'id');

        // Attach names to items
        foreach ($this->items as &$item) {
            $item['variant_names'] = [];
            if (!empty($item['attributes']['selected_variants'])) {
                foreach ($item['attributes']['selected_variants'] as $vid) {
                    if (isset($variants[$vid])) {
                        $item['variant_names'][] = $variants[$vid];
                    }
                }
            }
            $item['variant_list_string'] = implode(', ', $item['variant_names']);
        }

        $this->total = collect($this->items)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function placeOrder()
    {
        $this->validate();

        // mimic transaction
        $order = Order::create([
            'user_id' => auth()->id(), // null if guest
            'customer_name' => $this->name,
            'customer_phone' => $this->phone,
            'address' => $this->address,
            'status' => 'pending',
            'total_price' => $this->total,
            'payment_method' => 'whatsapp', // simplified
            'payment_status' => 'pending',
            'notes' => $this->notes,
        ]);

        foreach ($this->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price_at_time' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
                'selected_variants' => $item['attributes']['selected_variants'] ?? [],
            ]);
        }

        // Clear cart
        session()->forget('cart');
        $this->dispatch('cart-updated');

        // Redirect to success or WhatsApp
        // For simplicity, let's flash success and redirect home or to a success page
        session()->flash('success', 'Order placed successfully! We will contact you shortly.');

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
