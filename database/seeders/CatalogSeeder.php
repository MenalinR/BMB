<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Creates the shop and rental categories, plus the rental items the business offers.
 * Safe to run more than once: existing rows are updated, not duplicated.
 */
class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $sale = [
            ['Equipment', 'equipment', 'fa-screwdriver-wrench', 'Tools and equipment for home, work and business.'],
            ['Dresses', 'dresses', 'fa-shirt', 'Clothing and dresses for every occasion.'],
            ['Nuts', 'nuts', 'fa-seedling', 'Fresh, healthy nuts.'],
            ['Food Items', 'food-items', 'fa-utensils', 'Everyday food items and groceries.'],
            ['Toys', 'toys', 'fa-puzzle-piece', 'Toys and games for children.'],
            ['Stationery', 'stationery', 'fa-pen', 'Books, pens and school and office supplies.'],
            ['Used Products', 'used-products', 'fa-recycle', 'Good-quality pre-owned items at lower prices.'],
        ];

        foreach ($sale as $i => [$name, $slug, $icon, $description]) {
            Category::updateOrCreate(['slug' => $slug], [
                'name' => $name,
                'type' => Category::TYPE_SALE,
                'icon' => $icon,
                'description' => $description,
                'sort_order' => $i,
            ]);
        }

        $rent = [
            [
                'Car Rental', 'car-rental', 'fa-car',
                'Hire a car for trips, functions and everyday travel.',
                [
                    ['Cars', 'Call or WhatsApp us to check which cars are available and the rates.'],
                ],
            ],
            [
                'Musical Equipment', 'musical-equipment', 'fa-guitar',
                'Instruments and sound equipment for events, practice and performances.',
                [
                    ['Guitar', 'Guitar available for hire.'],
                    ['Organ', 'Keyboard organ available for hire.'],
                    ['Microphone', 'Microphones for speeches, singing and events.'],
                ],
            ],
            [
                'Event & Office Equipment', 'event-equipment', 'fa-chair',
                'Projectors, desks and chairs for meetings, classes and functions.',
                [
                    ['Multimedia Projector', 'Projector for presentations, classes and film nights.'],
                    ['Desks', 'Desks for events, exams and temporary offices.'],
                    ['Chairs', 'Chairs for functions, meetings and gatherings.'],
                ],
            ],
        ];

        foreach ($rent as $i => [$name, $slug, $icon, $description, $items]) {
            $category = Category::updateOrCreate(['slug' => $slug], [
                'name' => $name,
                'type' => Category::TYPE_RENT,
                'icon' => $icon,
                'description' => $description,
                'sort_order' => $i,
            ]);

            foreach ($items as $j => [$itemName, $itemDescription]) {
                Product::updateOrCreate(
                    ['category_id' => $category->id, 'name' => $itemName],
                    ['description' => $itemDescription, 'sort_order' => $j],
                );
            }
        }
    }
}
