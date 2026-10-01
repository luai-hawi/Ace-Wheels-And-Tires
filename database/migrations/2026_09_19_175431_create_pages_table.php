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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            // Every piece of content on the site (the homepage, About Us, each service,
            // each service area, each blog post) is a "page" of one of these types.
            // Keeping them in a single table means the admin only has to learn one
            // interface (Pages + Sections) to manage the entire site.
            $table->enum('type', ['page', 'service', 'service_area', 'blog_post'])->default('page');

            $table->string('slug')->unique();
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('icon')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->boolean('is_published')->default(true);
            $table->boolean('show_in_menu')->default(false);
            $table->unsignedInteger('menu_order')->default(0);
            $table->timestamp('published_at')->nullable();

            // Self-referencing parent lets "Our Services" group its service pages,
            // and "Areas We Serve" group its city pages, without extra tables.
            $table->foreignId('parent_id')->nullable()->constrained('pages')->nullOnDelete();

            $table->timestamps();

            $table->index(['type', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
