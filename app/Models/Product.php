<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'price_unit',
        'image', 'is_available', 'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function formattedPrice(): ?string
    {
        if ($this->price === null) {
            return null;
        }

        $amount = 'Rs. ' . number_format((float) $this->price, 0);

        return $this->price_unit ? "{$amount} {$this->price_unit}" : $amount;
    }
}
