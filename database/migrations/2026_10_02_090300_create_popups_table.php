<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Admin-manageable popups/widgets: big center "ad" modals (as many as wanted)
        // plus small side-of-screen quick contact widgets — one flexible table for both.
        Schema::create('popups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('modal'); // modal | side_widget
            $table->boolean('is_enabled')->default(false);

            $table->string('heading')->nullable();
            $table->text('body')->nullable();
            $table->string('image')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();

            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('position')->default('right'); // side_widget: left | right

            $table->string('trigger')->default('delay'); // on_load | delay | exit_intent | scroll_percent
            $table->unsignedInteger('trigger_value')->default(4); // seconds or percent depending on trigger
            $table->string('frequency')->default('once_per_session'); // every_visit | once_per_session | once_per_day | once_ever

            // Empty = show on every page. Otherwise a JSON array of page slugs.
            $table->json('show_on')->nullable();

            $table->longText('custom_html')->nullable();
            $table->string('custom_html_position')->default('after');

            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('popups');
    }
};
