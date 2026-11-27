@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="admin-head">
        <div>
            <h1>Categories</h1>
            <p>The groups shown on the Shop and Rentals pages.</p>
        </div>
    </div>

    @foreach (\App\Models\Category::TYPES as $type => $label)
        <div class="card">
            <div class="card-head">
                <h2>{{ $label }}</h2>
                <a href="{{ route('admin.categories.create', ['type' => $type]) }}" class="btn btn-sm btn-accent">
                    <i class="fas fa-plus"></i> Add category
                </a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Web address</th>
                        <th class="num">Items</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories->get($type, collect()) as $category)
                        <tr>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="item-cell" style="text-decoration:none">
                                    <span class="thumb"><i class="fas {{ $category->icon ?? 'fa-box' }}"></i></span>
                                    <span>
                                        <strong>{{ $category->name }}</strong>
                                        <small>{{ Str::limit($category->description, 70) }}</small>
                                    </span>
                                </a>
                            </td>
                            <td data-label="Web address">
                                <a href="{{ $category->url() }}" target="_blank" class="muted">/{{ $category->isRental() ? 'rentals' : 'shop' }}/{{ $category->slug }}</a>
                            </td>
                            <td class="num" data-label="Items">
                                <a href="{{ route('admin.products.index', ['category' => $category->id]) }}">{{ $category->products_count }}</a>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.products.create', ['category' => $category->id]) }}" class="btn btn-sm btn-outline">
                                        <i class="fas fa-plus"></i> Item
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm"><i class="fas fa-pen"></i> Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="empty-row">No categories yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach
@endsection
