@extends('layouts.site')

@section('title', 'Contact')

@section('content')
    <div class="page">
        <div class="breadcrumb"><a href="{{ route('home') }}">Home</a> / Contact</div>

        <div class="page-header">
            <div class="eyebrow">Get in touch</div>
            <h1>Contact us</h1>
            <p>To order an item, book a rental or ask a question, call us or send a WhatsApp message. We will reply as soon as we can.</p>
        </div>

        <div class="info-grid">
            <div class="panel">
                <a class="contact-line" href="tel:{{ config('business.phone_link') }}">
                    <i class="fas fa-phone"></i>
                    <span><small>Call</small><strong>{{ config('business.phone') }}</strong></span>
                </a>
                <a class="contact-line" target="_blank" rel="noopener"
                   href="https://wa.me/{{ config('business.whatsapp') }}?text={{ rawurlencode('Hi BMB, I have a question.') }}">
                    <i class="fab fa-whatsapp"></i>
                    <span><small>WhatsApp</small><strong>{{ config('business.phone') }}</strong></span>
                </a>
                <div class="contact-line">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><small>Visit</small><strong>{{ config('business.address') }}</strong></span>
                </div>
            </div>
            <div class="panel">
                <h2>Renting something?</h2>
                <p>Please tell us what you need, the date and for how long. For car rental, also tell us where you are travelling. We will confirm availability and the price before you book.</p>
                <br>
                <a class="btn" href="{{ route('rentals') }}">See rentals</a>
            </div>
        </div>
    </div>
@endsection
