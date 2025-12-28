<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-pink-600 mb-2">Aunty Donut</h1>
        <p class="text-gray-600 text-lg">Freshly baked happiness, one bite at a time.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($products as $product)
        <div
            class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
            <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                <!-- Placeholder for Product Image -->
                @if($product->is_bundle)
                <span class="text-4xl">🍩📦</span>
                @else
                <span class="text-4xl">🍩</span>
                @endif
            </div>

            <div class="p-6">
                <div class="flex justify-between items-start mb-2">
                    <h2 class="text-xl font-bold text-gray-800">{{ $product->name }}</h2>
                    @if($product->is_bundle)
                    <span
                        class="bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full font-bold uppercase tracking-wide">
                        Bundle
                    </span>
                    @endif
                </div>

                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>

                <div class="flex items-center justify-between mt-auto">
                    <span class="text-2xl font-bold text-pink-600">Rp {{ number_format($product->price, 0, ',', '.')
                        }}</span>

                    <a href="{{ route('product.detail', $product->slug) }}"
                        class="inline-block bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        {{ $product->is_bundle ? 'Customize Box' : 'View Details' }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>