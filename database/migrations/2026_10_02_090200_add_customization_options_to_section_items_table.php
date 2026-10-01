<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('section_items', function (Blueprint $table) {
            $table->longText('custom_html')->nullable()->after('animation');
            $table->string('custom_html_position')->default('after')->after('custom_html');
            $table->json('text_styles')->nullable()->after('custom_html_position');
        });
    }

    public function down(): void
    {
        Schema::table('section_items', function (Blueprint $table) {
            $table->dropColumn(['custom_html', 'custom_html_position', 'text_styles']);
        });
    }
};
