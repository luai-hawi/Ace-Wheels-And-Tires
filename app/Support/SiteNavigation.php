<?php

namespace App\Support;

use App\Models\Page;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Single place that builds the data used to render the main navigation,
 * footer links and mega-menu on every page. Cached briefly so we don't
 * re-run the same queries on every request while content is stable.
 */
class SiteNavigation
{
    private const CACHE_TTL_SECONDS = 300;

    /** Top-level pages flagged to appear directly in the main menu (Home, About Us, FAQs...). */
    public static function menuPages(): Collection
    {
        return Cache::remember(
            'nav.menu_pages',
            self::CACHE_TTL_SECONDS,
            fn() => Page::query()
                ->type(Page::TYPE_PAGE)
                ->published()
                ->inMainMenu()
                ->get()
        );
    }

    /** Every published service, for the "Our Services" mega menu and service grids. */
    public static function services(): Collection
    {
        return Cache::remember(
            'nav.services',
            self::CACHE_TTL_SECONDS,
            fn() => Page::query()
                ->type(Page::TYPE_SERVICE)
                ->published()
                ->orderBy('menu_order')
                ->get()
        );
    }

    /** Every published service area/city page, for "Areas We Serve". */
    public static function serviceAreas(): Collection
    {
        return Cache::remember(
            'nav.service_areas',
            self::CACHE_TTL_SECONDS,
            fn() => Page::query()
                ->type(Page::TYPE_SERVICE_AREA)
                ->published()
                ->orderBy('menu_order')
                ->get()
        );
    }

    public static function forgetCache(): void
    {
        Cache::forget('nav.menu_pages');
        Cache::forget('nav.services');
        Cache::forget('nav.service_areas');
    }
}
