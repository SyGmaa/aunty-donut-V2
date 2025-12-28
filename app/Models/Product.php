<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'is_bundle',
        'bundle_size',
        'is_active',
    ];

    protected $casts = [
        'is_bundle' => 'boolean',
        'is_active' => 'boolean',
        'bundle_size' => 'integer',
        'price' => 'decimal:2',
    ];

    /**
     * The variants (flavors) available for this product.
     * For a 'Box of 6', this defines which flavors can be put in the box.
     */
    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(Variant::class, 'product_variant')
            ->withTimestamps();
    }
}
