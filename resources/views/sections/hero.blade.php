@php
    $sectionStyle = $section->styleAttribute();
    $heading = $section->textStyle('heading');
    $subheading = $section->textStyle('subheading');
    $body = $section->textStyle('body');
@endphp
<section data-reveal="{{ $section->animation !== 'none' ? $section->animation : '' }}"
    class="{{ $section->backgroundClasses() }} {{ $section->sizeClasses('py-24 md:py-32 min-h-[520px]') }} px-4 md:px-6 flex items-center"
    @if ($sectionStyle) style="{{ $sectionStyle }}" @endif>
    <x-section-media-background :section="$section" />
    <x-custom-code :model="$section" position="before" />

    <div class="relative z-10 max-w-content mx-auto w-full text-center">
        @if ($section->subheading)
            <p class="section-eyebrow {{ $section->isLightText() ? 'text-white/90' : '' }} {{ $subheading['class'] }}"
                style="{{ $subheading['style'] }}">{{ $section->subheading }}
            </p>
        @endif

        @if ($section->heading)
            <h1 class="text-4xl md:text-6xl font-bold uppercase leading-tight mb-6 {{ $heading['class'] }}"
                style="{{ $heading['style'] }}">{{ $section->heading }}</h1>
        @endif

        @if ($section->body)
            <div class="prose prose-invert max-w-2xl mx-auto text-lg md:text-xl mb-8 {{ $section->isLightText() ? 'text-white/90' : 'text-brand-dark/80' }} {{ $body['class'] }}"
                style="{{ $body['style'] }}">
                {!! $section->body !!}
            </div>
        @endif

        @if ($section->button_text && $section->button_url)
            <a href="{{ $section->button_url }}" class="btn-primary text-lg">
                {{ $section->button_text }}
            </a>
        @endif
    </div>

    <x-custom-code :model="$section" position="after" />
</section>
