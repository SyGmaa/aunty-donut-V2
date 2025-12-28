<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'stock',
        'extra_price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'stock' => 'integer',
        'extra_price' => 'decimal:2',
    ];

    /**
     * The products (bundles or items) that this flavor belongs to.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_variant')
            ->withTimestamps();
    }
}
