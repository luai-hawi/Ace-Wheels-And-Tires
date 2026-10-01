<x-layout :page="$page">
    @forelse($page->activeSections as $section)
        @include($section->view(), ['section' => $section])
    @empty
        <div class="max-w-content mx-auto px-4 py-24 text-center text-brand-dark/60">
            This page doesn't have any content yet. Add sections to it from the admin panel.
        </div>
    @endforelse
</x-layout>
