<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public const TYPE_SALE = 'sale';
    public const TYPE_RENT = 'rent';

    protected $fillable = ['name', 'slug', 'type', 'description', 'icon', 'sort_order'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('sort_order')->orderBy('name');
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type)->orderBy('sort_order')->orderBy('name');
    }

    public function isRental(): bool
    {
        return $this->type === self::TYPE_RENT;
    }

    public function url(): string
    {
        return $this->isRental()
            ? route('rentals.category', $this)
            : route('shop.category', $this);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
