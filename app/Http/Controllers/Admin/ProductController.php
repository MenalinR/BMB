<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('type')->orderBy('sort_order')->orderBy('name')->get();

        $products = Product::with('category')
            ->when($request->filled('category'), fn ($q) => $q->where('products.category_id', $request->integer('category')))
            ->when($request->filled('q'), fn ($q) => $q->where('products.name', 'like', '%' . $request->string('q') . '%'))
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->orderBy('categories.type')
            ->orderBy('categories.sort_order')
            ->orderBy('products.sort_order')
            ->orderBy('products.name')
            ->select('products.*')
            ->paginate(25)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(Request $request)
    {
        $product = new Product([
            'is_available' => true,
            'category_id' => $request->integer('category') ?: null,
        ]);

        return view('admin.products.form', [
            'product' => $product,
            'categories' => $this->categoriesByType(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image'] = $request->hasFile('photo')
            ? $request->file('photo')->store(Product::IMAGE_DIR, 'public')
            : null;

        $product = Product::create($data);

        return redirect()
            ->route('admin.products.index', ['category' => $product->category_id])
            ->with('status', "Added \"{$product->name}\".");
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => $this->categoriesByType(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $product->deleteImageFile();
            $data['image'] = $request->file('photo')->store(Product::IMAGE_DIR, 'public');
        } elseif ($request->boolean('remove_photo')) {
            $product->deleteImageFile();
            $data['image'] = null;
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index', ['category' => $product->category_id])
            ->with('status', "Saved \"{$product->name}\".");
    }

    public function toggleAvailability(Product $product)
    {
        $product->update(['is_available' => ! $product->is_available]);

        $state = $product->is_available ? 'available' : ($product->category->isRental() ? 'booked' : 'sold out');

        return back()->with('status', "\"{$product->name}\" is now marked {$state}.");
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('status', "Deleted \"{$product->name}\".");
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'price_unit' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ], [
            'photo.uploaded' => 'The photo is too large to upload. Please choose a smaller photo.',
            'photo.max' => 'The photo must be smaller than 5 MB.',
        ]);

        $data['is_available'] = $request->boolean('is_available');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        unset($data['photo']);

        return $data;
    }

    private function categoriesByType()
    {
        return Category::orderBy('sort_order')->orderBy('name')->get()->groupBy('type');
    }
}
