<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    /** Folder on the "public" disk where uploaded product photos are stored. */
    public const IMAGE_DIR = 'products';

    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'price_unit',
        'image', 'is_available', 'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    protected static function booted(): void
    {
        // Remove the photo file when a product is deleted.
        static::deleting(fn (Product $product) => $product->deleteImageFile());
    }

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

    /**
     * Public URL of the photo. Uploaded photos live on the "public" disk;
     * a path starting with "images/" points at a file shipped in public/.
     */
    public function imageUrl(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return str_starts_with($this->image, 'images/')
            ? asset($this->image)
            : asset('storage/' . $this->image);
    }

    public function deleteImageFile(): void
    {
        if ($this->image && str_starts_with($this->image, self::IMAGE_DIR . '/')) {
            Storage::disk('public')->delete($this->image);
        }
    }
}
