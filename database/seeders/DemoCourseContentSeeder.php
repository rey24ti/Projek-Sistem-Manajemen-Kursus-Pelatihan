<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DemoCourseContentSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::query()->get();
        if ($courses->isEmpty()) {
            $this->command?->warn('Tidak ada course. Jalankan seeder course dulu.');
            return;
        }

        foreach ($courses as $course) {
            $this->seedMaterialsForCourse($course);
            $this->seedQuizForCourse($course);
        }

        $this->command?->info('Demo materi & kuis berhasil dibuat untuk semua course.');
    }

    private function seedMaterialsForCourse(Course $course): void
    {
        $slug = Str::slug($course->title);
        $baseDir = "materials/demo/{$course->id}-{$slug}";

        $materials = [
            [
                'order' => 1,
                'title' => 'Materi 1: Pendahuluan & Tujuan Pembelajaran',
                'description' => 'Ringkasan tujuan, hasil belajar, dan alur kursus.',
                'file_name' => '01-pendahuluan.txt',
                'content' => $this->materialText($course, 1),
            ],
            [
                'order' => 2,
                'title' => 'Materi 2: Konsep Inti & Praktik',
                'description' => 'Penjelasan konsep inti disertai latihan singkat.',
                'file_name' => '02-konsep-inti.txt',
                'content' => $this->materialText($course, 2),
            ],
            [
                'order' => 3,
                'title' => 'Materi 3: Studi Kasus & Rangkuman',
                'description' => 'Contoh studi kasus sederhana + rangkuman poin penting.',
                'file_name' => '03-studi-kasus.txt',
                'content' => $this->materialText($course, 3),
            ],
        ];

        foreach ($materials as $m) {
            $relativePath = $baseDir . '/' . $m['file_name'];

            Storage::disk('public')->put($relativePath, $m['content']);

            $size = Storage::disk('public')->size($relativePath);

            CourseMaterial::updateOrCreate(
                [
                    'course_id' => $course->id,
                    'order' => $m['order'],
                ],
                [
                    'title' => $m['title'],
                    'description' => $m['description'],
                    'material_type' => 'file',
                    'file_path' => $relativePath,
                    'file_name' => $m['file_name'],
                    'file_type' => 'text/plain',
                    'file_size' => $size,
                    'video_url' => null,
                ]
            );
        }
    }

    private function seedQuizForCourse(Course $course): void
    {
        $title = 'Kuis 1: Evaluasi Dasar';

        $questions = $this->quizQuestions($course);

        Quiz::updateOrCreate(
            [
                'course_id' => $course->id,
                'order' => 1,
            ],
            [
                'title' => $title,
                'description' => 'Kuis singkat untuk menguji pemahaman materi dasar.',
                'questions' => $questions,
                'time_limit' => 30,
                'passing_score' => 70,
                'start_date' => $course->start_date?->copy()->startOfDay() ?? now()->subDay(),
                'end_date' => $course->end_date?->copy()->endOfDay() ?? now()->addDays(30),
            ]
        );
    }

    private function materialText(Course $course, int $part): string
    {
        $lines = [
            "Kursus: {$course->title}",
            "Bagian: {$part}",
            '',
            'Catatan:',
            '- Ini adalah materi contoh (dummy) untuk kebutuhan demo aplikasi.',
            '- Anda bisa mengganti isi dan file sesuai kebutuhan.',
            '',
            'Outline singkat:',
            '1) Tujuan pembelajaran',
            '2) Ringkasan konsep',
            '3) Latihan/praktik',
            '4) Rangkuman',
            '',
            'Tugas kecil:',
            '- Tuliskan 3 poin penting yang Anda pelajari dari sesi ini.',
        ];

        return implode("\n", $lines) . "\n";
    }

    /**
     * Struktur pertanyaan mengikuti kebutuhan SubmissionController:
     * - pertanyaan disimpan sebagai array
     * - setiap item minimal punya 'question', 'options', 'correct_answer'
     * - jawaban user dibandingkan dengan correct_answer
     */
    private function quizQuestions(Course $course): array
    {
        $t = Str::lower($course->title);

        if (Str::contains($t, 'laravel')) {
            return [
                [
                    'question' => 'Perintah untuk membuat controller baru di Laravel adalah?',
                    'options' => ['php artisan make:controller', 'php artisan make:model', 'php artisan make:migration', 'php artisan make:view'],
                    'correct_answer' => 'php artisan make:controller',
                ],
                [
                    'question' => 'Folder default untuk route web ada di?',
                    'options' => ['routes/web.php', 'app/Http/routes.php', 'config/routes.php', 'public/routes.php'],
                    'correct_answer' => 'routes/web.php',
                ],
                [
                    'question' => 'Eloquent digunakan untuk?',
                    'options' => ['ORM/akses database via model', 'Menjalankan queue', 'Membuat tampilan Blade', 'Mengatur session'],
                    'correct_answer' => 'ORM/akses database via model',
                ],
                [
                    'question' => 'Blade adalah?',
                    'options' => ['Template engine Laravel', 'Database engine', 'Web server', 'Testing framework'],
                    'correct_answer' => 'Template engine Laravel',
                ],
                [
                    'question' => 'Fungsi middleware paling umum adalah?',
                    'options' => ['Filter/validasi request sebelum ke controller', 'Membuat tabel database', 'Membuat asset frontend', 'Mengirim email massal'],
                    'correct_answer' => 'Filter/validasi request sebelum ke controller',
                ],
            ];
        }

        if (Str::contains($t, 'react')) {
            return [
                [
                    'question' => 'React terutama digunakan untuk membangun?',
                    'options' => ['UI (User Interface)', 'Database', 'Web server', 'Compiler'],
                    'correct_answer' => 'UI (User Interface)',
                ],
                [
                    'question' => 'Komponen fungsional React biasanya mengembalikan?',
                    'options' => ['JSX', 'SQL', 'CSS saja', 'File PDF'],
                    'correct_answer' => 'JSX',
                ],
                [
                    'question' => 'Hook untuk state lokal pada komponen fungsional adalah?',
                    'options' => ['useState', 'useClass', 'useStore', 'useModel'],
                    'correct_answer' => 'useState',
                ],
                [
                    'question' => 'Props digunakan untuk?',
                    'options' => ['Mengirim data dari parent ke child', 'Menyimpan file di server', 'Mengatur routing di backend', 'Membuat tabel database'],
                    'correct_answer' => 'Mengirim data dari parent ke child',
                ],
                [
                    'question' => 'Virtual DOM membantu React untuk?',
                    'options' => ['Optimasi update tampilan', 'Meng-enkripsi database', 'Menjalankan cron job', 'Mengganti web server'],
                    'correct_answer' => 'Optimasi update tampilan',
                ],
            ];
        }

        if (Str::contains($t, 'bahasa inggris')) {
            return [
                [
                    'question' => 'Kalimat pembuka email bisnis yang paling umum adalah?',
                    'options' => ['Dear Sir/Madam,', 'Hey bro,', 'Yo!', 'Sup?'],
                    'correct_answer' => 'Dear Sir/Madam,',
                ],
                [
                    'question' => 'Arti "meeting" dalam konteks bisnis adalah?',
                    'options' => ['Rapat', 'Liburan', 'Makan siang', 'Belanja'],
                    'correct_answer' => 'Rapat',
                ],
                [
                    'question' => 'Kalimat yang tepat untuk mengonfirmasi jadwal adalah?',
                    'options' => ['Could you confirm the schedule?', 'You must schedule now!', 'Confirm it, ok?', 'Schedule!'],
                    'correct_answer' => 'Could you confirm the schedule?',
                ],
                [
                    'question' => '"Invoice" berarti?',
                    'options' => ['Faktur/tagihan', 'Kartu nama', 'Proposal', 'Catatan rapat'],
                    'correct_answer' => 'Faktur/tagihan',
                ],
                [
                    'question' => 'Cara sopan menutup email adalah?',
                    'options' => ['Best regards,', 'Bye.', 'Ok.', 'See ya.'],
                    'correct_answer' => 'Best regards,',
                ],
            ];
        }

        // Default (mis. Manajemen Proyek)
        return [
            [
                'question' => 'Tujuan utama manajemen proyek adalah?',
                'options' => ['Mencapai target scope, waktu, biaya, dan kualitas', 'Menambah kerja tanpa batas', 'Menghapus semua risiko', 'Menghindari komunikasi tim'],
                'correct_answer' => 'Mencapai target scope, waktu, biaya, dan kualitas',
            ],
            [
                'question' => 'Dokumen yang umum digunakan untuk mendefinisikan ruang lingkup (scope) adalah?',
                'options' => ['Scope statement', 'Invoice', 'Source code', 'Poster marketing'],
                'correct_answer' => 'Scope statement',
            ],
            [
                'question' => 'Apa itu milestone?',
                'options' => ['Titik capaian penting pada timeline', 'Nama aplikasi', 'Jenis database', 'Bahasa pemrograman'],
                'correct_answer' => 'Titik capaian penting pada timeline',
            ],
            [
                'question' => 'Risiko proyek sebaiknya?',
                'options' => ['Diidentifikasi dan dimitigasi sejak awal', 'Diabaikan', 'Ditunda sampai akhir', 'Disembunyikan dari stakeholder'],
                'correct_answer' => 'Diidentifikasi dan dimitigasi sejak awal',
            ],
            [
                'question' => 'Komunikasi proyek yang baik biasanya bersifat?',
                'options' => ['Terencana, rutin, dan terdokumentasi', 'Acak dan spontan', 'Rahasia untuk semua pihak', 'Hanya via chat informal'],
                'correct_answer' => 'Terencana, rutin, dan terdokumentasi',
            ],
        ];
    }
}
