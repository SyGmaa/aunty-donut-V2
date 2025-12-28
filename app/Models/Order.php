<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'address',
        'status',
        'total_price',
        'payment_method',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getWhatsAppMessage(): string
    {
        $message = "Halo Kak {$this->customer_name},\n";
        $message .= "Ini dari Aunty Donut mengenai pesanan #{$this->id}.\n\n";
        $message .= "Detail Pesanan:\n";

        foreach ($this->items as $item) {
            $message .= "- {$item->quantity}x {$item->product_name} (Rp " . number_format($item->total_price, 0, ',', '.') . ")\n";

            $variants = $item->resolved_variants;
            if ($variants->isNotEmpty()) {
                $variantNames = $variants->pluck('name')->join(', ');
                $message .= "   Varian: {$variantNames}\n";
            }
        }

        $message .= "\nTotal: Rp " . number_format($this->total_price, 0, ',', '.') . "\n";
        $message .= "Status Pembayaran: " . ucfirst($this->payment_status) . "\n";
        $message .= "Status Pesanan: " . ucfirst($this->status) . "\n\n";
        $message .= "Mohon konfirmasinya ya kak. Terima kasih!";

        return $message;
    }

    public function getWhatsAppUrl(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->customer_phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $text = urlencode($this->getWhatsAppMessage());

        return "https://wa.me/{$phone}?text={$text}";
    }
}
