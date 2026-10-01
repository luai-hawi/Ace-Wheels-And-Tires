<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Key/value store for the small pieces of information repeated across the
 * whole site (phone number, address, hours, social links...). Editing a
 * setting once in the admin updates it everywhere it's used.
 */
class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected static function booted(): void
    {
        static::saved(fn() => Cache::forget('settings.all'));
        static::deleted(fn() => Cache::forget('settings.all'));
    }

    /** All settings as a flat [key => value] array, cached for the request lifecycle. */
    public static function allCached(): array
    {
        return Cache::rememberForever('settings.all', fn() => static::pluck('value', 'key')->all());
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::allCached()[$key] ?? $default;
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
