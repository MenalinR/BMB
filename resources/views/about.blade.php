@extends('layouts.site')

@section('title', 'About Us')

@section('content')
    <div class="page">
        <div class="breadcrumb"><a href="{{ route('home') }}">Home</a> / About</div>

        <div class="page-header">
            <div class="eyebrow">About us</div>
            <h1>{{ config('business.name') }}</h1>
            <p>We are a multi-business based in {{ config('business.address') }}, built to make life easier for our community. Instead of going to several shops, you can buy what you need and rent what you need for a day from one trusted place.</p>
        </div>

        <div class="info-grid">
            <div class="panel">
                <h2>What we sell</h2>
                <ul>
                    <li><i class="fas fa-screwdriver-wrench"></i> Equipment</li>
                    <li><i class="fas fa-shirt"></i> Dresses</li>
                    <li><i class="fas fa-seedling"></i> Nuts</li>
                    <li><i class="fas fa-utensils"></i> Food items</li>
                    <li><i class="fas fa-puzzle-piece"></i> Toys</li>
                    <li><i class="fas fa-pen"></i> Stationery</li>
                    <li><i class="fas fa-recycle"></i> Used products</li>
                </ul>
            </div>
            <div class="panel">
                <h2>What we rent</h2>
                <ul>
                    <li><i class="fas fa-car"></i> Cars</li>
                    <li><i class="fas fa-guitar"></i> Guitars and organs</li>
                    <li><i class="fas fa-microphone"></i> Microphones</li>
                    <li><i class="fas fa-video"></i> Multimedia projectors</li>
                    <li><i class="fas fa-chair"></i> Desks and chairs</li>
                </ul>
            </div>
            <div class="panel">
                <h2>Our promise</h2>
                <p>Quality, reliability and customer satisfaction. Whether you are buying or renting, we will be honest about price and availability, and we are always one call or WhatsApp message away.</p>
            </div>
        </div>

        @include('catalog._cta', [
            'heading' => 'Talk to us',
            'message' => 'Hi BMB, I would like to know more about your business.',
        ])
    </div>
@endsection
