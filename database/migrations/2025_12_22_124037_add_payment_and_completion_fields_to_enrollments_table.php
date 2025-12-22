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
            $table->enum('payment_status', ['pending', 'verified', 'rejected'])->default('pending')->after('status')->comment('Status pembayaran');
            $table->decimal('final_score', 5, 2)->nullable()->after('progress')->comment('Nilai akhir peserta (0-100)');
            $table->date('completion_date')->nullable()->after('final_score')->comment('Tanggal selesai kursus');
            $table->boolean('is_passed')->default(false)->after('completion_date')->comment('Apakah peserta lulus atau tidak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'final_score', 'completion_date', 'is_passed']);
        });
    }
};
