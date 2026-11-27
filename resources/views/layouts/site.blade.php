<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@hasSection('title')@yield('title') - {{ config('business.short_name') }}@else{{ config('business.name') }}@endif</title>
    <link rel="icon" href="{{ asset('images/bmb.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    @stack('styles')
</head>
<body>
    @php
        $whatsapp = 'https://wa.me/' . config('business.whatsapp');
    @endphp

    <header>
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/bmb.png') }}" alt="BMB Logo">
            <div class="logo-text">
                <span class="store">Blessing</span>
                <span class="store">Multi Business</span>
            </div>
        </a>

        <nav>
            <a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')])>Home</a>
            <a href="{{ route('shop') }}" @class(['active' => request()->routeIs('shop*')])>Shop</a>
            <a href="{{ route('rentals') }}" @class(['active' => request()->routeIs('rentals*')])>Rentals</a>
            <a href="{{ route('about') }}" @class(['active' => request()->routeIs('about')])>About</a>
            <a href="{{ route('contact') }}" @class(['active' => request()->routeIs('contact')])>Contact</a>
        </nav>

        <a href="tel:{{ config('business.phone_link') }}" class="call-section">
            <span class="call-label">Call Now</span>
            <span class="call-number">{{ config('business.phone') }}</span>
        </a>

        {{-- Customers don't log in; the owner's login link is in the footer. --}}
        @auth
            @if (auth()->user()->is_admin)
                <a href="{{ route('admin.products.index') }}" class="login-btn">Admin</a>
            @else
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="login-btn" style="border:0;cursor:pointer;">Logout</button>
                </form>
            @endif
        @endauth
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-section">
            <div class="footer-logo">
                <img src="{{ asset('images/bmb.png') }}" alt="BMB Logo">
                <span>{{ config('business.short_name') }}</span>
            </div>
            <p>Welcome to BMB! We sell equipment, dresses, nuts, food items, toys, stationery and used products, and we rent out cars, musical equipment and event equipment. Stay connected via social media for the latest news and offers. Thanks for choosing us!</p>
        </div>

        <div class="footer-section">
            <h3>Shop &amp; Rent</h3>
            <div class="footer-links">
                <a href="{{ route('shop') }}">Shop</a>
                <a href="{{ route('rentals') }}">Rentals</a>
            </div>
        </div>

        <div class="footer-section">
            <h3>Information</h3>
            <div class="footer-links">
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('contact') }}">Contact</a>
                @guest
                    <a href="{{ route('login') }}" class="owner-login"><i class="fas fa-lock"></i> Owner login</a>
                @endguest
            </div>
        </div>

        <div class="footer-section">
            <h3>Contact &amp; Follow</h3>
            <div class="footer-contact">
                <div class="contact-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ config('business.address') }}</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-phone"></i>
                    <a href="tel:{{ config('business.phone_link') }}">{{ config('business.phone') }}</a>
                </div>
                <div class="social-icons">
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="{{ $whatsapp }}" title="WhatsApp" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
