<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public const TYPE_SALE = 'sale';
    public const TYPE_RENT = 'rent';

    public const TYPES = [
        self::TYPE_SALE => 'Shop (for sale)',
        self::TYPE_RENT => 'Rentals (for hire)',
    ];

    /** Icons the admin can pick for a category (Font Awesome 6 solid). */
    public const ICONS = [
        'fa-box' => 'Box',
        'fa-screwdriver-wrench' => 'Tools',
        'fa-shirt' => 'Shirt',
        'fa-seedling' => 'Seedling',
        'fa-utensils' => 'Food',
        'fa-puzzle-piece' => 'Toy',
        'fa-pen' => 'Pen',
        'fa-book' => 'Book',
        'fa-recycle' => 'Recycle',
        'fa-car' => 'Car',
        'fa-van-shuttle' => 'Van',
        'fa-motorcycle' => 'Motorbike',
        'fa-guitar' => 'Guitar',
        'fa-music' => 'Music',
        'fa-microphone' => 'Microphone',
        'fa-video' => 'Projector',
        'fa-chair' => 'Chair',
        'fa-couch' => 'Furniture',
        'fa-laptop' => 'Laptop',
        'fa-mobile-screen' => 'Phone',
        'fa-tv' => 'TV',
        'fa-camera' => 'Camera',
        'fa-gift' => 'Gift',
        'fa-basket-shopping' => 'Basket',
        'fa-tag' => 'Tag',
    ];

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
