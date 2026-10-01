<x-layout :page="$blogPage">
    @foreach ($blogPage->activeSections as $section)
        @include($section->view(), ['section' => $section])
    @endforeach

    <section class="py-16 md:py-24 px-4 md:px-6">
        <div class="max-w-content mx-auto">
            <form method="GET" class="max-w-xl mx-auto mb-12" role="search">
                <label for="blog-search" class="sr-only">Search articles</label>
                <div class="relative">
                    <input id="blog-search" type="search" name="q" value="{{ $search }}"
                        placeholder="Search articles…"
                        class="w-full rounded-full border-gray-300 pl-5 pr-14 py-3 shadow-sm focus:border-brand-red focus:ring-brand-red">
                    <button type="submit" aria-label="Search"
                        class="absolute right-1.5 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-brand-red text-white flex items-center justify-center hover:bg-brand-dark transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </div>
                @if ($search !== '')
                    <p class="text-center text-sm text-brand-dark/60 mt-3">
                        {{ $posts->total() }} result{{ $posts->total() === 1 ? '' : 's' }} for
                        &ldquo;{{ $search }}&rdquo;
                        &middot; <a href="{{ route('blog.index') }}" class="text-brand-red hover:underline">Clear
                            search</a>
                    </p>
                @endif
            </form>

            @if ($posts->isEmpty())
                <p class="text-center text-brand-dark/60">
                    @if ($search !== '')
                        No articles match &ldquo;{{ $search }}&rdquo;. Try a different search.
                    @else
                        No blog posts published yet — check back soon!
                    @endif
                </p>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($posts as $post)
                        <a href="{{ $post->url() }}" class="card overflow-hidden group" data-reveal="fade-up"
                            data-reveal-delay="{{ $loop->index * 80 }}">
                            <div class="aspect-[16/10] overflow-hidden">
                                <x-site-image :src="$post->featured_image" :label="$post->title" :alt="$post->title"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                            </div>
                            <div class="p-6">
                                <p class="text-xs uppercase tracking-wide text-brand-red font-semibold mb-2">
                                    {{ $post->published_at?->format('M j, Y') }}
                                </p>
                                <h3 class="font-heading font-bold text-lg uppercase mb-2">{{ $post->title }}</h3>
                                @if ($post->excerpt)
                                    <p class="text-sm text-brand-dark/70">{{ $post->excerpt }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
</x-layout>
