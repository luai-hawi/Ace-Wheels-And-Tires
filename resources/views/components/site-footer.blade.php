@php
    $companyName = \App\Models\Setting::get('company_name', 'Ace Wheels and Tires');
    $phone = \App\Models\Setting::get('phone', '(318) 891-8173');
    $email = \App\Models\Setting::get('email');
    $addressLine1 = \App\Models\Setting::get('address_line1', '9025 Greenwood Rd');
    $addressCity = \App\Models\Setting::get('address_city', 'Greenwood');
    $addressState = \App\Models\Setting::get('address_state', 'LA');
    $addressZip = \App\Models\Setting::get('address_zip', '71033');
    $hoursWeekday = \App\Models\Setting::get('hours_weekday', 'Mon - Fri: 8:00 AM - 7:00 PM');
    $hoursSaturday = \App\Models\Setting::get('hours_saturday', 'Sat: 8:00 AM - 6:00 PM');
    $facebookUrl = \App\Models\Setting::get('facebook_url');
    $googleMapsUrl = \App\Models\Setting::get('google_maps_url');
    $googleReviewsUrl = \App\Models\Setting::get('google_reviews_url');
    $services = \App\Support\SiteNavigation::services();
@endphp

<footer class="bg-brand-dark text-white">
    <div class="max-w-content mx-auto px-4 md:px-6 py-14 grid grid-cols-1 md:grid-cols-4 gap-10">
        <div>
            <h3 class="font-heading text-lg font-bold uppercase mb-4">{{ $companyName }}</h3>
            <p class="text-white/70 text-sm leading-relaxed">
                Fast walk-in tire sales, repairs, and automotive maintenance for Greenwood, Shreveport
                and the surrounding areas.
            </p>
            <div class="flex gap-3 mt-5">
                @if ($facebookUrl)
                    <a href="{{ $facebookUrl }}" target="_blank" rel="noopener" aria-label="Facebook"
                        class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-red transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22 12a10 10 0 10-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0022 12z" />
                        </svg>
                    </a>
                @endif
                @if ($googleMapsUrl)
                    <a href="{{ $googleMapsUrl }}" target="_blank" rel="noopener" aria-label="Google Maps"
                        class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-red transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        <div>
            <h4 class="font-heading font-semibold uppercase text-sm tracking-wide mb-4 text-white/60">Our Services</h4>
            <ul class="space-y-2 text-sm">
                @foreach ($services->take(6) as $service)
                    <li><a href="{{ $service->url() }}"
                            class="text-white/80 hover:text-brand-red transition-colors">{{ $service->title }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h4 class="font-heading font-semibold uppercase text-sm tracking-wide mb-4 text-white/60">Contact Us</h4>
            <ul class="space-y-2 text-sm text-white/80">
                <li>{{ $addressLine1 }}</li>
                <li>{{ $addressCity }}, {{ $addressState }} {{ $addressZip }}</li>
                <li><a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}"
                        class="hover:text-brand-red transition-colors">{{ $phone }}</a></li>
                @if ($email)
                    <li><a href="mailto:{{ $email }}"
                            class="hover:text-brand-red transition-colors">{{ $email }}</a></li>
                @endif
            </ul>
        </div>

        <div>
            <h4 class="font-heading font-semibold uppercase text-sm tracking-wide mb-4 text-white/60">Hours</h4>
            <ul class="space-y-2 text-sm text-white/80">
                <li>{{ $hoursWeekday }}</li>
                <li>{{ $hoursSaturday }}</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10 py-6 px-4">
        <div class="max-w-content mx-auto flex items-center justify-center">
            @if ($googleReviewsUrl)
                <a href="{{ $googleReviewsUrl }}" target="_blank" rel="noopener"
                    class="inline-flex items-center gap-2 rounded-full bg-white/5 border border-white/10 pl-3 pr-5 py-2 text-sm font-semibold text-white hover:bg-white hover:text-brand-dark transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-5 h-5 shrink-0" viewBox="0 0 48 48">
                        <path fill="#FFC107"
                            d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z" />
                        <path fill="#FF3D00"
                            d="M6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z" />
                        <path fill="#4CAF50"
                            d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0124 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z" />
                        <path fill="#1976D2"
                            d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 01-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z" />
                    </svg>
                    Leave us a review on Google
                </a>
            @endif
        </div>
    </div>

    <div class="border-t border-white/10 py-5 text-center text-xs text-white/60">
        &copy; {{ now()->year }} {{ $companyName }}. All Rights Reserved.
    </div>
</footer>
