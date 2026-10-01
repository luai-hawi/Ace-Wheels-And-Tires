@php
    $sectionStyle = $section->styleAttribute();
    $mapEmbedUrl = $section->dataValue('map_embed_url');
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

        <div class="grid lg:grid-cols-2 gap-10 items-start">
            <div class="rounded-2xl overflow-hidden shadow-xl aspect-video" data-reveal="zoom-in">
                @if ($mapEmbedUrl)
                    <iframe src="{{ $mapEmbedUrl }}" class="w-full h-full border-0" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                @else
                    <x-site-image label="Service area map" />
                @endif
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                @foreach ($section->activeItems as $item)
                    @php $itemHeading = $item->textStyle('heading'); @endphp
                    <a href="{{ $item->button_url ?? '#' }}" class="card p-5 flex items-center gap-3"
                        data-reveal="fade-up" data-reveal-delay="{{ $loop->index * 80 }}">
                        <x-custom-code :model="$item" position="before" />

                        @svg($item->icon ?: 'heroicon-o-map-pin', 'w-6 h-6 text-brand-red shrink-0')

                        <div>
                            <p class="font-heading font-bold uppercase {{ $itemHeading['class'] }}"
                                style="{{ $itemHeading['style'] }}">{{ $item->heading }}</p>
                            @if ($item->body)
                                <p class="text-sm text-brand-dark/60">{{ $item->body }}</p>
                            @endif
                        </div>

                        <x-custom-code :model="$item" position="after" />
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <x-custom-code :model="$section" position="after" />
</section>
