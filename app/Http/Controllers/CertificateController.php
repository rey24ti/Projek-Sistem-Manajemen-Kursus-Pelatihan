<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // View certificate
    public function show(Enrollment $enrollment)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        // Check if user owns this enrollment or is admin/staff
        if (
            $enrollment->user_id != Auth::id()
            && !$user->isAdmin()
            && !($user->isStaff() && $enrollment->course->trainer_id == Auth::id())
        ) {
            abort(403);
        }

        // Check if certificate exists
        if (!$enrollment->certificate_path || !Storage::disk('public')->exists($enrollment->certificate_path)) {
            // Generate certificate if not exists but user passed
            if ($enrollment->is_passed && $enrollment->status === 'completed') {
                $this->generateCertificate($enrollment);
            } else {
                abort(404, 'Sertifikat belum tersedia. Pastikan Anda telah lulus kursus.');
            }
        }

        $certificatePath = $enrollment->certificate_path;
        $fileName = 'Sertifikat_' . $enrollment->user->name . '_' . $enrollment->course->title . '.pdf';

        $absolutePath = Storage::disk('public')->path($certificatePath);
        return response()->download($absolutePath, $fileName);
    }

    // Generate certificate (simple text-based, bisa dikembangkan dengan PDF library)
    protected function generateCertificate(Enrollment $enrollment)
    {
        // Simple certificate generation (text file)
        // In production, you should use a PDF library like DomPDF or TCPDF
        
        $certificateNumber = 'CERT-' . strtoupper(uniqid());
        $content = "SERTIFIKAT KELULUSAN\n\n";
        $content .= "Nomor: {$certificateNumber}\n\n";
        $content .= "Dengan ini menyatakan bahwa:\n\n";
        $content .= "Nama: {$enrollment->user->name}\n";
        $content .= "Email: {$enrollment->user->email}\n\n";
        $content .= "Telah menyelesaikan dan lulus pada:\n\n";
        $content .= "Kursus: {$enrollment->course->title}\n";
        $content .= "Nilai: {$enrollment->final_score}\n";
        $content .= "Tanggal Selesai: {$enrollment->completion_date->format('d F Y')}\n\n";
        $content .= "Sertifikat ini diterbitkan pada: " . now()->format('d F Y') . "\n";

        $certificatePath = 'certificates/' . $certificateNumber . '.txt';
        Storage::disk('public')->put($certificatePath, $content);

        $enrollment->update([
            'certificate_path' => $certificatePath,
            'certificate_number' => $certificateNumber,
            'certificate_issued_at' => now(),
        ]);
    }
}
