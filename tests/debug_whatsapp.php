<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

try {
    $order = App\Models\Order::first();
    if (!$order) {
        echo "No orders found.\n";
        exit;
    }

    echo "Order ID: " . $order->id . "\n";
    echo "WhatsApp URL: " . $order->getWhatsAppUrl() . "\n";
    echo "Success!\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
