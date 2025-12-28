<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 font-sans">

    <!-- Back Button (Optional context) -->
    <div class="max-w-6xl mx-auto mb-6">
        <a href="{{ route('home') }}"
            class="inline-flex items-center text-gray-400 hover:text-pink-600 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Back to Menu
        </a>
    </div>

    <!-- Main Card Container -->
    <div class="max-w-6xl mx-auto bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-pink-100" x-data="{
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
                // Using a custom toast logic or simple alert
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

            <!-- Left Column: Image Section -->
            <div
                class="relative bg-gradient-to-br from-pink-50 to-orange-50 h-full min-h-[400px] lg:min-h-[600px] flex items-center justify-center p-8 lg:p-12 overflow-hidden">
                <!-- Decorative Elements -->
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-white opacity-20 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-48 h-48 bg-yellow-300 opacity-10 rounded-full blur-2xl transform -translate-x-1/2 translate-y-1/2">
                </div>

                <div class="relative z-10 w-full max-w-md transform transition-transform duration-700 hover:scale-105">
                    @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-auto object-cover rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 ring-4 ring-white/50">
                    @else
                    <!-- Enhanced Placeholder -->
                    <div
                        class="aspect-square w-full rounded-3xl bg-white/40 backdrop-blur-sm border-2 border-white/50 flex flex-col items-center justify-center text-pink-300 shadow-inner p-8">
                        <span class="text-9xl mb-4 drop-shadow-md">
                            {{ $product->is_bundle ? '🎁' : '🍩' }}
                        </span>
                        <span class="text-xl font-bold text-gray-400 uppercase tracking-widest">No Image</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Details & Interaction -->
            <div class="flex flex-col h-full bg-white relative">

                <!-- Scrollable Content Area -->
                <div class="flex-1 p-8 lg:p-12 overflow-y-auto">

                    <!-- Header -->
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                            <div>
                                @if($product->is_bundle)
                                <span
                                    class="inline-block bg-purple-100 text-purple-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider mb-3">
                                    Bundle Pack
                                </span>
                                @else
                                <span
                                    class="inline-block bg-pink-100 text-pink-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider mb-3">
                                    Single Item
                                </span>
                                @endif
                                <h1
                                    class="text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight mb-2">
                                    {{ $product->name }}
                                </h1>
                            </div>
                            <div class="text-right md:text-left">
                                <span class="block text-3xl font-black text-pink-600">
                                    <span class="text-lg text-gray-400 font-semibold align-top mr-1">Rp</span>{{
                                    number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <p class="text-gray-500 text-lg leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>

                    <!-- Variant Selection Area -->
                    @if($product->variants->isNotEmpty())
                    <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100 shadow-inner">
                        <div class="flex justify-between items-end mb-6 border-b border-gray-200 pb-4">
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">
                                    {{ $product->is_bundle ? 'Customize Box' : 'Quantity' }}
                                </h3>
                                <p class="text-sm text-gray-400 mt-1">
                                    {{ $product->is_bundle ? 'Mix and match your favorite flavors.' : 'Select how many
                                    you want.' }}
                                </p>
                            </div>

                            <!-- Dynamic Counter Badge -->
                            <div class="shrink-0 transition-all duration-300"
                                :class="isBundle && isFull ? 'scale-110' : ''">
                                @if($product->is_bundle)
                                <div class="flex flex-col items-end">
                                    <span
                                        class="text-xs font-bold uppercase tracking-wide text-gray-400 mb-1">Limit</span>
                                    <span
                                        class="text-sm font-bold px-4 py-1.5 rounded-full shadow-sm transition-colors duration-300"
                                        :class="isFull ? 'bg-green-500 text-white' : 'bg-white text-gray-700 border border-gray-200'">
                                        <span x-text="totalSelected"></span> / <span x-text="limit"></span>
                                    </span>
                                </div>
                                @else
                                <div
                                    class="text-sm font-medium px-4 py-1.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                    <span x-text="totalSelected"></span> Selected
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Variants List -->
                        <div class="space-y-3 max-h-[320px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($product->variants as $variant)
                            <div wire:key="variant-{{ $variant->id }}"
                                class="group flex justify-between items-center bg-white p-4 rounded-2xl border border-gray-100 hover:border-pink-200 shadow-sm hover:shadow-md transition-all duration-200">

                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800 group-hover:text-pink-600 transition-colors">{{
                                        $variant->name }}</span>
                                    @if($variant->stock <= 0) <span
                                        class="text-xs font-semibold text-red-500 bg-red-50 px-2 py-0.5 rounded-md w-fit mt-1">
                                        Out of Stock</span>
                                        @else
                                        <span class="text-xs text-gray-400 mt-1">{{ $variant->stock }} available</span>
                                        @endif
                                </div>

                                <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-1">
                                    <button type="button" @click="decrement({{ $variant->id }})"
                                        class="w-8 h-8 rounded-lg bg-white text-gray-600 shadow-sm hover:bg-gray-100 hover:text-pink-500 flex items-center justify-center disabled:opacity-30 disabled:hover:bg-white disabled:hover:text-gray-600 transition-all"
                                        :disabled="selections[{{ $variant->id }}] <= 0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"></path>
                                        </svg>
                                    </button>

                                    <span class="font-bold text-gray-800 w-6 text-center tabular-nums"
                                        x-text="selections[{{ $variant->id }}]">0</span>

                                    <button type="button" @click="increment({{ $variant->id }})"
                                        class="w-8 h-8 rounded-lg bg-white text-gray-600 shadow-sm hover:bg-pink-500 hover:text-white flex items-center justify-center disabled:opacity-30 disabled:hover:bg-white disabled:hover:text-gray-600 transition-all"
                                        :disabled="(isBundle && isFull) || {{ $variant->stock }} <= 0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                <!-- Footer Action Area -->
                <div class="p-8 lg:p-12 border-t border-gray-100 bg-white z-10">
                    <button @click="submit"
                        class="w-full py-5 px-8 rounded-2xl text-lg font-bold text-white transition-all duration-300 transform active:scale-[0.98] shadow-xl flex justify-center items-center gap-3"
                        :class="(isBundle && isFull) || (!isBundle && totalSelected > 0)
                            ? 'bg-gray-900 hover:bg-pink-600 shadow-pink-500/20 hover:shadow-pink-600/40'
                            : 'bg-gray-200 text-gray-400 cursor-not-allowed shadow-none'"
                        :disabled="!((isBundle && isFull) || (!isBundle && totalSelected > 0))">

                        <span class="relative flex h-3 w-3"
                            x-show="(isBundle && isFull) || (!isBundle && totalSelected > 0)">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                        </span>

                        <span
                            x-text="isBundle ? (isFull ? 'Add Bundle to Order' : 'Select ' + (limit - totalSelected) + ' more items') : ('Add ' + totalSelected + ' Items to Order')"></span>

                        <svg class="w-6 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </button>

                    @if (session()->has('success'))
                    <div
                        class="mt-4 p-4 bg-green-50 text-green-700 rounded-2xl border border-green-200 animate-fade-in-up flex items-center justify-center gap-2 font-medium shadow-sm">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>