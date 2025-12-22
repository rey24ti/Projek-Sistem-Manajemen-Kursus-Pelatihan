<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Staff
        $staff1 = User::create([
            'name' => 'Trainer 1',
            'email' => 'staff1@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        $staff2 = User::create([
            'name' => 'Trainer 2',
            'email' => 'staff2@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Create Guest Users
        User::create([
            'name' => 'Peserta 1',
            'email' => 'guest1@example.com',
            'password' => Hash::make('password'),
            'role' => 'guest',
        ]);

        User::create([
            'name' => 'Peserta 2',
            'email' => 'guest2@example.com',
            'password' => Hash::make('password'),
            'role' => 'guest',
        ]);

        // Create Categories
        $category1 = Category::create([
            'name' => 'Teknologi Informasi',
            'description' => 'Kursus tentang teknologi informasi dan komputer',
        ]);

        $category2 = Category::create([
            'name' => 'Bahasa',
            'description' => 'Kursus bahasa asing dan komunikasi',
        ]);

        $category3 = Category::create([
            'name' => 'Bisnis',
            'description' => 'Kursus tentang bisnis dan manajemen',
        ]);

        // Create Courses
        Course::create([
            'title' => 'Laravel Framework untuk Pemula',
            'description' => 'Pelajari dasar-dasar Laravel framework untuk pengembangan web modern',
            'category_id' => $category1->id,
            'trainer_id' => $staff1->id,
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(37),
            'max_participants' => 20,
            'status' => 'open',
            'price' => 500000,
        ]);

        Course::create([
            'title' => 'Bahasa Inggris untuk Bisnis',
            'description' => 'Tingkatkan kemampuan bahasa Inggris Anda untuk keperluan bisnis',
            'category_id' => $category2->id,
            'trainer_id' => $staff2->id,
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(40),
            'max_participants' => 15,
            'status' => 'open',
            'price' => 750000,
        ]);

        Course::create([
            'title' => 'Manajemen Proyek Profesional',
            'description' => 'Pelajari teknik manajemen proyek yang efektif dan efisien',
            'category_id' => $category3->id,
            'trainer_id' => $staff1->id,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(35),
            'max_participants' => 25,
            'status' => 'ongoing',
            'price' => 1000000,
        ]);

        Course::create([
            'title' => 'React.js untuk Frontend Development',
            'description' => 'Kuasai React.js untuk membangun aplikasi web yang interaktif',
            'category_id' => $category1->id,
            'trainer_id' => $staff2->id,
            'start_date' => now()->addDays(14),
            'end_date' => now()->addDays(44),
            'max_participants' => 18,
            'status' => 'open',
            'price' => 600000,
        ]);
    }
}
