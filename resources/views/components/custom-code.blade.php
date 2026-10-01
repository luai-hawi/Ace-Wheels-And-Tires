@props(['model', 'position'])

{{-- Freeform HTML/CSS/Tailwind an admin can add to any section or card without touching code. --}}
@if ($model->hasCustomCode($position))
    <div class="relative z-10 custom-code-block">
        {!! $model->custom_html !!}
    </div>
@endif
