@php
    $sectionStyle = $section->styleAttribute();
    $items = $section->activeItems->values();
    $heading = $section->textStyle('heading');
    $subheading = $section->textStyle('subheading');
@endphp
<section data-reveal="{{ $section->animation !== 'none' ? $section->animation : '' }}"
    class="{{ $section->backgroundClasses() }} {{ $section->sizeClasses('py-16 md:py-24') }} px-4 md:px-6"
    @if ($sectionStyle) style="{{ $sectionStyle }}" @endif>
    <x-section-media-background :section="$section" />
    <x-custom-code :model="$section" position="before" />

    <div class="relative z-10 max-w-3xl mx-auto text-center">
        @if ($section->subheading)
            <p class="section-eyebrow {{ $section->isLightText() ? 'text-white/90' : '' }} {{ $subheading['class'] }}"
                style="{{ $subheading['style'] }}">{{ $section->subheading }}
            </p>
        @endif
        @if ($section->heading)
            <h2 class="text-3xl md:text-4xl font-bold uppercase mb-10 {{ $heading['class'] }}"
                style="{{ $heading['style'] }}">{{ $section->heading }}</h2>
        @endif

        @if ($items->count())
            <div x-data="{
                active: 0,
                total: {{ $items->count() }},
                next() { this.active = (this.active + 1) % this.total },
                prev() { this.active = (this.active - 1 + this.total) % this.total },
            }" x-init="setInterval(() => next(), 7000)" class="relative">
                @foreach ($items as $item)
                    @php
                        $itemHeading = $item->textStyle('heading');
                        $itemBody = $item->textStyle('body');
                    @endphp
                    <div x-show="active === {{ $loop->index }}" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <x-custom-code :model="$item" position="before" />

                        @if ($item->hasRealImage())
                            <div class="w-16 h-16 rounded-full overflow-hidden mx-auto mb-4 ring-4 ring-white/10">
                                <x-site-image :src="$item->image_path" :label="$item->heading" :alt="$item->heading ?? ''"
                                    class="w-full h-full object-cover" />
                            </div>
                        @endif
                        @if ($item->rating)
                            <div class="flex justify-center gap-1 mb-4 text-yellow-400">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 {{ $i < $item->rating ? '' : 'opacity-30' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.448a1 1 0 00-.363 1.118l1.287 3.957c.3.921-.755 1.688-1.538 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.363-1.118L2.063 9.385c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.285-3.958z" />
                                    </svg>
                                @endfor
                            </div>
                        @endif
                        <p class="text-lg md:text-xl italic {{ $section->isLightText() ? 'text-white/90' : 'text-brand-dark/80' }} {{ $itemBody['class'] }}"
                            style="{{ $itemBody['style'] }}">
                            &ldquo;{{ $item->body }}&rdquo;
                        </p>
                        <p class="mt-6 font-heading font-semibold uppercase {{ $itemHeading['class'] }}"
                            style="{{ $itemHeading['style'] }}">{{ $item->heading }}</p>
                        @if ($item->subheading)
                            <p class="text-sm {{ $section->isLightText() ? 'text-white/60' : 'text-brand-dark/50' }}">
                                {{ $item->subheading }}</p>
                        @endif

                        <x-custom-code :model="$item" position="after" />
                    </div>
                @endforeach

                @if ($items->count() > 1)
                    <div class="flex justify-center gap-2 mt-8">
                        @foreach ($items as $item)
                            <button @click="active = {{ $loop->index }}"
                                class="w-2.5 h-2.5 rounded-full transition-colors"
                                :class="active === {{ $loop->index }} ? 'bg-brand-red' : 'bg-current opacity-30'"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>

    <x-custom-code :model="$section" position="after" />
</section>
