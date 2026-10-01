@php
    $sectionStyle = $section->styleAttribute();
    $heading = $section->textStyle('heading');
@endphp
<section data-reveal="{{ $section->animation !== 'none' ? $section->animation : '' }}"
    class="{{ $section->backgroundClasses() }} {{ $section->sizeClasses('py-14') }} px-4 md:px-6"
    @if ($sectionStyle) style="{{ $sectionStyle }}" @endif>
    <x-section-media-background :section="$section" />
    <x-custom-code :model="$section" position="before" />

    <div class="relative z-10 max-w-content mx-auto text-center">
        @if ($section->heading)
            <h2 class="section-title mb-2 {{ $heading['class'] }}" style="{{ $heading['style'] }}">{{ $section->heading }}
            </h2>
        @endif
        @if ($section->subheading)
            <p class="text-brand-dark/60 mb-10">{{ $section->subheading }}</p>
        @endif

        <div class="flex flex-wrap items-center justify-center gap-10 md:gap-16">
            @foreach ($section->activeItems as $item)
                <a href="{{ $item->link_url ?? ($item->button_url ?? '#') }}"
                    target="{{ $item->link_url ?? $item->button_url ? '_blank' : '_self' }}" rel="noopener"
                    class="grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all duration-300 w-32 md:w-40"
                    data-reveal="fade-in" data-reveal-delay="{{ $loop->index * 80 }}">
                    <x-site-image :src="$item->image_path" :label="$item->placeholder_key ?? $item->heading" :alt="$item->heading ?? ''"
                        class="w-full h-auto object-contain" />
                </a>
            @endforeach
        </div>
    </div>

    <x-custom-code :model="$section" position="after" />
</section>
