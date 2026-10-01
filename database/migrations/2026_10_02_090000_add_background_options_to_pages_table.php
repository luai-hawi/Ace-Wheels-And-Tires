<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Lets an admin override the whole-page background per page (color/image/video),
            // falling back to the sitewide default (Settings) when left as 'default'.
            $table->string('background_type')->default('default')->after('icon');
            $table->string('background_color')->nullable()->after('background_type');
            $table->string('background_image')->nullable()->after('background_color');
            $table->string('background_video')->nullable()->after('background_image');
            $table->unsignedTinyInteger('background_overlay')->default(0)->after('background_video');
            $table->string('background_size')->default('cover')->after('background_overlay');
            $table->string('background_position')->default('center')->after('background_size');
            $table->string('background_repeat')->default('no-repeat')->after('background_position');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'background_type',
                'background_color',
                'background_image',
                'background_video',
                'background_overlay',
                'background_size',
                'background_position',
                'background_repeat',
            ]);
        });
    }
};
