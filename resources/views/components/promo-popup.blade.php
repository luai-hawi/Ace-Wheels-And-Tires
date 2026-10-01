@props(['page' => null])

@php
    $popups = \App\Models\Popup::active()->get()->filter(fn($popup) => $popup->appliesToSlug($page?->slug));
    $modals = $popups->where('type', \App\Models\Popup::TYPE_MODAL);
    $sideWidgets = $popups->where('type', \App\Models\Popup::TYPE_SIDE_WIDGET);
@endphp

{{-- Center "ad" popups — admin can create as many as they like from Popups & Widgets. --}}
@foreach ($modals as $popup)
    <div x-data="popupWidget({
        id: {{ $popup->id }},
        trigger: '{{ $popup->trigger }}',
        triggerValue: {{ (int) $popup->trigger_value }},
        frequency: '{{ $popup->frequency }}',
    })" x-show="open" x-cloak x-transition.opacity
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 p-4"
        @keydown.escape.window="open = false">
        <div @click.outside="open = false" x-show="open" x-transition
            class="relative w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden"
            style="background-color: {{ $popup->background_color ?: '#ffffff' }}; color: {{ $popup->text_color ?: '#242424' }};">
            <button @click="open = false" aria-label="Close"
                class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white/90 flex items-center justify-center shadow hover:bg-white text-brand-dark">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <x-custom-code :model="$popup" position="before" />

            @if ($popup->imageUrl())
                <div class="aspect-[4/3]">
                    <x-site-image :src="$popup->image" :label="$popup->heading" class="w-full h-full object-cover" />
                </div>
            @endif

            <div class="p-6 text-center">
                @if ($popup->heading)
                    <h3 class="font-heading font-bold text-xl uppercase mb-2">{{ $popup->heading }}</h3>
                @endif
                @if ($popup->body)
                    <p class="opacity-80 mb-4">{{ $popup->body }}</p>
                @endif
                @if ($popup->button_text && $popup->button_url)
                    <a href="{{ $popup->button_url }}" class="btn-primary">{{ $popup->button_text }}</a>
                @endif
            </div>

            <x-custom-code :model="$popup" position="after" />
        </div>
    </div>
@endforeach

{{-- Side-of-screen quick contact widget(s) — always visible while enabled, no interruption. --}}
@foreach ($sideWidgets as $index => $popup)
    @php $side = $popup->position === 'left' ? 'left' : 'right'; @endphp
    <div x-data="{ open: false }" class="fixed z-40 {{ $side === 'right' ? 'right-0' : 'left-0' }}"
        style="bottom: {{ 112 + $index * 16 }}px;">
        {{-- Collapsed tab --}}
        <button x-show="!open" x-transition @click="open = true"
            class="flex items-center gap-2 {{ $side === 'right' ? 'rounded-l-full pl-4 pr-3' : 'rounded-r-full pr-4 pl-3' }} py-3 bg-brand-red text-white shadow-xl hover:bg-brand-dark transition-colors animate-pulse-ring"
            aria-label="{{ $popup->heading ?? 'Quick contact' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span
                class="hidden sm:inline font-semibold text-sm whitespace-nowrap">{{ $popup->heading ?? 'Quick Contact' }}</span>
        </button>

        {{-- Expanded panel --}}
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="{{ $side === 'right' ? 'translate-x-full' : '-translate-x-full' }} opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100" @click.outside="open = false"
            class="w-72 max-w-[85vw] rounded-2xl shadow-2xl overflow-hidden {{ $side === 'right' ? 'mr-0' : 'ml-0' }}"
            style="background-color: {{ $popup->background_color ?: '#242424' }}; color: {{ $popup->text_color ?: '#ffffff' }};">
            <div class="flex items-center justify-between p-4 border-b border-white/10">
                <p class="font-heading font-bold uppercase text-sm">{{ $popup->heading ?? 'Quick Contact' }}</p>
                <button @click="open = false" aria-label="Close" class="opacity-70 hover:opacity-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <x-custom-code :model="$popup" position="before" />

            <div class="p-4 space-y-3">
                @if ($popup->body)
                    <p class="text-sm opacity-80">{{ $popup->body }}</p>
                @endif

                <a href="tel:{{ preg_replace('/[^0-9+]/', '', \App\Models\Setting::get('phone', '')) }}"
                    class="flex items-center gap-2 text-sm font-semibold hover:opacity-80">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    {{ \App\Models\Setting::get('phone') }}
                </a>

                @if ($popup->button_text && $popup->button_url)
                    <a href="{{ $popup->button_url }}"
                        class="btn-primary w-full justify-center text-sm">{{ $popup->button_text }}</a>
                @endif
            </div>

            <x-custom-code :model="$popup" position="after" />
        </div>
    </div>
@endforeach
