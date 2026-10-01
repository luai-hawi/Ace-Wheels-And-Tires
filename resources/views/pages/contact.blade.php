<x-layout :page="$page">
    @foreach ($page->activeSections as $section)
        @include($section->view(), ['section' => $section])
    @endforeach

    @php
        $mapEmbedUrl = \App\Models\Setting::get('google_maps_location_embed_url');
        $phone = \App\Models\Setting::get('phone', '(318) 891-8173');
        $addressLine1 = \App\Models\Setting::get('address_line1');
        $addressCity = \App\Models\Setting::get('address_city');
        $addressState = \App\Models\Setting::get('address_state');
        $addressZip = \App\Models\Setting::get('address_zip');
        $hoursWeekday = \App\Models\Setting::get('hours_weekday');
        $hoursSaturday = \App\Models\Setting::get('hours_saturday');
    @endphp

    <section class="py-16 md:py-24 px-4 md:px-6 bg-brand-light" data-reveal="fade-up">
        <div class="max-w-content mx-auto grid lg:grid-cols-2 gap-10 items-start">
            <div>
                <div class="mb-10">
                    <p class="section-eyebrow">Get In Touch</p>
                    <h2 class="section-title">Request Service Or Ask A Question</h2>
                </div>

                @if (session('status'))
                    <div class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}"
                    class="bg-white rounded-2xl shadow-xl p-6 md:p-10 space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold mb-1" for="name">Name *</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required
                            class="w-full rounded-lg border-gray-300 focus:border-brand-red focus:ring-brand-red">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1" for="email">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                class="w-full rounded-lg border-gray-300 focus:border-brand-red focus:ring-brand-red">
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1" for="phone">Phone</label>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}"
                                class="w-full rounded-lg border-gray-300 focus:border-brand-red focus:ring-brand-red">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1" for="service_interested">Service interested
                            in</label>
                        <select id="service_interested" name="service_interested"
                            class="w-full rounded-lg border-gray-300 focus:border-brand-red focus:ring-brand-red">
                            <option value="">Select a service (optional)</option>
                            @foreach (\App\Support\SiteNavigation::services() as $service)
                                <option value="{{ $service->title }}" @selected(old('service_interested', $preselectedService) === $service->title)>
                                    {{ $service->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1" for="message">Message</label>
                        <textarea id="message" name="message" rows="4"
                            class="w-full rounded-lg border-gray-300 focus:border-brand-red focus:ring-brand-red">{{ old('message') }}</textarea>
                    </div>

                    @if ($recaptchaSiteKey)
                        <div>
                            <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                            @error('g-recaptcha-response')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <button type="submit" class="btn-primary w-full text-lg">Send Request</button>
                </form>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl overflow-hidden shadow-xl aspect-video" data-reveal="zoom-in">
                    @if ($mapEmbedUrl)
                        <iframe src="{{ $mapEmbedUrl }}" class="w-full h-full border-0" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" title="Google Maps location"></iframe>
                    @else
                        <x-site-image label="Our location" />
                    @endif
                </div>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="card p-5">
                        <p class="font-heading font-bold uppercase text-sm mb-1">Our Location</p>
                        <p class="text-sm text-brand-dark/70">
                            {{ $addressLine1 }}<br>
                            {{ $addressCity }}, {{ $addressState }} {{ $addressZip }}
                        </p>
                    </div>
                    <div class="card p-5">
                        <p class="font-heading font-bold uppercase text-sm mb-1">Call Us</p>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}"
                            class="text-sm text-brand-dark/70 hover:text-brand-red">{{ $phone }}</a>
                    </div>
                    <div class="card p-5">
                        <p class="font-heading font-bold uppercase text-sm mb-1">Hours</p>
                        <p class="text-sm text-brand-dark/70">
                            {{ $hoursWeekday }}<br>
                            {{ $hoursSaturday }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($recaptchaSiteKey)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
</x-layout>
