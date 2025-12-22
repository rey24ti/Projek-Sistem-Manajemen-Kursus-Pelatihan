<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        // Tamu (belum login) langsung ke daftar kursus
        if (!auth()->check()) {
            return redirect()->route('courses.index');
        }

        $user = auth()->user();
        
        if ($user->isAdmin() || $user->isStaff()) {
            return redirect()->route('dashboard');
        }
        
        // User dengan role guest yang sudah login diarahkan ke daftar kursus
        return redirect()->route('courses.index');
    }
}
