<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            // 'custom' background uses background_color directly; 'video' uses background_video.
            $table->string('background_video')->nullable()->after('background_image');
            $table->string('background_color')->nullable()->after('background_video');
            $table->string('text_color')->nullable()->after('background_color');
            $table->unsignedTinyInteger('background_overlay')->default(65)->after('text_color');

            // Freeform HTML/CSS/Tailwind the admin can drop in without touching code.
            $table->longText('custom_html')->nullable()->after('data');
            $table->string('custom_html_position')->default('after')->after('custom_html');

            // Per text-part (heading/subheading/body) color/size/weight/alignment overrides.
            $table->json('text_styles')->nullable()->after('custom_html_position');
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn([
                'background_video',
                'background_color',
                'text_color',
                'background_overlay',
                'custom_html',
                'custom_html_position',
                'text_styles',
            ]);
        });
    }
};
