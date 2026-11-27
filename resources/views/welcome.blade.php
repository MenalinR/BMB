@extends('layouts.site')

@push('styles')
    <style>
        /* Hero */
        .main-container {
            min-height: min(calc(100vh - 130px), 620px);
            display: flex;
            align-items: center;
            padding: 20px 90px 20px 60px;
            position: relative;
            gap: 100px;
        }

        .left-section {
            flex: 0 0 600px;
            z-index: 2;
            text-align: left;
            padding-right: 10px;
            align-self: center;
        }

        .left-section .highlight {
            font-size: 64px;
            color: #2c3e50;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 25px;
            letter-spacing: -2px;
        }

        .left-section p {
            font-size: 15px;
            color: #555;
            margin-top: 20px;
            line-height: 1.8;
            max-width: 600px;
            font-weight: 400;
            letter-spacing: 0.3px;
            margin-bottom: 30px;
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .shop-btn {
            display: inline-block;
            padding: 12px 35px;
            background: #2c3e50;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: lowercase;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .shop-btn:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .shop-btn.secondary {
            background: transparent;
            color: #2c3e50;
            box-shadow: inset 0 0 0 2px #2c3e50;
        }

        .shop-btn.secondary:hover {
            background: #2c3e50;
            color: white;
        }

        .center-section {
            flex: 1;
            min-width: 0;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .image-circle {
            width: 100%;
            max-width: 1100px;
            aspect-ratio: 11 / 6.5;
            border-radius: 16px;
            background: white;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            filter: brightness(0.65);
        }

        .image-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(212, 149, 107, 0.05), rgba(0, 0, 0, 0.05));
            pointer-events: none;
        }

        /* Offer sections */
        .offer {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 60px 20px;
        }

        .offer + .offer {
            padding-bottom: 70px;
        }

        .offer-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 26px;
        }

        .offer-head .section-intro {
            margin-bottom: 0;
        }

        @media (max-width: 1024px) {
            .main-container {
                padding: 40px;
                flex-direction: column;
                gap: 40px;
                min-height: 0;
            }

            .left-section {
                flex: none;
                padding-right: 0;
            }

            .left-section .highlight {
                font-size: 50px;
            }

            .center-section {
                width: 100%;
            }

            .offer {
                padding: 50px 40px 10px;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 28px 16px;
            }

            .left-section .highlight {
                font-size: 36px;
            }

            .offer {
                padding: 40px 16px 10px;
            }

            .offer + .offer {
                padding-bottom: 50px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero -->
    <div class="main-container">
        <div class="left-section">
            <div class="highlight">Built for Your Lifestyle</div>
            <p>We are a multi-business platform designed to make your life easier. From equipment, dresses, nuts, food items, toys and stationery to quality used products, plus cars, musical instruments and event equipment for hire, we bring everything together in one convenient place. Our focus is on quality, reliability, and customer satisfaction.</p>
            <div class="hero-actions">
                <a href="{{ route('shop') }}" class="shop-btn">shop now</a>
                <a href="{{ route('rentals') }}" class="shop-btn secondary">rent now</a>
            </div>
        </div>

        <div class="center-section">
            <div class="image-circle">
                <img src="{{ asset('images/banner.png') }}" alt="BMB Products - Instruments, Clothes, Nuts & Services">
                <div class="image-overlay"></div>
            </div>
        </div>
    </div>

    <!-- What we sell -->
    <section class="offer">
        <div class="offer-head">
            <div>
                <div class="eyebrow">For sale</div>
                <h2 class="section-title">Shop with us</h2>
                <p class="section-intro">Everyday products and good-quality used items.</p>
            </div>
            <a href="{{ route('shop') }}" class="btn btn-outline">View shop</a>
        </div>
        <div class="category-grid">
            @foreach ($saleCategories as $category)
                <a href="{{ $category->url() }}" class="category-card">
                    <div class="category-icon"><i class="fas {{ $category->icon ?? 'fa-box' }}"></i></div>
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->description }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- What we rent -->
    <section class="offer">
        <div class="offer-head">
            <div>
                <div class="eyebrow">For hire</div>
                <h2 class="section-title">Rent from us</h2>
                <p class="section-intro">Cars, musical equipment and event equipment, by the day or for your event.</p>
            </div>
            <a href="{{ route('rentals') }}" class="btn btn-outline">View rentals</a>
        </div>
        <div class="category-grid">
            @foreach ($rentCategories as $category)
                <a href="{{ $category->url() }}" class="category-card">
                    <div class="category-icon"><i class="fas {{ $category->icon ?? 'fa-box' }}"></i></div>
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->description }}</p>
                </a>
            @endforeach
        </div>
    </section>
@endsection
