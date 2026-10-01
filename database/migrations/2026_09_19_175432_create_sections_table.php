<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();

            // The section "type" decides which Blade partial renders it
            // (see resources/views/sections/{type}.blade.php).
            $table->string('type')->default('richtext');

            $table->string('heading')->nullable();
            $table->string('subheading')->nullable();
            $table->longText('body')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();

            // Visual variety controls, so sections don't all look the same down the page.
            $table->string('background')->default('light');
            $table->string('background_image')->nullable();
            $table->string('layout')->nullable();
            $table->string('animation')->default('fade-up');

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            // Freeform, type-specific extras (e.g. a map embed URL, a video URL)
            // so we don't need a new column/migration for every new section type.
            $table->json('data')->nullable();

            $table->timestamps();

            $table->index(['page_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
