<div class="bg-gray-50 min-h-screen font-sans">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-pink-500 to-rose-400 overflow-hidden rounded-b-[3rem] shadow-xl mb-12">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
        </div>
        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-yellow-300 opacity-20 rounded-full blur-2xl"></div>

        <div class="container mx-auto px-4 py-16 text-center relative z-10">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4 tracking-tight drop-shadow-sm">
                Aunty <span class="text-yellow-300">Donut</span>
            </h1>
            <p class="text-pink-100 text-xl md:text-2xl font-light max-w-2xl mx-auto">
                Freshly baked happiness, one bite at a time. 🍩
            </p>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="container mx-auto px-4 pb-20">
        <!-- Changed grid to flex with justify-center to center the cards -->
        <div class="flex flex-wrap justify-center gap-8">
            @foreach($products as $product)
            <!-- Added specific widths (w-full sm:w-80) to maintain card shape in flex layout -->
            <div
                class="w-full sm:w-80 group bg-white rounded-3xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-pink-50 flex flex-col h-full relative overflow-hidden">

                <!-- Badge for Bundle -->
                @if($product->is_bundle)
                <div class="absolute top-4 left-4 z-20">
                    <span
                        class="bg-gradient-to-r from-violet-500 to-purple-600 text-white text-xs px-3 py-1.5 rounded-full font-bold uppercase tracking-wider shadow-md flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                        Bundle Pack
                    </span>
                </div>
                @endif

                <!-- Image Area -->
                <div
                    class="relative h-64 overflow-hidden bg-gradient-to-br from-orange-50 to-pink-50 flex items-center justify-center group-hover:from-orange-100 group-hover:to-pink-100 transition-colors duration-300">
                    <!-- Decorative Background Circle -->
                    <div
                        class="absolute w-48 h-48 bg-white rounded-full opacity-40 group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <!-- Icon / Image Placeholder -->
                    <div class="z-10 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                        @if($product->is_bundle)
                        <div class="text-7xl filter drop-shadow-md">🎁</div>
                        @else
                        <div class="text-7xl filter drop-shadow-md">🍩</div>
                        @endif
                    </div>

                    <!-- Overlay Action (Optional) -->
                    <div
                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-5 transition-all duration-300">
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-6 flex flex-col flex-grow relative">
                    <!-- Decorative element connecting image and text -->
                    <div class="absolute -top-6 right-6 bg-white p-2 rounded-full shadow-sm">
                        <button class="text-gray-300 hover:text-pink-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>

                    <div class="mb-4">
                        <h2
                            class="text-xl font-bold text-gray-800 leading-tight mb-2 group-hover:text-pink-600 transition-colors">
                            {{ $product->name }}
                        </h2>
                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">
                            {{ $product->description }}
                        </p>
                    </div>

                    <!-- Price and Action Bottom -->
                    <div class="mt-auto pt-4 border-t border-dashed border-gray-100 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 font-semibold uppercase tracking-wide">Price</span>
                            <span class="text-2xl font-black text-pink-600">
                                <span class="text-sm font-bold align-top">Rp</span>{{ number_format($product->price, 0,
                                ',', '.') }}
                            </span>
                        </div>

                        <a href="{{ route('product.detail', $product->slug) }}"
                            class="relative overflow-hidden bg-gray-900 hover:bg-pink-600 text-white font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-pink-500/30 group-btn">
                            <span class="relative z-10 flex items-center gap-2">
                                {{ $product->is_bundle ? 'Customize' : 'Add' }}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>