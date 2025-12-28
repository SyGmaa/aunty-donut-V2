<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Aunty Donut' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script> <!-- Quick Dev CDN for speed -->
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900" x-data="{ cartOpen: false }"
    x-on:keydown.escape.window="cartOpen = false" x-on:cart-updated.window="cartOpen = true">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 h-16 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-pink-600 flex items-center gap-2">
                🍩 Aunty Donut
            </a>

            <div class="flex items-center gap-4">
                <a href="/admin" class="text-sm text-gray-500 hover:text-pink-600">Admin Login</a>

                <!-- Cart Indicator -->
                <button @click="cartOpen = true" class="relative p-2 text-gray-600 hover:text-pink-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    @if(session('cart'))
                    <span
                        class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-pink-600 rounded-full">
                        {{ count(session('cart')) }}
                    </span>
                    @endif
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-8">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Aunty Donut. All rights reserved.
        </div>
    </footer>
    <!-- Cart Drawer -->
    <div x-show="cartOpen" class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true"
        style="display: none;">
        <!-- Background backdrop -->
        <div x-show="cartOpen" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <!-- Slide-over panel -->
                    <div x-show="cartOpen"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                        class="pointer-events-auto w-screen max-w-md">

                        <livewire:cart />

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>