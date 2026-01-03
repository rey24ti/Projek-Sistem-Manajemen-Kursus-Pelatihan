<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('courses')) {
            return;
        }

        $driver = DB::getDriverName();

        // MySQL: alter enum directly
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `courses` MODIFY `status` ENUM('draft','pending','open','ongoing','completed','cancelled') NOT NULL DEFAULT 'draft'");
            return;
        }

        // SQLite: rebuild table to update CHECK constraint for enum
        if ($driver === 'sqlite') {
            Schema::disableForeignKeyConstraints();

            // Rename old table
            Schema::rename('courses', 'courses_old');

            // Recreate courses table with pending status
            Schema::create('courses', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');
                $table->date('start_date');
                $table->date('end_date');
                $table->integer('max_participants')->default(0);
                $table->enum('status', ['draft', 'pending', 'open', 'ongoing', 'completed', 'cancelled'])->default('draft');
                $table->decimal('price', 10, 2)->default(0);
                $table->string('image')->nullable();
                $table->unsignedTinyInteger('passing_score')->default(70);
                $table->timestamps();
            });

            // Copy data
            $columns = [
                'id',
                'title',
                'description',
                'category_id',
                'trainer_id',
                'start_date',
                'end_date',
                'max_participants',
                'status',
                'price',
                'image',
                'passing_score',
                'created_at',
                'updated_at',
            ];

            $cols = implode(', ', array_map(fn ($c) => '"' . $c . '"', $columns));
            DB::statement("INSERT INTO \"courses\" ($cols) SELECT $cols FROM \"courses_old\"");

            Schema::drop('courses_old');
            Schema::enableForeignKeyConstraints();
            return;
        }

        // Fallback: do nothing for other drivers
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('courses')) {
            return;
        }

        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            // Ensure no pending values before removing enum value
            DB::statement("UPDATE `courses` SET `status`='draft' WHERE `status`='pending'");
            DB::statement("ALTER TABLE `courses` MODIFY `status` ENUM('draft','open','ongoing','completed','cancelled') NOT NULL DEFAULT 'draft'");
            return;
        }

        if ($driver === 'sqlite') {
            Schema::disableForeignKeyConstraints();

            Schema::rename('courses', 'courses_new');

            Schema::create('courses', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');
                $table->date('start_date');
                $table->date('end_date');
                $table->integer('max_participants')->default(0);
                $table->enum('status', ['draft', 'open', 'ongoing', 'completed', 'cancelled'])->default('draft');
                $table->decimal('price', 10, 2)->default(0);
                $table->string('image')->nullable();
                $table->unsignedTinyInteger('passing_score')->default(70);
                $table->timestamps();
            });

            $columns = [
                'id',
                'title',
                'description',
                'category_id',
                'trainer_id',
                'start_date',
                'end_date',
                'max_participants',
                // map pending -> draft
                'status',
                'price',
                'image',
                'passing_score',
                'created_at',
                'updated_at',
            ];

            $cols = implode(', ', array_map(fn ($c) => '"' . $c . '"', $columns));
            DB::statement("INSERT INTO \"courses\" ($cols) SELECT $cols FROM \"courses_new\"");
            DB::statement("UPDATE \"courses\" SET \"status\"='draft' WHERE \"status\"='pending'");

            Schema::drop('courses_new');
            Schema::enableForeignKeyConstraints();
            return;
        }
    }
};
