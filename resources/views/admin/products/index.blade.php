@extends('layouts.admin')

@section('title', 'Items')

@section('content')
    <div class="admin-head">
        <div>
            <h1>Items</h1>
            <p>Everything shown in the Shop and Rentals pages. Click an item to change its photo, price or details.</p>
        </div>
        <a href="{{ route('admin.products.create', ['category' => request('category')]) }}" class="btn btn-accent">
            <i class="fas fa-plus"></i> Add item
        </a>
    </div>

    <form method="GET" class="filters">
        <select name="category" onchange="this.form.submit()" aria-label="Filter by category">
            <option value="">All categories</option>
            @foreach ($categories->groupBy('type') as $type => $group)
                <optgroup label="{{ \App\Models\Category::TYPES[$type] ?? $type }}">
                    @foreach ($group as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search by name" aria-label="Search by name">
        <button class="btn btn-sm" type="submit"><i class="fas fa-magnifying-glass"></i> Search</button>
        @if (request()->hasAny(['category', 'q']) && (request('category') || request('q')))
            <a href="{{ route('admin.products.index') }}" class="btn-link" style="align-self:center">Clear</a>
        @endif
    </form>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Category</th>
                    <th class="num">Price</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    @php $rental = $product->category->isRental(); @endphp
                    <tr>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}" class="item-cell" style="text-decoration:none">
                                <span class="thumb">
                                    @if ($product->image)
                                        <img src="{{ $product->imageUrl() }}" alt="">
                                    @else
                                        <i class="fas {{ $product->category->icon ?? 'fa-box' }}"></i>
                                    @endif
                                </span>
                                <span>
                                    <strong>{{ $product->name }}</strong>
                                    @unless ($product->image)
                                        <small><i class="fas fa-camera"></i> No photo yet</small>
                                    @endunless
                                </span>
                            </a>
                        </td>
                        <td data-label="Category">
                            {{ $product->category->name }}
                            <div class="muted" style="font-size:12px">{{ $rental ? 'Rental' : 'Shop' }}</div>
                        </td>
                        <td class="num" data-label="Price">
                            @if ($product->formattedPrice())
                                {{ $product->formattedPrice() }}
                            @else
                                <span class="muted">Ask for price</span>
                            @endif
                        </td>
                        <td data-label="Status">
                            <form method="POST" action="{{ route('admin.products.availability', $product) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="pill-btn" title="Click to change">
                                    <span @class(['badge', 'unavailable' => ! $product->is_available])>
                                        {{ $product->is_available ? 'Available' : ($rental ? 'Booked' : 'Sold out') }}
                                        <i class="fas fa-rotate"></i>
                                    </span>
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm"><i class="fas fa-pen"></i> Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                      onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-row">
                            No items found.
                            <a href="{{ route('admin.products.create', ['category' => request('category')]) }}">Add the first one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($products->hasPages())
        <div class="pagination-wrap filters">
            @if ($products->onFirstPage())
                <span class="btn btn-sm btn-outline" style="opacity:.4">&larr; Previous</span>
            @else
                <a class="btn btn-sm btn-outline" href="{{ $products->previousPageUrl() }}">&larr; Previous</a>
            @endif
            <span class="muted" style="align-self:center">Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</span>
            @if ($products->hasMorePages())
                <a class="btn btn-sm btn-outline" href="{{ $products->nextPageUrl() }}">Next &rarr;</a>
            @else
                <span class="btn btn-sm btn-outline" style="opacity:.4">Next &rarr;</span>
            @endif
        </div>
    @endif
@endsection
