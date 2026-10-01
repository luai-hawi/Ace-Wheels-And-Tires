@props(['page' => null])

@php
    $companyName = \App\Models\Setting::get('company_name', 'Ace Wheels and Tires');
    $pageTitle = $page?->meta_title ?: $page?->title;
    $documentTitle = $pageTitle ? "{$pageTitle} | {$companyName}" : $companyName;

    $siteBgType = \App\Models\Setting::get('site_background_type', 'none');
    $pageHasOwnBg = $page?->hasCustomBackground();
    $bgType = $pageHasOwnBg ? $page->background_type : ($page?->background_type === 'none' ? 'none' : $siteBgType);
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $documentTitle }}</title>
    @if ($page?->metaDescription())
        <meta name="description" content="{{ $page->metaDescription() }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-brand-dark">
    {{-- Sitewide or per-page background layer (color/image/video), sits behind everything. --}}
    @if ($bgType !== 'none')
        <div class="fixed inset-0 -z-10 overflow-hidden"
            @if ($pageHasOwnBg && $page->background_type === 'color') style="{{ $page->backgroundStyle() }}"
            @elseif ($pageHasOwnBg && $page->background_type === 'image') style="{{ $page->backgroundStyle() }}"
            @elseif (!$pageHasOwnBg && $siteBgType === 'color') style="background-color: {{ \App\Models\Setting::get('site_background_color', '#f4f4f4') }};"
            @elseif (!$pageHasOwnBg && $siteBgType === 'image') style="background-image: url('{{ \App\Support\Placeholder::resolve(\App\Models\Setting::get('site_background_image')) }}'); background-size: cover; background-position: center; background-attachment: fixed;" @endif>
            @if ($pageHasOwnBg && $page->isVideoBackground() && $page->backgroundVideoUrl())
                <video class="h-full w-full object-cover" src="{{ $page->backgroundVideoUrl() }}" autoplay muted loop
                    playsinline></video>
                <div class="absolute inset-0 bg-black" style="opacity: {{ $page->backgroundOverlayOpacity() }}"></div>
            @elseif (!$pageHasOwnBg && $siteBgType === 'video' && \App\Models\Setting::get('site_background_video'))
                <video class="h-full w-full object-cover"
                    src="{{ \App\Support\Placeholder::resolve(\App\Models\Setting::get('site_background_video')) }}"
                    autoplay muted loop playsinline></video>
                <div class="absolute inset-0 bg-black"
                    style="opacity: {{ max(0, min(100, (int) \App\Models\Setting::get('site_background_overlay', 0))) / 100 }}">
                </div>
            @elseif ($pageHasOwnBg && $page->background_type === 'image')
                <div class="absolute inset-0 bg-black" style="opacity: {{ $page->backgroundOverlayOpacity() }}"></div>
            @endif
        </div>
    @endif

    <x-site-header />

    <main>
        {{ $slot }}
    </main>

    <x-site-footer />
    <x-promo-popup :page="$page" />
</body>

</html>
