<?php

namespace Database\Seeders;

use App\Models\Popup;
use Illuminate\Database\Seeder;

class PopupsSeeder extends Seeder
{
    public function run(): void
    {
        Popup::updateOrCreate(
            ['name' => 'Special Offer'],
            [
                'type' => Popup::TYPE_MODAL,
                // Off until an admin uploads an image/edits the copy and enables it —
                // matches the previous Settings-driven popup's default behaviour.
                'is_enabled' => false,
                'heading' => 'Special Offer',
                'body' => 'Ask about our current tire and service specials when you visit!',
                'button_text' => 'Contact Us',
                'button_url' => '/contact',
                'trigger' => 'delay',
                'trigger_value' => 4,
                'frequency' => 'once_per_session',
                'sort_order' => 0,
            ]
        );

        Popup::updateOrCreate(
            ['name' => 'Quick Contact'],
            [
                'type' => Popup::TYPE_SIDE_WIDGET,
                'is_enabled' => true,
                'heading' => 'Need Help Fast?',
                'body' => "Call, text, or send us a message \u{2014} we usually reply within minutes.",
                'button_text' => 'Contact Us',
                'button_url' => '/contact',
                'position' => 'right',
                'trigger' => 'on_load',
                'trigger_value' => 0,
                'frequency' => 'every_visit',
                'sort_order' => 0,
            ]
        );
    }
}
