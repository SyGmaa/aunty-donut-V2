<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md" x-data="{
        selections: {},
        limit: {{ $product->is_bundle ? $product->bundle_size : 0 }},
        isBundle: {{ $product->is_bundle ? 'true' : 'false' }},
        
        get totalSelected() {
            return Object.values(this.selections).reduce((a, b) => a + b, 0);
        },

        get isFull() {
            if (!this.isBundle) return true;
            return this.totalSelected === this.limit; 
        },

        increment(id) {
            // Bundle Limit Check
            if (this.isBundle && this.isFull) return;
            
            // Single Item: No limit, just increment
            if (!this.selections[id]) this.selections[id] = 0;
            this.selections[id]++;
        },

        decrement(id) {
            if (this.selections[id] > 0) {
                this.selections[id]--;
            }
        },

        submit() {
            if (this.isBundle && !this.isFull) return;
            if (!this.isBundle && this.totalSelected === 0) {
                alert('Please select at least one item.');
                return;
            }
            $wire.addToCart(this.selections);
        }
    }" x-init="
        @foreach($product->variants as $variant)
            selections[{{ $variant->id }}] = 0;
        @endforeach
    ">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
        <!-- Product Image -->
        <div class="bg-gray-100 rounded-2xl overflow-hidden shadow-lg border border-gray-100 relative group">
            @if($product->image)
            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                class="w-full h-auto object-cover transform group-hover:scale-105 transition-transform duration-500">
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>
            @else
            <div class="h-96 w-full flex items-center justify-center text-gray-400 bg-gray-50 flex-col gap-2">
                <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <span class="text-sm font-medium">No Image Available</span>
            </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="sticky top-8">
            <h1 class="text-3xl font-bold text-gray-800">{{ $product->name }}</h1>
            <p class="text-xl text-pink-600 font-semibold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

            <p class="text-gray-600 mt-4">{{ $product->description }}</p>

            <!-- Unified Variant Selection Grid -->
            @if($product->variants->isNotEmpty())
            <div class="mt-8 p-4 bg-pink-50 rounded-lg border border-pink-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800">
                        {{ $product->is_bundle ? 'Choose Your Flavors' : 'Select Quantity per Flavor' }}
                    </h3>

                    @if($product->is_bundle)
                    <span class="text-sm font-medium px-3 py-1 rounded-full"
                        :class="isFull ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'">
                        <span x-text="totalSelected"></span> / <span x-text="limit"></span> Selected
                    </span>
                    @else
                    <span class="text-sm font-medium px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                        <span x-text="totalSelected"></span> Items Selected
                    </span>
                    @endif
                </div>

                <!-- Variants Grid -->
                <div class="space-y-3 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($product->variants as $variant)
                    <div wire:key="variant-{{ $variant->id }}"
                        class="flex justify-between items-center bg-white p-3 rounded shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div>
                            <p class="font-medium text-gray-800">{{ $variant->name }}</p>
                            @if($variant->stock <= 0) <p class="text-xs text-red-500">Out of Stock</p>
                                @endif
                        </div>

                        <div class="flex items-center space-x-3">
                            <button type="button" @click="decrement({{ $variant->id }})"
                                class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 flex items-center justify-center disabled:opacity-50 transition-colors"
                                :disabled="selections[{{ $variant->id }}] <= 0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                    </path>
                                </svg>
                            </button>

                            <span class="font-bold w-8 text-center text-lg"
                                x-text="selections[{{ $variant->id }}]">0</span>

                            <button type="button" @click="increment({{ $variant->id }})"
                                class="w-8 h-8 rounded-full bg-pink-500 text-white hover:bg-pink-600 flex items-center justify-center disabled:opacity-50 disabled:bg-gray-300 transition-colors"
                                :disabled="(isBundle && isFull) || {{ $variant->stock }} <= 0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="mt-8">
                <button @click="submit"
                    class="w-full py-4 px-6 rounded-xl text-lg font-bold text-white transition-all duration-200 transform active:scale-95 flex justify-center items-center gap-2"
                    :class="(isBundle && isFull) || (!isBundle && totalSelected > 0)
                        ? 'bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 shadow-lg shadow-pink-500/30' 
                        : 'bg-gray-300 cursor-not-allowed'"
                    :disabled="!((isBundle && isFull) || (!isBundle && totalSelected > 0))">

                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span
                        x-text="isBundle ? (isFull ? 'Add Bundle to Order' : 'Select ' + (limit - totalSelected) + ' more') : ('Add ' + totalSelected + ' Items to Order')"></span>
                </button>

                @if (session()->has('success'))
                <div
                    class="mt-4 p-3 bg-green-50 text-center text-green-700 rounded-lg border border-green-200 animate-fade-in-up flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>