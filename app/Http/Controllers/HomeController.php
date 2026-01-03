<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        // Tamu (belum login) langsung ke daftar kursus
        if (!Auth::check()) {
            return redirect()->route('courses.index');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('courses.index');
        }
        
        if ($user->isAdmin() || $user->isStaff()) {
            return redirect()->route('dashboard');
        }
        
        // User dengan role guest yang sudah login diarahkan ke daftar kursus
        return redirect()->route('courses.index');
    }
}
