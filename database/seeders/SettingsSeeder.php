<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Values copied straight from the original Ace Wheels and Tires site.
        $settings = [
            'company_name' => 'Ace Wheels and Tires',
            'tagline' => 'Fast, friendly tire & automotive service',
            'logo_path' => 'branding/logo.jpg',
            'phone' => '(318) 891-8173',
            'email' => 'yusef@acewheelsandtires.com',
            'address_line1' => '9025 Greenwood Rd',
            'address_city' => 'Greenwood',
            'address_state' => 'LA',
            'address_zip' => '71033',
            'hours_weekday' => 'Mon - Fri: 8:00 AM - 7:00 PM',
            'hours_saturday' => 'Sat: 8:00 AM - 6:00 PM',
            'facebook_url' => 'https://facebook.com/people/Ace-Wheels-and-Tires/100083284303417/',
            'google_maps_url' => 'https://maps.app.goo.gl/7bmPUjNXiJqBEH1G6',
            'google_reviews_url' => 'https://maps.app.goo.gl/7bmPUjNXiJqBEH1G6',
            'google_maps_embed_url' => 'https://www.google.com/maps/d/u/0/embed?mid=1uctROha2JIJQQC83Dd56yeuDEvXzXBc&ehbc=2E312F&noprof=1',
            'google_maps_location_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3244.3712942411394!2d-93.96205810000001!3d32.442420399999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8636dbe3e70a7941%3A0xcafedccdecebee76!2sAce%20Wheels%20and%20Tires!5e1!3m2!1sen!2sph',
            'snap_finance_url' => 'https://www.snapfinance.com/',
            'acima_finance_url' => 'https://www.acima.com/',

            // Sitewide default background, shown behind any page that doesn't set its own
            // override (Pages > a page > "Background" tab). Off by default so nothing changes
            // visually until an admin picks a color/image/video from Site Settings.
            'site_background_type' => 'none',
            'site_background_color' => '#f4f4f4',
            'site_background_image' => null,
            'site_background_video' => null,
            'site_background_overlay' => '0',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
