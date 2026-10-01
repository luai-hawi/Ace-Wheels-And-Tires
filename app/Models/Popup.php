<?php

namespace App\Models;

use App\Support\Placeholder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * An admin-manageable popup or widget: either a big center "ad" modal or a
 * small quick-contact widget stuck to the side of the screen. Multiple of
 * each can exist at once — every visual/behavioural knob lives on this one
 * model so new ones can be created from the admin without a code change.
 */
class Popup extends Model
{
    public const TYPE_MODAL = 'modal';

    public const TYPE_SIDE_WIDGET = 'side_widget';

    public const TYPES = [
        self::TYPE_MODAL => 'Center popup (ad / announcement)',
        self::TYPE_SIDE_WIDGET => 'Side widget (quick contact)',
    ];

    public const TRIGGERS = [
        'on_load' => 'As soon as the page loads',
        'delay' => 'After a delay',
        'scroll_percent' => 'After scrolling down',
        'exit_intent' => 'When the visitor tries to leave (desktop)',
    ];

    public const FREQUENCIES = [
        'every_visit' => 'Every page view',
        'once_per_session' => 'Once per browser session',
        'once_per_day' => 'Once per day',
        'once_ever' => 'Only once, ever',
    ];

    protected $fillable = [
        'name',
        'type',
        'is_enabled',
        'heading',
        'body',
        'image',
        'button_text',
        'button_url',
        'background_color',
        'text_color',
        'position',
        'trigger',
        'trigger_value',
        'frequency',
        'show_on',
        'custom_html',
        'custom_html_position',
        'starts_at',
        'ends_at',
        'sort_order',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'show_on' => 'array',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_enabled', true)
            ->where(fn($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()))
            ->orderBy('sort_order');
    }

    /** Whether this popup should appear on the given page slug (empty show_on = every page). */
    public function appliesToSlug(?string $slug): bool
    {
        if (blank($this->show_on)) {
            return true;
        }

        return in_array($slug, $this->show_on, true);
    }

    public function imageUrl(): ?string
    {
        return $this->image ? Placeholder::resolve($this->image) : null;
    }

    public function hasCustomCode(string $position): bool
    {
        return filled($this->custom_html) && $this->custom_html_position === $position;
    }

    /** A stable per-popup key so the "seen" flag in localStorage doesn't clash between popups. */
    protected function storageKey(): Attribute
    {
        return Attribute::get(fn() => "acewheels_popup_{$this->id}");
    }
}
