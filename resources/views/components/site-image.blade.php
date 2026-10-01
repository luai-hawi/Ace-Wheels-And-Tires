@props([
    'src' => null,
    'label' => null,
    'alt' => '',
    'width' => 800,
    'height' => 600,
])

{{--
    Central image slot used everywhere on the public site. Pass a real path
    once one exists (from a SectionItem/Page upload); until then it renders a
    clearly-labelled placeholder so it's obvious what still needs a real photo.
--}}
<img src="{{ \App\Support\Placeholder::resolve($src, $label, $width, $height) }}" alt="{{ $alt !== '' ? $alt : $label }}"
    loading="lazy" {{ $attributes->class(['w-full h-full object-cover']) }}>
