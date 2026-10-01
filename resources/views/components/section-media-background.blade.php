@props(['section'])

@if ($section->isVideoBackground() && $section->backgroundVideoUrl())
    <video class="pointer-events-none absolute inset-0 h-full w-full object-cover"
        src="{{ $section->backgroundVideoUrl() }}" autoplay muted loop playsinline></video>
    <div class="absolute inset-0 bg-brand-dark" style="opacity: {{ $section->backgroundOverlayOpacity() }}"></div>
@elseif ($section->isTransparentBackground() && $section->background_overlay > 0)
    {{-- Lets the page's own background show through, with an adjustable gray layer on top. --}}
    <div class="absolute inset-0 bg-gray-500" style="opacity: {{ $section->backgroundOverlayOpacity() }}"></div>
@endif
