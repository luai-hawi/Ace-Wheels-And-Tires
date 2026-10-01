<?php

namespace App\Support;

/**
 * Shared per-text-part (heading/subheading/body) styling for Section and
 * SectionItem: lets an admin override color/size/weight/alignment for each
 * piece of text on an element without a code change. Both models store the
 * same `text_styles` JSON shape, so the lookup/rendering logic lives here once.
 *
 * @property array|null $text_styles
 * @property string|null $custom_html
 * @property string|null $custom_html_position
 * @property array $attributes
 */
trait HasTextStyles
{
    public const TEXT_SIZES = [
        '' => 'Default',
        'sm' => 'Small',
        'base' => 'Normal',
        'lg' => 'Large',
        'xl' => 'Extra large',
        '2xl' => '2X large',
        '3xl' => '3X large',
        '4xl' => '4X large',
        '5xl' => '5X large',
    ];

    public const TEXT_WEIGHTS = [
        '' => 'Default',
        'normal' => 'Normal',
        'medium' => 'Medium',
        'semibold' => 'Semibold',
        'bold' => 'Bold',
    ];

    public const TEXT_ALIGNS = [
        '' => 'Default',
        'left' => 'Left',
        'center' => 'Center',
        'right' => 'Right',
    ];

    /**
     * @return array{class: string, style: string} Tailwind classes + inline style
     *   (color only — arbitrary hex can't be a safelisted Tailwind class) for the
     *   given text part ('heading', 'subheading' or 'body').
     */
    public function textStyle(string $part): array
    {
        $style = (array) data_get($this->text_styles, $part, []);

        $classes = array_filter([
            match ($style['size'] ?? null) {
                'sm' => 'text-sm',
                'base' => 'text-base',
                'lg' => 'text-lg',
                'xl' => 'text-xl',
                '2xl' => 'text-2xl',
                '3xl' => 'text-3xl',
                '4xl' => 'text-4xl',
                '5xl' => 'text-5xl',
                default => null,
            },
            match ($style['weight'] ?? null) {
                'normal' => 'font-normal',
                'medium' => 'font-medium',
                'semibold' => 'font-semibold',
                'bold' => 'font-bold',
                default => null,
            },
            match ($style['align'] ?? null) {
                'left' => 'text-left',
                'center' => 'text-center',
                'right' => 'text-right',
                default => null,
            },
        ]);

        // A part-specific color wins; otherwise fall back to the element-wide
        // text color override (Section only — SectionItem has no such column).
        $color = $style['color'] ?? ($this->attributes['text_color'] ?? null);

        return [
            'class' => implode(' ', $classes),
            'style' => $color ? "color: {$color};" : '',
        ];
    }

    public function hasCustomCode(string $position): bool
    {
        return filled($this->custom_html) && $this->custom_html_position === $position;
    }
}
