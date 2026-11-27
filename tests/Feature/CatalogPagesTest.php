<?php

namespace Tests\Feature;

use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogSeeder::class);
    }

    public function test_home_lists_shop_and_rental_categories(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Stationery')
            ->assertSee('Car Rental');
    }

    public function test_shop_and_rentals_pages_list_their_categories(): void
    {
        $this->get('/shop')->assertOk()->assertSee('Used Products')->assertDontSee('Musical Equipment');
        $this->get('/rentals')->assertOk()->assertSee('Musical Equipment')->assertDontSee('Stationery');
    }

    public function test_rental_category_shows_its_items(): void
    {
        $this->get('/rentals/musical-equipment')
            ->assertOk()
            ->assertSee('Guitar')
            ->assertSee('Organ')
            ->assertSee('Microphone')
            ->assertSee('wa.me/', false);
    }

    public function test_empty_shop_category_shows_coming_soon(): void
    {
        $this->get('/shop/dresses')->assertOk()->assertSee('Items coming soon');
    }

    public function test_category_under_the_wrong_section_is_not_found(): void
    {
        $this->get('/shop/car-rental')->assertNotFound();
        $this->get('/rentals/dresses')->assertNotFound();
        $this->get('/shop/does-not-exist')->assertNotFound();
    }

    public function test_about_and_contact_pages_load(): void
    {
        $this->get('/about')->assertOk();
        $this->get('/contact')->assertOk()->assertSee('Savatkaddu, Mannar');
    }
}
