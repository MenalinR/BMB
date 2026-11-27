<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogSeeder::class);
        Storage::fake('public');
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_guests_are_sent_to_login(): void
    {
        $this->get('/admin/products')->assertRedirect('/login');
    }

    public function test_non_admin_users_are_blocked(): void
    {
        $this->actingAs(User::factory()->create())->get('/admin/products')->assertForbidden();
    }

    public function test_admin_logs_in_and_lands_on_admin(): void
    {
        $user = User::factory()->create(['email' => 'owner@example.com', 'password' => 'secret-pass', 'is_admin' => true]);

        $this->post('/login', ['email' => 'owner@example.com', 'password' => 'secret-pass'])
            ->assertRedirect(route('admin.products.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_pages_load(): void
    {
        $guitar = Product::where('name', 'Guitar')->first();
        $category = Category::where('slug', 'dresses')->first();

        $this->actingAs($this->admin);
        $this->get('/admin/products')->assertOk()->assertSee('Guitar');
        $this->get('/admin/products?category=' . $guitar->category_id . '&q=gui')->assertOk()->assertSee('Guitar')->assertDontSee('Projector');
        $this->get('/admin/products/create')->assertOk();
        $this->get("/admin/products/{$guitar->id}/edit")->assertOk();
        $this->get('/admin/categories')->assertOk()->assertSee('Used Products');
        $this->get('/admin/categories/create?type=rent')->assertOk();
        $this->get("/admin/categories/{$category->slug}/edit")->assertOk();
    }

    public function test_admin_adds_item_with_photo_and_price(): void
    {
        $dresses = Category::where('slug', 'dresses')->first();

        $this->actingAs($this->admin)->post('/admin/products', [
            'category_id' => $dresses->id,
            'name' => 'Cotton Saree',
            'description' => 'Blue, hand-woven',
            'price' => '4500',
            'price_unit' => 'each',
            'is_available' => '1',
            'photo' => UploadedFile::fake()->image('saree.jpg', 800, 600),
        ])->assertRedirect();

        $product = Product::where('name', 'Cotton Saree')->firstOrFail();
        $this->assertSame('4500.00', $product->price);
        $this->assertTrue($product->is_available);
        Storage::disk('public')->assertExists($product->image);

        $this->get('/shop/dresses')
            ->assertSee('Cotton Saree')
            ->assertSee('Rs. 4,500 each')
            ->assertSee('storage/' . $product->image);
    }

    public function test_admin_edits_rental_price_unit_and_replaces_photo(): void
    {
        $guitar = Product::where('name', 'Guitar')->first();
        $old = UploadedFile::fake()->image('old.jpg')->store('products', 'public');
        $guitar->update(['image' => $old]);

        $this->actingAs($this->admin)->put("/admin/products/{$guitar->id}", [
            'category_id' => $guitar->category_id,
            'name' => 'Guitar',
            'price' => '1500',
            'price_unit' => 'per day',
            'is_available' => '0',
            'photo' => UploadedFile::fake()->image('new.png'),
        ])->assertRedirect();

        $guitar->refresh();
        Storage::disk('public')->assertMissing($old);
        Storage::disk('public')->assertExists($guitar->image);
        $this->assertFalse($guitar->is_available);

        $this->get('/rentals/musical-equipment')->assertSee('Rs. 1,500 per day')->assertSee('Booked');
    }

    public function test_admin_removes_photo(): void
    {
        $guitar = Product::where('name', 'Guitar')->first();
        $path = UploadedFile::fake()->image('g.jpg')->store('products', 'public');
        $guitar->update(['image' => $path]);

        $this->actingAs($this->admin)->put("/admin/products/{$guitar->id}", [
            'category_id' => $guitar->category_id,
            'name' => 'Guitar',
            'is_available' => '1',
            'remove_photo' => '1',
        ]);

        $this->assertNull($guitar->fresh()->image);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_validation_rejects_bad_input(): void
    {
        $this->actingAs($this->admin)->post('/admin/products', [
            'category_id' => 999,
            'name' => '',
            'price' => '-5',
            'photo' => UploadedFile::fake()->create('notes.pdf', 10, 'application/pdf'),
        ])->assertSessionHasErrors(['category_id', 'name', 'price', 'photo']);
    }

    public function test_admin_toggles_availability_and_deletes_item(): void
    {
        $mic = Product::where('name', 'Microphone')->first();
        $path = UploadedFile::fake()->image('m.jpg')->store('products', 'public');
        $mic->update(['image' => $path]);

        $this->actingAs($this->admin)->patch("/admin/products/{$mic->id}/availability")->assertRedirect();
        $this->assertFalse($mic->fresh()->is_available);

        $this->delete("/admin/products/{$mic->id}")->assertRedirect();
        $this->assertModelMissing($mic);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_admin_manages_categories(): void
    {
        $this->actingAs($this->admin)->post('/admin/categories', [
            'name' => 'Sound Systems',
            'type' => 'rent',
            'icon' => 'fa-music',
        ])->assertRedirect(route('admin.categories.index'));

        $category = Category::where('slug', 'sound-systems')->firstOrFail();
        $this->get('/rentals/sound-systems')->assertOk();

        // Duplicate web address is rejected
        $this->post('/admin/categories', ['name' => 'Sound Systems', 'type' => 'rent'])
            ->assertSessionHasErrors('slug');

        $this->put("/admin/categories/{$category->slug}", [
            'name' => 'Sound Systems', 'slug' => 'sound-systems', 'type' => 'sale', 'icon' => 'fa-music',
        ])->assertRedirect();
        $this->get('/shop/sound-systems')->assertOk();

        Product::create(['category_id' => $category->id, 'name' => 'Speaker']);
        $this->delete("/admin/categories/{$category->slug}")->assertRedirect();
        $this->assertModelMissing($category);
        $this->assertDatabaseMissing('products', ['name' => 'Speaker']);
    }

    public function test_make_admin_command_creates_admin(): void
    {
        $this->artisan('app:make-admin')
            ->expectsQuestion('Email address (used to log in)', 'boss@example.com')
            ->expectsQuestion('Name', 'Shop Owner')
            ->expectsQuestion('Password (at least 8 characters)', 'long-enough-pw')
            ->assertSuccessful();

        $this->assertTrue(User::where('email', 'boss@example.com')->first()->is_admin);
    }
}
