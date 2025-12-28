<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 bg-gray-50/50 min-h-screen">
    <h1
        class="text-4xl font-extrabold text-center text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-purple-600 mb-10">
        Checkout
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Delivery Details Form -->
        <div
            class="md:col-span-2 bg-white px-8 py-8 rounded-3xl shadow-xl shadow-pink-500/5 border border-pink-100/50 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-pink-400 to-purple-500"></div>
            <h2 class="text-2xl font-bold text-gray-800 mb-8 flex items-center gap-3">
                <div class="p-2 bg-pink-50 rounded-lg">
                    <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                Delivery Details
            </h2>

            <form wire:submit.prevent="placeOrder" class="space-y-6">
                <!-- Name -->
                <div class="group">
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2 transition-colors group-focus-within:text-pink-600">Name</label>
                    <input wire:model="name" type="text" placeholder="Your full name"
                        class="block w-full rounded-xl border-gray-200 bg-gray-50 px-5 py-4 text-gray-800 placeholder-gray-400 focus:border-pink-500 focus:bg-white focus:ring-4 focus:ring-pink-500/10 transition-all duration-300 ease-in-out">
                    @error('name') <span class="text-red-500 text-sm mt-1 block pl-1">{{ $message }}</span> @enderror
                </div>

                <!-- Phone -->
                <div class="group">
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2 transition-colors group-focus-within:text-pink-600">Phone
                        (WhatsApp)</label>
                    <input wire:model="phone" type="text" placeholder="08..."
                        class="block w-full rounded-xl border-gray-200 bg-gray-50 px-5 py-4 text-gray-800 placeholder-gray-400 focus:border-pink-500 focus:bg-white focus:ring-4 focus:ring-pink-500/10 transition-all duration-300 ease-in-out">
                    @error('phone') <span class="text-red-500 text-sm mt-1 block pl-1">{{ $message }}</span> @enderror
                </div>

                <!-- Address -->
                <div class="group">
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2 transition-colors group-focus-within:text-pink-600">Delivery
                        Address</label>
                    <textarea wire:model="address" rows="3" placeholder="Full street address including city..."
                        class="block w-full rounded-xl border-gray-200 bg-gray-50 px-5 py-4 text-gray-800 placeholder-gray-400 focus:border-pink-500 focus:bg-white focus:ring-4 focus:ring-pink-500/10 transition-all duration-300 ease-in-out resize-none"></textarea>
                    @error('address') <span class="text-red-500 text-sm mt-1 block pl-1">{{ $message }}</span> @enderror
                </div>

                <!-- Notes -->
                <div class="group">
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2 transition-colors group-focus-within:text-pink-600">Notes
                        (Optional)</label>
                    <textarea wire:model="notes" rows="2"
                        placeholder="Special instructions for the driver or messages..."
                        class="block w-full rounded-xl border-gray-200 bg-gray-50 px-5 py-4 text-gray-800 placeholder-gray-400 focus:border-pink-500 focus:bg-white focus:ring-4 focus:ring-pink-500/10 transition-all duration-300 ease-in-out resize-none"></textarea>
                </div>

                <div class="pt-8">
                    <button type="submit"
                        class="group w-full flex justify-center items-center gap-3 py-4 px-6 border border-transparent rounded-2xl shadow-lg shadow-pink-500/30 text-lg font-bold text-white bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-500/40 transform hover:-translate-y-1 transition-all duration-300">
                        <span>Place Order</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                    <!-- Loading state indicator -->
                    <div wire:loading wire:target="placeOrder" class="w-full text-center mt-3">
                        <span class="inline-flex items-center gap-2 text-sm text-pink-600 font-medium">
                            <svg class="animate-spin h-4 w-4 text-pink-600" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Processing order...
                        </span>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="bg-white p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 h-fit sticky top-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 flex items-center gap-3">
                <div class="p-2 bg-pink-50 rounded-lg">
                    <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                Order Summary
            </h2>

            <ul class="divide-y divide-gray-100 mb-8">
                @foreach($items as $item)
                <li class="py-4 flex justify-between items-start group first:pt-0">
                    <div class="flex-1 pr-4">
                        <p class="font-bold text-gray-800 group-hover:text-pink-600 transition-colors">{{ $item['name']
                            }}</p>
                        @if(!empty($item['variant_list_string']))
                        <p class="text-xs text-gray-500 mt-1 italic">{{Str::limit($item['variant_list_string'], 50)}}
                        </p>
                        @endif
                        <p
                            class="text-xs font-semibold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full inline-block mt-2">
                            Qty: {{ $item['quantity'] }}</p>
                    </div>
                    <p class="font-bold text-gray-900 whitespace-nowrap pt-1">Rp {{ number_format($item['price'] *
                        $item['quantity'], 0, ',', '.') }}</p>
                </li>
                @endforeach
            </ul>

            <div class="border-t-2 border-dashed border-gray-100 pt-6 flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 font-medium">Subtotal</span>
                    <span class="text-gray-900 font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <!-- You can add tax/shipping rows here later if needed -->

                <div class="flex justify-between items-end mt-4 pt-4 border-t border-gray-100">
                    <span class="text-lg font-bold text-gray-800">Total</span>
                    <span
                        class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-purple-600">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="mt-8 bg-pink-50/50 rounded-2xl p-4 border border-pink-100/50">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-pink-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Payment will be confirmed via WhatsApp after placing the order. Please ensure your phone number
                        is active.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>