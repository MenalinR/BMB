@extends('layouts.site')

@section('title', $category->name)

@section('content')
    @php
        $rental = $category->isRental();
        $parentName = $rental ? 'Rentals' : 'Shop';
        $parentUrl = $rental ? route('rentals') : route('shop');
    @endphp

    <div class="page">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a> /
            <a href="{{ $parentUrl }}">{{ $parentName }}</a> /
            {{ $category->name }}
        </div>

        <div class="page-header">
            <div class="eyebrow">{{ $rental ? 'For hire' : 'For sale' }}</div>
            <h1>{{ $category->name }}</h1>
            <p>{{ $category->description }}</p>
        </div>

        <div class="category-tabs">
            @foreach ($siblings as $sibling)
                <a href="{{ $sibling->url() }}" @class(['active' => $sibling->is($category)])>{{ $sibling->name }}</a>
            @endforeach
        </div>

        @if ($products->isEmpty())
            <div class="panel empty-state">
                <i class="fas {{ $category->icon ?? 'fa-box' }}"></i>
                <h2>Items coming soon</h2>
                <p>We are adding our {{ Str::lower($category->name) }} to the website. Message us to ask what is in stock right now.</p>
                <a class="btn btn-whatsapp" target="_blank" rel="noopener"
                   href="https://wa.me/{{ config('business.whatsapp') }}?text={{ rawurlencode("Hi BMB, what {$category->name} do you have available?") }}">
                    <i class="fab fa-whatsapp"></i> Ask on WhatsApp
                </a>
            </div>
        @else
            <div class="product-grid">
                @foreach ($products as $product)
                    @php
                        $message = $rental
                            ? "Hi BMB, I would like to rent: {$product->name}. Is it available?"
                            : "Hi BMB, I am interested in: {$product->name}.";
                    @endphp
                    <div class="product-card">
                        <div class="product-image">
                            @if ($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <i class="fas {{ $category->icon ?? 'fa-box' }}"></i>
                            @endif
                        </div>
                        <div class="product-body">
                            <h3>{{ $product->name }}</h3>
                            @if ($product->description)
                                <p>{{ $product->description }}</p>
                            @endif
                            <div class="product-meta">
                                @if ($product->formattedPrice())
                                    <span class="price">{{ $product->formattedPrice() }}</span>
                                @else
                                    <span class="price ask">Ask for price</span>
                                @endif
                                @if ($rental || ! $product->is_available)
                                    <span @class(['badge', 'unavailable' => ! $product->is_available])>
                                        {{ $product->is_available ? 'Available' : ($rental ? 'Booked' : 'Sold out') }}
                                    </span>
                                @endif
                            </div>
                            <a class="btn btn-whatsapp" target="_blank" rel="noopener"
                               href="https://wa.me/{{ config('business.whatsapp') }}?text={{ rawurlencode($message) }}">
                                <i class="fab fa-whatsapp"></i> {{ $rental ? 'Book on WhatsApp' : 'Order on WhatsApp' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @include('catalog._cta', [
            'heading' => 'Have a question?',
            'message' => "Hi BMB, I have a question about {$category->name}.",
        ])
    </div>
@endsection
