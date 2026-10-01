@php
    $sectionStyle = $section->styleAttribute();
    $heading = $section->textStyle('heading');
    $subheading = $section->textStyle('subheading');
@endphp
<section data-reveal="{{ $section->animation !== 'none' ? $section->animation : '' }}"
    class="{{ $section->backgroundClasses() }} {{ $section->sizeClasses('py-16 md:py-24') }} px-4 md:px-6"
    @if ($sectionStyle) style="{{ $sectionStyle }}" @endif>
    <x-section-media-background :section="$section" />
    <x-custom-code :model="$section" position="before" />

    <div class="relative z-10 max-w-content mx-auto">
        @if ($section->heading || $section->subheading)
            <div class="text-center max-w-2xl mx-auto mb-12">
                @if ($section->subheading)
                    <p class="section-eyebrow {{ $subheading['class'] }}" style="{{ $subheading['style'] }}">
                        {{ $section->subheading }}</p>
                @endif
                @if ($section->heading)
                    <h2 class="section-title {{ $heading['class'] }}" style="{{ $heading['style'] }}">
                        {{ $section->heading }}</h2>
                @endif
            </div>
        @endif

        <div class="columns-1 sm:columns-2 lg:columns-3 gap-4 space-y-4">
            @foreach ($section->activeItems as $item)
                <a href="{{ $item->button_url ?? ($item->link_url ?? '#') }}"
                    class="relative block rounded-xl overflow-hidden shadow-md break-inside-avoid group"
                    data-reveal="zoom-in" data-reveal-delay="{{ $loop->index * 70 }}">
                    <x-site-image :src="$item->image_path" :label="$item->placeholder_key ?? $item->heading" :alt="$item->heading ?? ''"
                        class="w-full h-auto transition-transform duration-500 group-hover:scale-105" />
                    @if ($item->heading)
                        <span
                            class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent text-white p-4 font-heading font-semibold uppercase">
                            {{ $item->heading }}
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    <x-custom-code :model="$section" position="after" />
</section>
