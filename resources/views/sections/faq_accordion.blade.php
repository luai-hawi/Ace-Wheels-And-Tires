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

    <div class="relative z-10 max-w-3xl mx-auto">
        @if ($section->heading || $section->subheading)
            <div class="text-center mb-12">
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

        <div x-data="{ open: 0 }" class="space-y-3">
            @foreach ($section->activeItems as $item)
                @php $itemHeading = $item->textStyle('heading'); @endphp
                <div class="card overflow-hidden" data-reveal="fade-up" data-reveal-delay="{{ $loop->index * 60 }}">
                    <x-custom-code :model="$item" position="before" />

                    <button @click="open === {{ $loop->index }} ? open = null : open = {{ $loop->index }}"
                        class="w-full flex items-center justify-between gap-4 p-5 text-left font-heading font-semibold uppercase {{ $itemHeading['class'] }}"
                        style="{{ $itemHeading['style'] }}">
                        {{ $item->heading }}
                        <svg class="w-5 h-5 shrink-0 transition-transform"
                            :class="open === {{ $loop->index }} ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === {{ $loop->index }}" x-transition class="px-5 pb-5 text-brand-dark/70">
                        {{ $item->body }}
                    </div>

                    <x-custom-code :model="$item" position="after" />
                </div>
            @endforeach
        </div>
    </div>

    <x-custom-code :model="$section" position="after" />
</section>
