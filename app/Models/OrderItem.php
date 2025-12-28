<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price_at_time',
        'total_price',
        'selected_variants',
    ];

    protected $casts = [
        'price_at_time' => 'decimal:2',
        'total_price' => 'decimal:2',
        'selected_variants' => 'array', // Automatically cast JSON to array
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Helper to retrieve Variant models from the stored selected_variants IDs/Data.
     * Assumes selected_variants is stored as an array of Variant IDs or Objects.
     * If stored as [1, 2, 1, 3] (variant IDs), this fetches them.
     */
    public function getResolvedVariantsAttribute()
    {
        if (empty($this->selected_variants) || !is_array($this->selected_variants)) {
            return collect();
        }

        // Check if we stored IDs (integers) or full objects.
        // Assuming we store IDs for simplicity and normalized data references,
        // but we might want to store names for history.
        // Strategy: Try to fetch fresh models from DB based on IDs.

        $ids = array_filter($this->selected_variants, 'is_numeric');

        if (empty($ids)) {
            // maybe stored as names? just return the array as is or wrap in collection
            return collect($this->selected_variants);
        }

        // Fetch all variants in one query
        $variants = Variant::whereIn('id', $ids)->get()->keyBy('id');

        // Map original ID list to preserve order and count (e.g., 2 chocolate donuts)
        return collect($this->selected_variants)->map(function ($id) use ($variants) {
            return $variants->get($id);
        })->filter(); // remove any nulls if variants were deleted
    }
}
