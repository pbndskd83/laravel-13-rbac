<footer class="mt-auto py-3 px-4 bg-white border-top text-muted small">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">

       {{-- Left Side: Copyright --}}
<div class="mb-2 mb-md-0">
    <span class="fw-bold text-dark">
        {{-- Use {!! !!} ONLY if you want to allow HTML from your settings file --}}
        {!! site_settings('footer_text', '© ' . date('Y') . ' ' . config('app.name')) !!}
    </span>
    
    <span class="mx-1 text-muted opacity-50">|</span>
    
    <span class="opacity-75">
        {{ site_settings('site_tagline', 'Secure Architecture') }} 
        <span class="ms-1 text-muted opacity-50" style="font-size: 0.85em;">v2.0</span>
    </span>
</div>

        {{-- Right Side: Links & Policy --}}
        <div class="d-flex align-items-center gap-3">
            <a href="#" class="text-decoration-none text-muted hover-text-primary transition-base">Privacy
                Policy</a>
            <a href="#" class="text-decoration-none text-muted hover-text-primary transition-base">Terms of
                Service</a>

            @auth
                <a href="#" class="text-decoration-none text-muted hover-text-primary transition-base">Support</a>
            @endauth

            {{-- Social Icons if links exist --}}
            @if (site_settings('social_fb'))
                <a href="{{ site_settings('social_fb') }}" target="_blank" class="text-muted hover-text-primary">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
            @endif
        </div>
    </div>
</footer>
