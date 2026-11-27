<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CatalogController extends Controller
{
    public function shop()
    {
        return view('catalog.index', [
            'type' => Category::TYPE_SALE,
            'title' => 'Shop',
            'intro' => 'Everything we sell, in one place. Browse a category, then call or WhatsApp us to order.',
            'categories' => Category::ofType(Category::TYPE_SALE)->withCount('products')->get(),
        ]);
    }

    public function rentals()
    {
        return view('catalog.index', [
            'type' => Category::TYPE_RENT,
            'title' => 'Rentals',
            'intro' => 'Need it for a day, an event or a trip? Hire cars, musical equipment and event equipment from us.',
            'categories' => Category::ofType(Category::TYPE_RENT)->withCount('products')->get(),
        ]);
    }

    public function shopCategory(Category $category)
    {
        abort_unless($category->type === Category::TYPE_SALE, 404);

        return $this->category($category);
    }

    public function rentalCategory(Category $category)
    {
        abort_unless($category->type === Category::TYPE_RENT, 404);

        return $this->category($category);
    }

    private function category(Category $category)
    {
        return view('catalog.category', [
            'category' => $category,
            'products' => $category->products,
            'siblings' => Category::ofType($category->type)->get(),
        ]);
    }
}
