<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Allow guest (unauthenticated) users to access payment upload (create/store)
        $this->middleware('auth')->except(['create', 'store']);
    }

    // For students to upload payment proof (allow guests)
    public function create(Enrollment $enrollment)
    {
        // If the payment already verified, block further uploads
        if ($enrollment->payment_status === 'verified') {
            return back()->with('info', 'Pembayaran sudah terverifikasi.');
        }

        $course = $enrollment->course;

        // If user is logged in, ensure they own the enrollment
        if (Auth::check() && $enrollment->user_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pendaftaran ini.');
        }

        return view('guest.payments.create', compact('enrollment', 'course'));
    }

    public function store(Request $request, Enrollment $enrollment)
    {
        // If user is logged in, ensure they own the enrollment
        if (Auth::check()) {
            if ($enrollment->user_id != Auth::id()) {
                abort(403);
            }
        } else {
            // Guest upload: require owner_email to match enrollment owner's email
            $ownerEmail = $request->input('owner_email');
            if (!$ownerEmail || $ownerEmail !== $enrollment->user->email) {
                return back()->withErrors(['owner_email' => 'Email tidak cocok dengan pendaftar.'])->withInput();
            }
        }

        $validator = Validator::make($request->all(), [
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'payment_method' => 'required|in:transfer,cash,other',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = $request->file('proof');
        $filePath = $file->store('payments', 'public');

        Payment::create([
            'enrollment_id' => $enrollment->id,
            'amount' => $enrollment->course->price,
            'payment_method' => $request->payment_method,
            'proof_path' => $filePath,
            'proof_name' => $file->getClientOriginalName(),
            'notes' => $request->notes,
            'status' => 'pending',
            'paid_at' => now(),
        ]);

        // Update enrollment payment status
        $enrollment->update(['payment_status' => 'pending']);

        return redirect()->route('enrollments.index')
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi.');
    }

    // View payment proof (for students)
    public function show(Payment $payment)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        if (
            $payment->enrollment->user_id != $user->id
            && !$user->isAdmin()
            && !($user->isStaff() && $payment->enrollment->course->trainer_id == $user->id)
        ) {
            abort(403);
        }

        $absolutePath = Storage::disk('public')->path($payment->proof_path);

        return response()->download($absolutePath, $payment->proof_name);
    }
}
