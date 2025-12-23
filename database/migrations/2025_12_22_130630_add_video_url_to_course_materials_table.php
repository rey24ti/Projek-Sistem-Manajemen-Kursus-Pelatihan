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
        Schema::table('course_materials', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('file_path')->comment('Video URL (YouTube, Vimeo, etc)');
            $table->enum('material_type', ['file', 'video', 'link'])->default('file')->after('video_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_materials', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'material_type']);
        });
    }
};
