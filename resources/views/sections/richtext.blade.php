@php
    $sectionStyle = $section->styleAttribute();
    $image = $section->activeItems->first();
    $hasImage = $image && in_array($section->layout, ['image-left', 'image-right'], true);
    $imageOnRight = $section->layout === 'image-right';
    $videoUrl = $section->dataValue('video_url');
    $heading = $section->textStyle('heading');
    $subheading = $section->textStyle('subheading');
    $body = $section->textStyle('body');
@endphp
<section data-reveal="{{ $section->animation !== 'none' ? $section->animation : '' }}"
    class="{{ $section->backgroundClasses() }} {{ $section->sizeClasses('py-16 md:py-24') }} px-4 md:px-6"
    @if ($sectionStyle) style="{{ $sectionStyle }}" @endif>
    <x-section-media-background :section="$section" />
    <x-custom-code :model="$section" position="before" />

    <div class="relative z-10 max-w-content mx-auto">
        <div
            class="grid {{ $hasImage || $videoUrl ? 'md:grid-cols-2' : 'grid-cols-1 text-center' }} gap-10 md:gap-16 items-center">
            @if (($hasImage || $videoUrl) && !$imageOnRight)
                <div class="rounded-2xl overflow-hidden shadow-xl aspect-[4/3]" data-reveal="zoom-in">
                    @if ($videoUrl)
                        <video src="{{ $videoUrl }}" controls loop muted class="w-full h-full object-cover"></video>
                    @else
                        <x-site-image :src="$image->image_path" :label="$image->placeholder_key ?? $image->heading" :alt="$image->heading ?? ''" />
                    @endif
                </div>
            @endif

            <div class="{{ $hasImage || $videoUrl ? '' : 'max-w-3xl mx-auto' }}">
                @if ($section->subheading)
                    <p class="section-eyebrow {{ $subheading['class'] }}" style="{{ $subheading['style'] }}">
                        {{ $section->subheading }}</p>
                @endif
                @if ($section->heading)
                    <h2 class="section-title mb-6 {{ $heading['class'] }}" style="{{ $heading['style'] }}">
                        {{ $section->heading }}</h2>
                @endif
                @if ($section->body)
                    <div class="prose max-w-none {{ $section->isLightText() ? 'prose-invert text-white/90' : 'text-brand-dark/80' }} {{ $body['class'] }}"
                        style="{{ $body['style'] }}">
                        {!! $section->body !!}
                    </div>
                @endif
                @if ($section->button_text && $section->button_url)
                    <a href="{{ $section->button_url }}" class="btn-primary mt-6">{{ $section->button_text }}</a>
                @endif
            </div>

            @if (($hasImage || $videoUrl) && $imageOnRight)
                <div class="rounded-2xl overflow-hidden shadow-xl aspect-[4/3]" data-reveal="zoom-in">
                    @if ($videoUrl)
                        <video src="{{ $videoUrl }}" controls loop muted
                            class="w-full h-full object-cover"></video>
                    @else
                        <x-site-image :src="$image->image_path" :label="$image->placeholder_key ?? $image->heading" :alt="$image->heading ?? ''" />
                    @endif
                </div>
            @endif
        </div>

        @if (!$hasImage && !$videoUrl && $section->activeItems->count() > 1)
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 mt-12">
                @foreach ($section->activeItems as $extraImage)
                    <div class="rounded-2xl overflow-hidden shadow-xl aspect-[4/3]" data-reveal="zoom-in"
                        data-reveal-delay="{{ $loop->index * 100 }}">
                        <x-site-image :src="$extraImage->image_path" :label="$extraImage->placeholder_key ?? $extraImage->heading" :alt="$extraImage->heading ?? ''" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <x-custom-code :model="$section" position="after" />
</section>
