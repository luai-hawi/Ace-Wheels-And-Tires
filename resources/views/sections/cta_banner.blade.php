@php
    $sectionStyle = $section->styleAttribute();
    $heading = $section->textStyle('heading');
    $subheading = $section->textStyle('subheading');
    $body = $section->textStyle('body');
@endphp
<section data-reveal="{{ $section->animation !== 'none' ? $section->animation : '' }}"
    class="{{ $section->backgroundClasses() }} {{ $section->sizeClasses('py-16 md:py-20') }} px-4 md:px-6 text-center"
    @if ($sectionStyle) style="{{ $sectionStyle }}" @endif>
    <x-section-media-background :section="$section" />
    <x-custom-code :model="$section" position="before" />

    <div class="relative z-10 max-w-3xl mx-auto">
        @if ($section->subheading)
            <p class="section-eyebrow {{ $section->isLightText() ? 'text-white/90' : '' }} {{ $subheading['class'] }}"
                style="{{ $subheading['style'] }}">{{ $section->subheading }}
            </p>
        @endif
        @if ($section->heading)
            <h2 class="text-3xl md:text-4xl font-bold uppercase mb-4 {{ $heading['class'] }}"
                style="{{ $heading['style'] }}">{{ $section->heading }}</h2>
        @endif
        @if ($section->body)
            <div class="prose max-w-none mx-auto mb-8 {{ $section->isLightText() ? 'prose-invert text-white/90' : 'text-brand-dark/80' }} {{ $body['class'] }}"
                style="{{ $body['style'] }}">
                {!! $section->body !!}
            </div>
        @endif
        @if ($section->button_text && $section->button_url)
            <a href="{{ $section->button_url }}"
                class="{{ $section->isLightText() ? 'btn-outline' : 'btn-primary' }}">
                {{ $section->button_text }}
            </a>
        @endif
    </div>

    <x-custom-code :model="$section" position="after" />
</section>
