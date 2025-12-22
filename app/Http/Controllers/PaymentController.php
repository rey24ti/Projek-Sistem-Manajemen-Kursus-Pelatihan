<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // For students to upload payment proof
    public function create(Enrollment $enrollment)
    {
        // Check if user owns this enrollment
        if ($enrollment->user_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pendaftaran ini.');
        }

        // Check if payment already verified
        if ($enrollment->payment_status === 'verified') {
            return back()->with('info', 'Pembayaran sudah terverifikasi.');
        }

        $course = $enrollment->course;
        return view('guest.payments.create', compact('enrollment', 'course'));
    }

    public function store(Request $request, Enrollment $enrollment)
    {
        // Check if user owns this enrollment
        if ($enrollment->user_id != auth()->id()) {
            abort(403);
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
        if ($payment->enrollment->user_id != auth()->id() && !auth()->user()->isAdmin() && !(auth()->user()->isStaff() && $payment->enrollment->course->trainer_id == auth()->id())) {
            abort(403);
        }

        return Storage::disk('public')->download($payment->proof_path, $payment->proof_name);
    }
}
