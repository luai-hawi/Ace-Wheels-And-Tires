<x-layout :page="$page">
    <article class="py-16 md:py-24 px-4 md:px-6">
        <div class="max-w-3xl mx-auto">
            <p class="text-xs uppercase tracking-wide text-brand-red font-semibold mb-2 text-center">
                {{ $page->published_at?->format('F j, Y') }}
            </p>
            <h1 class="text-3xl md:text-5xl font-bold uppercase text-center mb-8">{{ $page->title }}</h1>

            <div class="rounded-2xl overflow-hidden shadow-xl aspect-video mb-10">
                <x-site-image :src="$page->featured_image" :label="$page->title" :alt="$page->title" />
            </div>

            @foreach ($page->activeSections as $section)
                @if ($section->body)
                    <div class="prose max-w-none mb-8">{!! $section->body !!}</div>
                @else
                    @include($section->view(), ['section' => $section])
                @endif
            @endforeach

            <div class="text-center mt-12">
                <a href="{{ route('blog.index') }}" class="btn-primary">Back to Blog</a>
            </div>
        </div>
    </article>
</x-layout>
