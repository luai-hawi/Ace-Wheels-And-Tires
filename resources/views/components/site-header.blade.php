@php
    $services = \App\Support\SiteNavigation::services();
    $areas = \App\Support\SiteNavigation::serviceAreas();
    $phone = \App\Models\Setting::get('phone', '(318) 891-8173');
    $companyName = \App\Models\Setting::get('company_name', 'Ace Wheels and Tires');
    $logoPath = \App\Models\Setting::get('logo_path');
    $hoursWeekday = \App\Models\Setting::get('hours_weekday');
    $hoursSaturday = \App\Models\Setting::get('hours_saturday');
    $addressLine1 = \App\Models\Setting::get('address_line1');
    $addressCity = \App\Models\Setting::get('address_city');
    $addressState = \App\Models\Setting::get('address_state');
@endphp

<header x-data="{ mobileOpen: false, mobileServices: false, mobileAreas: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 12"
    class="sticky top-0 z-50 border-b border-white/10 bg-brand-dark/70 backdrop-blur-xl transition-shadow duration-300"
    :class="scrolled ? 'shadow-2xl' : 'shadow-lg'">

    {{-- Utility bar: quick hours/address, desktop only --}}
    @if ($hoursWeekday || $addressLine1)
        <div class="hidden lg:block border-b border-white/5 bg-black/25">
            <div class="max-w-content mx-auto flex items-center justify-between px-6 py-1.5 text-xs text-white/55">
                <div class="flex items-center gap-4">
                    @if ($hoursWeekday)
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $hoursWeekday }}@if ($hoursSaturday)
                                &bull; {{ $hoursSaturday }}
                            @endif
                        </span>
                    @endif
                </div>
                <div class="flex items-center gap-4">
                    @if ($addressLine1)
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $addressLine1 }}, {{ $addressCity }}, {{ $addressState }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="max-w-content mx-auto flex items-center justify-between gap-4 px-4 py-3 md:px-6">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
            @if ($logoPath)
                <img src="{{ \App\Support\Placeholder::resolve($logoPath) }}" alt="{{ $companyName }}"
                    class="h-10 md:h-12 w-auto rounded">
            @else
                <span class="font-heading text-xl md:text-2xl font-bold uppercase tracking-wide text-white">
                    {{ $companyName }}
                </span>
            @endif
        </a>

        {{-- Desktop nav --}}
        <nav
            class="hidden xl:flex items-center gap-0.5 font-medium text-white whitespace-nowrap rounded-full border border-white/10 bg-white/5 px-2 py-1 backdrop-blur-md">
            <a href="{{ route('home') }}"
                class="px-3 py-2 rounded-full hover:bg-white/10 hover:text-brand-red transition-all duration-200">Home</a>
            <a href="{{ route('pages.show', 'about-us') }}"
                class="px-3 py-2 rounded-full hover:bg-white/10 hover:text-brand-red transition-all duration-200">About
                Us</a>

            {{-- Our Services mega menu --}}
            <div class="relative group">
                <button
                    class="px-3 py-2 rounded-full hover:bg-white/10 hover:text-brand-red transition-all duration-200 inline-flex items-center gap-1">
                    Our Services
                    <svg class="w-3 h-3 mt-px" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div
                    class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-opacity absolute left-1/2 -translate-x-1/2 top-full pt-3 w-[640px] max-w-[90vw]">
                    <div class="grid grid-cols-2 gap-1 rounded-lg bg-white text-brand-dark shadow-2xl p-4">
                        @foreach ($services as $service)
                            <a href="{{ $service->url() }}"
                                class="flex items-center gap-2 rounded px-3 py-2 hover:bg-brand-light hover:text-brand-red transition-colors">
                                <span class="w-2 h-2 rounded-full bg-brand-red shrink-0"></span>
                                {{ $service->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Areas We Serve dropdown --}}
            <div class="relative group">
                <a href="{{ route('pages.show', 'areas-we-serve') }}"
                    class="px-3 py-2 rounded-full hover:bg-white/10 hover:text-brand-red transition-all duration-200 inline-flex items-center gap-1">
                    Areas We Serve
                    <svg class="w-3 h-3 mt-px" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <div
                    class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-opacity absolute left-1/2 -translate-x-1/2 top-full pt-3 w-72">
                    <div class="rounded-lg bg-white text-brand-dark shadow-2xl p-2">
                        @foreach ($areas as $area)
                            <a href="{{ $area->url() }}"
                                class="block rounded px-3 py-2 hover:bg-brand-light hover:text-brand-red transition-colors">
                                {{ $area->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <a href="{{ route('pages.show', 'faqs') }}"
                class="px-3 py-2 rounded-full hover:bg-white/10 hover:text-brand-red transition-all duration-200">FAQs</a>
            <a href="{{ route('blog.index') }}"
                class="px-3 py-2 rounded-full hover:bg-white/10 hover:text-brand-red transition-all duration-200">Blog</a>
            <a href="{{ route('pages.show', 'financing') }}"
                class="px-3 py-2 rounded-full hover:bg-white/10 hover:text-brand-red transition-all duration-200">Financing</a>
            <a href="{{ route('contact') }}"
                class="px-3 py-2 rounded-full hover:bg-white/10 hover:text-brand-red transition-all duration-200">Contact</a>
        </nav>

        {{-- Phone + CTA (desktop) / hamburger (mobile) --}}
        <div class="flex items-center gap-4 ml-auto xl:ml-4 xl:pl-4 xl:border-l xl:border-white/15 shrink-0">
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}"
                class="hidden md:inline-flex shrink-0 items-center gap-2 text-white font-semibold whitespace-nowrap hover:text-brand-red transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                </svg>
                <span class="whitespace-nowrap">{{ $phone }}</span>
            </a>
            <a href="{{ route('contact') }}"
                class="hidden md:inline-flex shrink-0 btn-primary !py-2 !px-4 text-sm whitespace-nowrap">Request
                Service</a>

            <button @click="mobileOpen = true" class="xl:hidden text-white p-2" aria-label="Open menu">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile drawer: teleported to <body> so the header's backdrop-blur (which creates a
    CSS containing block for fixed-position descendants) doesn't trap the drawer inside the
    navbar's height instead of covering the full viewport. --}}
    <template x-teleport="body">
        <div x-cloak x-show="mobileOpen" x-transition.opacity class="fixed inset-0 bg-black/60 z-40 xl:hidden"
            @click="mobileOpen = false"></div>
    </template>
    <template x-teleport="body">
        <div x-cloak x-show="mobileOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed inset-y-0 right-0 z-50 w-80 max-w-[85vw] bg-white shadow-2xl overflow-y-auto xl:hidden">
            <div class="flex items-center justify-between p-4 border-b">
                <span class="font-heading font-bold uppercase">Menu</span>
                <button @click="mobileOpen = false" class="p-2" aria-label="Close menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="flex flex-col p-4 gap-1 font-medium">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded hover:bg-brand-light">Home</a>
                <a href="{{ route('pages.show', 'about-us') }}" class="px-3 py-2 rounded hover:bg-brand-light">About
                    Us</a>

                <button @click="mobileServices = !mobileServices"
                    class="flex items-center justify-between px-3 py-2 rounded hover:bg-brand-light">
                    Our Services
                    <span x-text="mobileServices ? '−' : '+'"></span>
                </button>
                <div x-show="mobileServices" class="pl-4">
                    @foreach ($services as $service)
                        <a href="{{ $service->url() }}"
                            class="block px-3 py-2 rounded hover:bg-brand-light text-sm">{{ $service->title }}</a>
                    @endforeach
                </div>

                <button @click="mobileAreas = !mobileAreas"
                    class="flex items-center justify-between px-3 py-2 rounded hover:bg-brand-light">
                    Areas We Serve
                    <span x-text="mobileAreas ? '−' : '+'"></span>
                </button>
                <div x-show="mobileAreas" class="pl-4">
                    @foreach ($areas as $area)
                        <a href="{{ $area->url() }}"
                            class="block px-3 py-2 rounded hover:bg-brand-light text-sm">{{ $area->title }}</a>
                    @endforeach
                </div>

                <a href="{{ route('pages.show', 'faqs') }}" class="px-3 py-2 rounded hover:bg-brand-light">FAQs</a>
                <a href="{{ route('blog.index') }}" class="px-3 py-2 rounded hover:bg-brand-light">Blog</a>
                <a href="{{ route('pages.show', 'financing') }}"
                    class="px-3 py-2 rounded hover:bg-brand-light">Financing</a>
                <a href="{{ route('contact') }}" class="px-3 py-2 rounded hover:bg-brand-light">Contact</a>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}"
                    class="btn-primary mt-2 justify-center">Call
                    {{ $phone }}</a>
            </nav>
        </div>
    </template>
</header>
