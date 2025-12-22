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
        Schema::table('enrollments', function (Blueprint $table) {
            $table->string('certificate_path')->nullable()->after('is_passed')->comment('Path to certificate file');
            $table->string('certificate_number')->nullable()->after('certificate_path')->comment('Certificate number');
            $table->date('certificate_issued_at')->nullable()->after('certificate_number')->comment('Certificate issue date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['certificate_path', 'certificate_number', 'certificate_issued_at']);
        });
    }
};
