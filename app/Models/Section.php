<?php

namespace App\Models;

use App\Support\HasTextStyles;
use App\Support\Placeholder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A Section is one editable block of a page (a hero, a card grid, a testimonial
 * slider...). Its `type` decides which Blade partial in resources/views/sections
 * renders it, and `data` holds any extra fields that type needs.
 */
class Section extends Model
{
    use HasTextStyles;

    public const BACKGROUNDS = [
        'light' => 'Light',
        'dark' => 'Dark',
        'red' => 'Brand red',
        'custom' => 'Custom color',
        'image' => 'Background image',
        'video' => 'Background video',
        'transparent' => 'Transparent (show page background)',
    ];

    public const BACKGROUND_SIZES = [
        'cover' => 'Cover (crop to fill)',
        'contain' => 'Contain (fit whole image)',
        'fill' => 'Fill (stretch to section)',
        'original' => 'Original size',
        'fit-width' => 'Fit width',
        'fit-height' => 'Fit height',
    ];

    public const BACKGROUND_POSITIONS = [
        'top-left' => 'Top left',
        'top' => 'Top',
        'top-right' => 'Top right',
        'left' => 'Left',
        'center' => 'Center',
        'right' => 'Right',
        'bottom-left' => 'Bottom left',
        'bottom' => 'Bottom',
        'bottom-right' => 'Bottom right',
    ];

    public const BACKGROUND_REPEATS = [
        'no-repeat' => 'No repeat',
        'repeat' => 'Repeat',
        'repeat-x' => 'Repeat horizontally',
        'repeat-y' => 'Repeat vertically',
    ];

    /** Vertical padding/height preset — overrides the section type's own default when set. */
    public const SIZES = [
        '' => 'Default for this section type',
        'compact' => 'Compact',
        'spacious' => 'Spacious',
        'full' => 'Full height (fills the screen)',
    ];

    /**
     * Every section type the site supports, with the admin-facing label.
     * Single source of truth: the Filament form's type Select uses this list,
     * and each key must have a matching resources/views/sections/{key}.blade.php partial.
     */
    public const TYPES = [
        'hero' => 'Hero banner',
        'richtext' => 'Text block (with optional image)',
        'card_grid' => 'Card grid (services / features)',
        'cta_banner' => 'Call-to-action banner',
        'brand_logos' => 'Logos / badges strip',
        'google_reviews' => 'Google Reviews Badge',
        'testimonial_slider' => 'Testimonials slider',
        'map_areas' => 'Map + areas list',
        'faq_accordion' => 'FAQ accordion',
        'gallery' => 'Photo gallery',
    ];

    protected $fillable = [
        'page_id',
        'type',
        'heading',
        'subheading',
        'body',
        'button_text',
        'button_url',
        'background',
        'background_image',
        'background_video',
        'background_color',
        'text_color',
        'background_overlay',
        'background_size',
        'background_position',
        'background_repeat',
        'size',
        'min_height',
        'layout',
        'animation',
        'sort_order',
        'is_active',
        'data',
        'custom_html',
        'custom_html_position',
        'text_styles',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'data' => 'array',
        'text_styles' => 'array',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SectionItem::class)->orderBy('sort_order');
    }

    /** Only the cards/images that should currently show on the front end. */
    public function activeItems(): HasMany
    {
        return $this->items()->where('is_active', true);
    }

    /** Reads one key out of the freeform `data` JSON without null-check boilerplate in views. */
    public function dataValue(string $key, mixed $default = null): mixed
    {
        return data_get($this->data, $key, $default);
    }

    public function view(): string
    {
        return 'sections.' . $this->type;
    }

    /**
     * Tailwind classes for the section's chosen background style. Centralised so
     * every section partial looks consistent instead of repeating this mapping.
     */
    public function backgroundClasses(): string
    {
        return match ($this->background) {
            'dark' => 'bg-brand-dark text-white',
            'red' => 'bg-brand-red text-white',
            'custom' => 'relative text-white',
            'image' => 'relative bg-brand-dark text-white',
            'video' => 'relative overflow-hidden bg-brand-dark text-white',
            'transparent' => 'relative overflow-hidden',
            default => 'bg-white text-brand-dark',
        };
    }

    /**
     * Vertical padding/min-height classes for this section's `size` setting,
     * falling back to the section type's own natural default when unset.
     */
    public function sizeClasses(string $default): string
    {
        return match ($this->size) {
            'compact' => 'py-8 md:py-12',
            'spacious' => 'py-28 md:py-40',
            'full' => 'py-16 md:py-24 min-h-screen flex items-center',
            default => $default,
        };
    }

    public function isLightText(): bool
    {
        return in_array($this->background, ['dark', 'red', 'custom', 'image', 'video'], true);
    }

    public function isImageBackground(): bool
    {
        return $this->background === 'image';
    }

    public function isVideoBackground(): bool
    {
        return $this->background === 'video';
    }

    public function isCustomColorBackground(): bool
    {
        return $this->background === 'custom';
    }

    public function isTransparentBackground(): bool
    {
        return $this->background === 'transparent';
    }

    public function backgroundVideoUrl(): ?string
    {
        return $this->background_video ? Placeholder::resolve($this->background_video) : null;
    }

    /** Inline `background-color` style for the 'custom color' background option. */
    public function backgroundColorStyle(): ?string
    {
        if (! $this->isCustomColorBackground()) {
            return null;
        }

        return 'background-color: ' . ($this->background_color ?: '#242424') . ';';
    }

    public function backgroundImageStyle(): ?string
    {
        if (! $this->isImageBackground()) {
            return null;
        }

        $size = match ($this->background_size) {
            'contain' => 'contain',
            'fill' => '100% 100%',
            'original' => 'auto auto',
            'fit-width' => '100% auto',
            'fit-height' => 'auto 100%',
            default => 'cover',
        };
        $position = match ($this->background_position) {
            'top-left' => 'left top',
            'top' => 'center top',
            'top-right' => 'right top',
            'left' => 'left center',
            'center' => 'center',
            'right' => 'right center',
            'bottom-left' => 'left bottom',
            'bottom' => 'center bottom',
            'bottom-right' => 'right bottom',
            default => 'center',
        };
        $repeat = array_key_exists($this->background_repeat, self::BACKGROUND_REPEATS)
            ? $this->background_repeat
            : 'no-repeat';
        $overlay = $this->backgroundOverlayOpacity();

        // Deliberately NOT labelled with the heading — a placeholder box whose baked-in
        // text matches the heading sitting right on top of it reads as a rendering bug.
        return "background-image: linear-gradient(rgba(36,36,36,{$overlay}), rgba(36,36,36,{$overlay})), url('"
            . Placeholder::resolve($this->background_image, 'Background image', 1920, 1080)
            . "'); background-size: cover, {$size}; background-position: center, {$position}; background-repeat: no-repeat, {$repeat};";
    }

    /** 0-100 "darkness" overlay setting converted to a 0-1 CSS opacity value. */
    public function backgroundOverlayOpacity(): float
    {
        return max(0, min(100, $this->background_overlay ?? 65)) / 100;
    }

    /**
     * Combined inline `style` attribute: whatever the background type needs
     * (image/custom color), plus an exact pixel `min-height` on top of the
     * `size` preset's Tailwind classes when the admin sets one.
     */
    public function styleAttribute(): ?string
    {
        $style = match (true) {
            $this->isImageBackground() => $this->backgroundImageStyle(),
            $this->isCustomColorBackground() => $this->backgroundColorStyle(),
            default => null,
        };

        if ($this->min_height) {
            $style = rtrim((string) $style) . " min-height: {$this->min_height}px;";
        }

        return $style;
    }
}
