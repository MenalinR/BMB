@extends('layouts.site')

@section('title', $title)

@section('content')
    <div class="page">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a> / {{ $title }}
        </div>

        <div class="page-header">
            <div class="eyebrow">{{ $type === 'rent' ? 'For hire' : 'For sale' }}</div>
            <h1>{{ $title }}</h1>
            <p>{{ $intro }}</p>
        </div>

        <div class="category-grid">
            @forelse ($categories as $category)
                <a href="{{ $category->url() }}" class="category-card">
                    <div class="category-icon"><i class="fas {{ $category->icon ?? 'fa-box' }}"></i></div>
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->description }}</p>
                    <span class="more">
                        @if ($category->products_count)
                            {{ $category->products_count }} {{ Str::plural('item', $category->products_count) }} &rarr;
                        @else
                            View &rarr;
                        @endif
                    </span>
                </a>
            @empty
                <p>No categories yet.</p>
            @endforelse
        </div>

        @include('catalog._cta', [
            'heading' => $type === 'rent' ? 'Want to book something?' : 'Looking for something specific?',
            'message' => $type === 'rent'
                ? 'Hi BMB, I would like to rent something. Is it available?'
                : 'Hi BMB, I am looking for something from your shop.',
        ])
    </div>
@endsection
