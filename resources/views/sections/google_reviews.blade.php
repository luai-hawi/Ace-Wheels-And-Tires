@php
    $sectionStyle = $section->styleAttribute();
    $googleReviewsUrl = \App\Models\Setting::get('google_reviews_url');
    $heading = $section->textStyle('heading');
    $subheading = $section->textStyle('subheading');
@endphp
@if ($googleReviewsUrl)
    <section data-reveal="{{ $section->animation !== 'none' ? $section->animation : '' }}"
        class="{{ $section->backgroundClasses() }} {{ $section->sizeClasses('py-10 md:py-16') }} px-4 md:px-6 text-center"
        @if ($sectionStyle) style="{{ $sectionStyle }}" @endif>
        <x-section-media-background :section="$section" />
        <x-custom-code :model="$section" position="before" />

        <div class="relative z-10 max-w-content mx-auto">
            @if ($section->heading)
                <h2 class="text-2xl md:text-3xl font-bold uppercase mb-4 {{ $heading['class'] }}"
                    style="{{ $heading['style'] }}">{{ $section->heading }}</h2>
            @endif
            @if ($section->subheading)
                <p class="text-brand-dark/60 mb-6 {{ $subheading['class'] }}" style="{{ $subheading['style'] }}">
                    {{ $section->subheading }}</p>
            @endif
            <a href="{{ $googleReviewsUrl }}" target="_blank" rel="noopener">
                <img src="https://irp.cdn-website.com/d229567a/dms3rep/multi/opt/click-to-leave-review-small2-wt-1920w.png"
                    class="gmbBadges badge_5 mx-auto" alt="Google My Business Badge. Click to review" loading="lazy"
                    onerror="handleImageLoadError(this)">
            </a>
        </div>

        <x-custom-code :model="$section" position="after" />
    </section>
@endif
