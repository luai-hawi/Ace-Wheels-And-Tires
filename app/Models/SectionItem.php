<?php

namespace App\Models;

use App\Support\HasTextStyles;
use App\Support\Placeholder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One reusable "card" belonging to a Section: a service tile, a gallery photo,
 * a brand logo, a testimonial, an FAQ entry or a pricing bullet. Which fields
 * are used depends on the parent section's type, but the shape stays the same
 * everywhere so the admin only has to learn one form.
 */
class SectionItem extends Model
{
    use HasTextStyles;

    protected $fillable = [
        'section_id',
        'image_path',
        'placeholder_key',
        'icon',
        'heading',
        'subheading',
        'body',
        'button_text',
        'button_url',
        'link_url',
        'rating',
        'animation',
        'sort_order',
        'is_active',
        'custom_html',
        'custom_html_position',
        'text_styles',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'integer',
        'text_styles' => 'array',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /** Real uploaded image if there is one, otherwise a labelled placeholder. */
    public function imageUrl(int $width = 800, int $height = 600): string
    {
        return Placeholder::resolve($this->image_path, $this->placeholder_key ?? $this->heading, $width, $height);
    }

    /** True once a real photo has been uploaded (as opposed to only a placeholder label). */
    public function hasRealImage(): bool
    {
        return filled($this->image_path);
    }
}
