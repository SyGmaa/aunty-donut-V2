<div class="min-h-screen bg-[#f8f5f2] relative overflow-hidden font-sans selection:bg-pink-200 selection:text-pink-900">
    <!-- Background Decor (Animated Blobs) -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div
            class="absolute -top-24 -left-24 w-96 h-96 bg-pink-200/40 rounded-full blur-3xl mix-blend-multiply animate-pulse">
        </div>
        <div
            class="absolute top-1/2 -right-24 w-80 h-80 bg-purple-200/40 rounded-full blur-3xl mix-blend-multiply opacity-70">
        </div>
        <div
            class="absolute bottom-0 left-1/4 w-80 h-80 bg-yellow-200/40 rounded-full blur-3xl mix-blend-multiply opacity-70">
        </div>
    </div>

    <!-- Header -->
    <div class="relative z-10 max-w-7xl mx-auto pt-16 pb-10 text-center px-4">
        <span
            class="inline-block py-1 px-3 rounded-full bg-pink-100 text-pink-600 text-sm font-bold tracking-wide uppercase mb-3 shadow-sm border border-pink-200/50">
            Secure Checkout
        </span>
        <h1 class="text-4xl md:text-6xl font-black text-gray-900 tracking-tight mb-4 drop-shadow-sm">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-purple-600">Complete</span>
            Your Order
        </h1>
        <p class="text-gray-500 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
            Hampir selesai! Isi detail pengirimanmu untuk menikmati kelezatan donat kami. 🍩✨
        </p>
    </div>

    <!-- Grid Container -->
    <div
        class="relative z-10 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 px-4 sm:px-6 lg:px-8 pb-24 items-start">

        <!-- Left Column: Delivery Form -->
        <div class="lg:col-span-8 flex flex-col">
            <div
                class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl shadow-pink-900/5 border border-white/50 overflow-hidden relative group hover:shadow-pink-900/10 transition-all duration-500 h-full flex flex-col">

                <!-- Progress Line Gradient -->
                <div
                    class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-pink-400 via-purple-400 to-orange-300">
                </div>

                <div class="p-8 md:p-12 flex-1">
                    <div class="flex items-center gap-5 mb-10 pb-6 border-b border-gray-100">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-50 to-white border border-pink-100 text-pink-500 flex items-center justify-center shadow-lg shadow-pink-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Delivery Details</h2>
                            <p class="text-gray-400 text-sm mt-1">Where should we send your happiness?</p>
                        </div>
                    </div>

                    <form wire:submit.prevent="placeOrder" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Name -->
                            <div class="space-y-3">
                                <label class="text-sm font-bold text-gray-700 ml-1 flex items-center gap-2">
                                    Full Name <span class="text-pink-500">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-pink-500 transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input wire:model="name" type="text" placeholder="e.g. Aunty Donut"
                                        class="block w-full pl-12 pr-5 py-4 bg-gray-50/50 border-gray-200 focus:bg-white focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10 rounded-2xl text-gray-900 placeholder-gray-400 transition-all duration-300 font-medium shadow-sm hover:bg-white">
                                </div>
                                @error('name') <span
                                    class="text-red-500 text-xs font-bold ml-1 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </span> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="space-y-3">
                                <label class="text-sm font-bold text-gray-700 ml-1 flex items-center gap-2">
                                    WhatsApp <span class="text-pink-500">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-pink-500 transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <input wire:model="phone" type="text" placeholder="08..."
                                        class="block w-full pl-12 pr-5 py-4 bg-gray-50/50 border-gray-200 focus:bg-white focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10 rounded-2xl text-gray-900 placeholder-gray-400 transition-all duration-300 font-medium shadow-sm hover:bg-white">
                                </div>
                                @error('phone') <span class="text-red-500 text-xs font-bold ml-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="space-y-3">
                            <label class="text-sm font-bold text-gray-700 ml-1 flex items-center gap-2">
                                Full Address <span class="text-pink-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute top-5 left-5 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-pink-500 transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <textarea wire:model="address" rows="3"
                                    placeholder="Street name, house number, fence color..."
                                    class="block w-full pl-12 pr-5 py-4 bg-gray-50/50 border-gray-200 focus:bg-white focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10 rounded-2xl text-gray-900 placeholder-gray-400 transition-all duration-300 font-medium resize-none leading-relaxed shadow-sm hover:bg-white"></textarea>
                            </div>
                            @error('address') <span class="text-red-500 text-xs font-bold ml-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="space-y-3">
                            <label class="text-sm font-bold text-gray-700 ml-1 flex items-center gap-2">
                                Notes <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute top-5 left-5 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-pink-500 transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <textarea wire:model="notes" rows="2"
                                    placeholder="Birthday message, leave at front door, etc..."
                                    class="block w-full pl-12 pr-5 py-4 bg-gray-50/50 border-gray-200 focus:bg-white focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10 rounded-2xl text-gray-900 placeholder-gray-400 transition-all duration-300 font-medium resize-none leading-relaxed shadow-sm hover:bg-white"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Order Summary -->
        <div class="lg:col-span-4">
            <!-- Adjusted: Sticky top-8, compact height (no h-full), limited list height -->
            <div
                class="bg-white/90 backdrop-blur-md rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-white p-8 sticky top-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                        <span
                            class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center text-lg shadow-sm">
                            🛒
                        </span>
                        Your Order
                    </h2>
                    <span class="text-xs font-medium bg-gray-100 text-gray-500 px-3 py-1 rounded-full">
                        {{ count($items) }} Items
                    </span>
                </div>

                <!-- Scrollable Area with Fixed Max Height -->
                <div class="max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                    <ul class="divide-y divide-gray-100/50">
                        @foreach($items as $item)
                        <li class="py-4 flex items-start gap-4 group">
                            <div
                                class="flex-shrink-0 w-16 h-16 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-100 flex items-center justify-center text-3xl shadow-sm group-hover:scale-105 transition-transform duration-300">
                                {{-- Placeholder Icon logic --}}
                                {{ str_contains(strtolower($item['name']), 'box') ||
                                str_contains(strtolower($item['name']), 'bundle') ? '🎁' : '🍩' }}
                            </div>
                            <div class="flex-1 min-w-0 pt-1">
                                <div class="flex justify-between items-start gap-2">
                                    <p class="text-sm font-bold text-gray-900 leading-tight">{{ $item['name'] }}</p>
                                    <p class="text-sm font-bold text-gray-900 whitespace-nowrap">
                                        <span class="text-xs text-gray-400 font-normal mr-0.5">Rp</span>{{
                                        number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </p>
                                </div>

                                @if(!empty($item['variant_list_string']))
                                <div class="mt-1.5 p-2 bg-gray-50 rounded-lg border border-gray-100">
                                    <p class="text-xs text-gray-500 leading-relaxed">{{
                                        Str::limit($item['variant_list_string'], 60) }}</p>
                                </div>
                                @endif

                                <div class="flex items-center mt-2">
                                    <span class="text-xs font-bold text-pink-600 bg-pink-50 px-2 py-0.5 rounded-md">
                                        x{{ $item['quantity'] }}
                                    </span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Footer Section -->
                <div class="mt-6 border-t border-gray-100 pt-6 bg-white/50 backdrop-blur-sm rounded-xl">
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 mb-6">
                        <div class="flex justify-between text-sm font-medium text-gray-600 mb-2">
                            <p>Subtotal</p>
                            <p>Rp {{ number_format($total, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex justify-between items-center border-t border-gray-200/60 pt-3 mt-2">
                            <p class="text-lg font-bold text-gray-800">Total</p>
                            <div class="text-right">
                                <p
                                    class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-purple-600">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <button wire:click="placeOrder" wire:loading.attr="disabled"
                        class="w-full relative group overflow-hidden flex justify-center items-center py-4 px-4 rounded-2xl shadow-lg shadow-pink-500/30 text-lg font-bold text-white bg-gray-900 hover:bg-gray-800 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed transform hover:-translate-y-1">

                        <!-- Gradient Overlay on Hover -->
                        <div
                            class="absolute inset-0 w-full h-full bg-gradient-to-r from-pink-500 via-purple-500 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>

                        <span class="relative z-10 flex items-center gap-2" wire:loading.remove
                            wire:target="placeOrder">
                            Confirm Order
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>

                        <span wire:loading wire:target="placeOrder" class="relative z-10 flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Processing...
                        </span>
                    </button>

                    <div class="flex items-center justify-center gap-2 text-xs text-gray-400 mt-4">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        Secure checkout powered by WhatsApp
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
