@php
    $sectionStyle = $section->styleAttribute();
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
                @if ($section->body)
                    <div class="prose mx-auto mt-4 {{ $section->isLightText() ? 'prose-invert text-white/90' : 'text-brand-dark/70' }} {{ $body['class'] }}"
                        style="{{ $body['style'] }}">
                        {!! $section->body !!}</div>
                @endif
            </div>
        @endif

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach ($section->activeItems as $item)
                @php
                    $itemHeading = $item->textStyle('heading');
                    $itemBody = $item->textStyle('body');
                    $hasImage = $item->hasRealImage();
                    $heading = trim((string) $item->heading);
                    $needsColon = $heading !== '' && !in_array(substr($heading, -1), ['?', ':', '.', '!'], true);
                @endphp
                @if ($hasImage)
                    <div class="card overflow-hidden group" data-reveal="{{ $item->animation ?? 'fade-up' }}"
                        data-reveal-delay="{{ $loop->index * 90 }}">
                        <x-custom-code :model="$item" position="before" />

                        <div class="aspect-[4/3] overflow-hidden">
                            <x-site-image :src="$item->image_path" :label="$item->placeholder_key ?? $item->heading" :alt="$item->heading ?? ''"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                        </div>
                        <div class="p-6">
                            @if ($item->heading)
                                <h3 class="font-heading font-bold text-xl uppercase mb-2 {{ $itemHeading['class'] }}"
                                    style="{{ $itemHeading['style'] }}">{{ $item->heading }}</h3>
                            @endif
                            @if ($item->body)
                                <p class="text-brand-dark/70 text-sm mb-4 {{ $itemBody['class'] }}"
                                    style="{{ $itemBody['style'] }}">{{ $item->body }}</p>
                            @endif
                            @if ($item->button_text && ($item->button_url || $item->link_url))
                                <a href="{{ $item->button_url ?? $item->link_url }}"
                                    class="inline-flex items-center gap-1 font-semibold text-brand-red hover:gap-2 transition-all">
                                    {{ $item->button_text }}
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                        </div>

                        <x-custom-code :model="$item" position="after" />
                    </div>
                @else
                    {{-- No photo for this card: a "trust badge" style instead of an empty gray box. --}}
                    <div class="relative pt-7" data-reveal="{{ $item->animation ?? 'fade-up' }}"
                        data-reveal-delay="{{ $loop->index * 90 }}">
                        <span
                            class="absolute top-0 left-1/2 -translate-x-1/2 z-10 inline-flex items-center justify-center w-12 h-12 rounded-full bg-brand-red text-white ring-4 ring-white shadow-lg">
                            @svg($item->icon ?: 'heroicon-s-information-circle', 'w-6 h-6')
                        </span>
                        <div
                            class="card overflow-visible h-full shadow-xl shadow-brand-red/20 ring-1 ring-brand-red/10 px-6 pb-6 pt-8 text-center text-brand-dark">
                            <x-custom-code :model="$item" position="before" />

                            @if ($heading || $item->body)
                                <p class="font-bold {{ $itemBody['class'] ?: 'text-base' }}"
                                    style="{{ $itemBody['style'] ?: $itemHeading['style'] }}">
                                    @if ($heading)
                                        <span class="{{ $itemHeading['class'] }}"
                                            style="{{ $itemHeading['style'] }}">{{ $heading }}{{ $needsColon ? ':' : '' }}</span>
                                    @endif
                                    {{ $item->body }}
                                </p>
                            @endif
                            @if ($item->button_text && ($item->button_url || $item->link_url))
                                <a href="{{ $item->button_url ?? $item->link_url }}"
                                    class="inline-flex items-center gap-1 font-semibold text-brand-red hover:gap-2 transition-all mt-4">
                                    {{ $item->button_text }}
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif

                            <x-custom-code :model="$item" position="after" />
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <x-custom-code :model="$section" position="after" />
</section>
