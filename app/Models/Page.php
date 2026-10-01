<?php

namespace App\Models;

use App\Support\Placeholder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A Page represents every piece of navigable content on the site: the homepage,
 * static pages (About Us, FAQs...), services, service areas and blog posts.
 * Sharing one model/table for all of them keeps the admin panel and the
 * rendering logic identical no matter what kind of content is being managed.
 */
class Page extends Model
{
    use HasFactory;

    public const TYPE_PAGE = 'page';
    public const TYPE_SERVICE = 'service';
    public const TYPE_SERVICE_AREA = 'service_area';
    public const TYPE_BLOG_POST = 'blog_post';

    protected $fillable = [
        'type',
        'slug',
        'title',
        'excerpt',
        'featured_image',
        'icon',
        'meta_title',
        'meta_description',
        'is_published',
        'show_in_menu',
        'menu_order',
        'published_at',
        'parent_id',
        'background_type',
        'background_color',
        'background_image',
        'background_video',
        'background_overlay',
        'background_size',
        'background_position',
        'background_repeat',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_in_menu' => 'boolean',
        'published_at' => 'datetime',
    ];

    /** Pages are looked up by slug everywhere (routes, links) instead of numeric id. */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::saved(fn() => \App\Support\SiteNavigation::forgetCache());
        static::deleted(fn() => \App\Support\SiteNavigation::forgetCache());
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('menu_order');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('sort_order');
    }

    /** Only the sections that should currently be visible on the front end. */
    public function activeSections(): HasMany
    {
        return $this->sections()->where('is_active', true);
    }

    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeInMainMenu(Builder $query): Builder
    {
        return $query->where('show_in_menu', true)->orderBy('menu_order');
    }

    /**
     * The public-facing URL for this page, based on its type. Centralising this
     * here means every Blade view and Filament resource links consistently.
     */
    public function url(): string
    {
        return match ($this->type) {
            self::TYPE_SERVICE_AREA => route('service-areas.show', $this->slug),
            self::TYPE_BLOG_POST => route('blog.show', $this->slug),
            default => $this->slug === 'home' ? route('home') : route('pages.show', $this->slug),
        };
    }

    /** Falls back to the excerpt when no dedicated meta description was set. */
    public function metaDescription(): ?string
    {
        return $this->meta_description ?: $this->excerpt;
    }

    /** True when this page defines its own background instead of using the sitewide default. */
    public function hasCustomBackground(): bool
    {
        return in_array($this->background_type, ['color', 'image', 'video'], true);
    }

    public function isVideoBackground(): bool
    {
        return $this->background_type === 'video';
    }

    public function backgroundVideoUrl(): ?string
    {
        return $this->background_video ? Placeholder::resolve($this->background_video) : null;
    }

    /** Inline style for a 'color' or 'image' page background; null otherwise (incl. video, handled via <video>). */
    public function backgroundStyle(): ?string
    {
        if ($this->background_type === 'color') {
            return 'background-color: ' . ($this->background_color ?: '#ffffff') . ';';
        }

        if ($this->background_type === 'image' && $this->background_image) {
            $size = match ($this->background_size) {
                'contain' => 'contain',
                'fill' => '100% 100%',
                'original' => 'auto auto',
                'fit-width' => '100% auto',
                'fit-height' => 'auto 100%',
                default => 'cover',
            };
            $position = str_replace('-', ' ', $this->background_position ?: 'center');
            $repeat = array_key_exists($this->background_repeat, Section::BACKGROUND_REPEATS)
                ? $this->background_repeat
                : 'no-repeat';

            return "background-image: url('" . Placeholder::resolve($this->background_image, $this->title, 1920, 1080)
                . "'); background-size: {$size}; background-position: {$position}; background-repeat: {$repeat}; background-attachment: fixed;";
        }

        return null;
    }

    /** 0-100 "darkness" overlay (keeps content readable over busy images/video) as a 0-1 CSS opacity. */
    public function backgroundOverlayOpacity(): float
    {
        return max(0, min(100, $this->background_overlay ?? 0)) / 100;
    }
}
