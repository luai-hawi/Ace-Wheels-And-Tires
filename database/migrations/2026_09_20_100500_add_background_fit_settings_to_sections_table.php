<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->string('background_size')->default('cover');
            $table->string('background_position')->default('center');
            $table->string('background_repeat')->default('no-repeat');
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn([
                'background_size',
                'background_position',
                'background_repeat',
            ]);
        });
    }
};
