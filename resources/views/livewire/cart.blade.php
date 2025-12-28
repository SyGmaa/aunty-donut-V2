<div class="flex flex-col h-full bg-white shadow-xl">
    <div class="flex-1 overflow-y-auto py-6 px-4 sm:px-6">
        <div class="flex items-start justify-between">
            <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
            <div class="ml-3 flex h-7 items-center">
                <button type="button" @click="cartOpen = false"
                    class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Close panel</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="mt-8">
            <div class="flow-root">
                <ul role="list" class="-my-6 divide-y divide-gray-200">
                    @forelse($items as $index => $item)
                    <li class="flex py-6">
                        <!-- Image placeholder or product image if available -->
                        <div
                            class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-gray-100 flex items-center justify-center text-2xl">
                            🍩
                        </div>

                        <div class="ml-4 flex flex-1 flex-col">
                            <div>
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <h3>
                                        <a href="#">{{ $item['name'] }}</a>
                                    </h3>
                                    <p class="ml-4">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                @if(isset($item['attributes']['selected_variants']))
                                @php
                                $variantNames = $this->getVariantNames($item);
                                $counts = array_count_values($variantNames);
                                @endphp
                                <p class="mt-1 text-sm text-gray-500">
                                    @foreach($counts as $name => $count)
                                    {{ $count }}x {{ $name }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                                @endif
                            </div>
                            <div class="flex flex-1 items-end justify-between text-sm">
                                <p class="text-gray-500">Qty {{ $item['quantity'] }}</p>

                                <div class="flex">
                                    <button type="button" wire:click="removeItem({{ $index }})"
                                        class="font-medium text-pink-600 hover:text-pink-500">Remove</button>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="py-6 text-center text-gray-500">
                        Your cart is empty.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    @if(count($items) > 0)
    <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
        <div class="flex justify-between text-base font-medium text-gray-900">
            <p>Subtotal</p>
            <p>Rp {{ number_format($total, 0, ',', '.') }}</p>
        </div>
        <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
        <div class="mt-6">
            <a href="/checkout"
                class="flex items-center justify-center rounded-md border border-transparent bg-pink-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-pink-700">Checkout</a>
        </div>
        <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
            <p>
                or
                <button type="button" @click="cartOpen = false" class="font-medium text-pink-600 hover:text-pink-500">
                    Continue Shopping
                    <span aria-hidden="true"> &rarr;</span>
                </button>
            </p>
        </div>
    </div>
    @endif
</div>