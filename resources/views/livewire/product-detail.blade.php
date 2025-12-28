<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image Placeholder -->
        <div class="bg-gray-100 h-64 md:h-96 rounded-lg flex items-center justify-center text-gray-400">
            [Product Image]
        </div>

        <!-- Product Details -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $product->name }}</h1>
            <p class="text-xl text-pink-600 font-semibold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            
            <p class="text-gray-600 mt-4">{{ $product->description }}</p>

            @if($product->is_bundle)
                <div class="mt-8 p-4 bg-pink-50 rounded-lg border border-pink-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-800">Choose Your Flavors</h3>
                        <span class="text-sm font-medium px-3 py-1 rounded-full {{ $this->isFull ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $this->selectedCount }} / {{ $product->bundle_size }} Selected
                        </span>
                    </div>

                    <!-- Variants Grid -->
                    <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                        @foreach($product->variants as $variant)
                            <div class="flex justify-between items-center bg-white p-3 rounded shadow-sm">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $variant->name }}</p>
                                    @if($variant->stock <= 0)
                                        <p class="text-xs text-red-500">Out of Stock</p>
                                    @endif
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <button 
                                        wire:click="decrement({{ $variant->id }})"
                                        class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 flex items-center justify-center disabled:opacity-50"
                                        @disabled(($selectedVariants[$variant->id] ?? 0) === 0)
                                    >
                                        -
                                    </button>
                                    
                                    <span class="font-bold w-6 text-center">{{ $selectedVariants[$variant->id] ?? 0 }}</span>
                                    
                                    <button 
                                        wire:click="increment({{ $variant->id }})"
                                        class="w-8 h-8 rounded-full bg-pink-500 text-white hover:bg-pink-600 flex items-center justify-center disabled:opacity-50 disabled:bg-gray-300"
                                        @disabled($this->isFull || $variant->stock <= 0)
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-8">
                <button 
                    wire:click="addToCart"
                    class="w-full py-3 px-6 rounded-lg text-lg font-bold text-white transition-colors duration-200
                        {{ $this->isFull ? 'bg-pink-600 hover:bg-pink-700 shadow-lg' : 'bg-gray-300 cursor-not-allowed' }}"
                    @disabled(! $this->isFull)
                >
                    {{ $product->is_bundle && !$this->isFull ? 'Complete Selection to Add' : 'Add to Cart' }}
                </button>

                @if (session()->has('success'))
                    <div class="mt-3 text-center text-green-600 font-medium animate-pulse">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
