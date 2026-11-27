{{-- Call / WhatsApp panel. Expects $heading and $message (pre-filled WhatsApp text). --}}
<div class="panel cta-panel">
    <div>
        <h2>{{ $heading }}</h2>
        <p>Call or WhatsApp us and we will check stock, availability and prices for you.</p>
    </div>
    <div class="actions">
        <a class="btn btn-whatsapp" target="_blank" rel="noopener"
           href="https://wa.me/{{ config('business.whatsapp') }}?text={{ rawurlencode($message) }}">
            <i class="fab fa-whatsapp"></i> WhatsApp us
        </a>
        <a class="btn btn-outline" href="tel:{{ config('business.phone_link') }}">
            <i class="fas fa-phone"></i> {{ config('business.phone') }}
        </a>
    </div>
</div>
