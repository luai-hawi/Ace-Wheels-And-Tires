<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Single place that decides what image URL to render for any "image slot" on
 * the site. Every view/component asks Placeholder::resolve() instead of
 * building URLs itself, so swapping the placeholder strategy (or wiring in
 * real uploads later) only ever needs to change this one file.
 */
class Placeholder
{
    /**
     * @param  string|null  $path  Path/URL stored on the model (e.g. uploaded via the admin).
     * @param  string|null  $label  Text shown on the placeholder when there is no real image yet.
     */
    public static function resolve(?string $path, ?string $label = null, int $width = 800, int $height = 600): string
    {
        if (filled($path)) {
            return str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
                ? $path
                : Storage::disk('public')->url($path);
        }

        return static::image($label, $width, $height);
    }

    /** Builds a branded placeholder image URL for a given label/size. */
    public static function image(?string $label, int $width = 800, int $height = 600): string
    {
        $text = trim((string) $label) !== '' ? $label : 'Ace Wheels & Tires';

        return sprintf(
            'https://placehold.co/%dx%d/242424/f4f4f4?font=montserrat&text=%s',
            $width,
            $height,
            rawurlencode($text)
        );
    }
}
