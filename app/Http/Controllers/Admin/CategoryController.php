<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('type')->orderBy('sort_order')->orderBy('name')
            ->get()
            ->groupBy('type');

        return view('admin.categories.index', compact('categories'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type') === Category::TYPE_RENT ? Category::TYPE_RENT : Category::TYPE_SALE;

        return view('admin.categories.form', [
            'category' => new Category(['type' => $type, 'icon' => 'fa-box']),
        ]);
    }

    public function store(Request $request)
    {
        $category = Category::create($this->validated($request));

        return redirect()->route('admin.categories.index')
            ->with('status', "Added the \"{$category->name}\" category.");
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validated($request, $category));

        return redirect()->route('admin.categories.index')
            ->with('status', "Saved the \"{$category->name}\" category.");
    }

    public function destroy(Category $category)
    {
        // Delete products one by one so their photo files are removed too.
        $category->products()->get()->each->delete();
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('status', "Deleted the \"{$category->name}\" category and its items.");
    }

    private function validated(Request $request, ?Category $category = null): array
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('name'))]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', Rule::unique('categories', 'slug')->ignore($category)],
            'type' => ['required', Rule::in(array_keys(Category::TYPES))],
            'description' => ['nullable', 'string', 'max:500'],
            'icon' => ['nullable', Rule::in(array_keys(Category::ICONS))],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ], [
            'slug.unique' => 'Another category already uses this web address. Please change the name or the web address.',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
