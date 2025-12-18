<?php

namespace App\Http\Controllers;

use App\Models\CourseMaterial;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseMaterialController extends Controller
{
    public function index(Course $course)
    {
        $materials = $course->materials()->orderBy('order')->get();
        
        $view = auth()->user()->isAdmin() ? 'admin.materials.index' : 'staff.materials.index';
        
        return view($view, compact('course', 'materials'));
    }

    public function create(Course $course)
    {
        $view = auth()->user()->isAdmin() ? 'admin.materials.create' : 'staff.materials.create';
        return view($view, compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');
        $filePath = $file->store('materials', 'public');

        CourseMaterial::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('materials.index', $course)
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function show(CourseMaterial $material)
    {
        $material->load('course');
        
        // Check if user has access (enrolled or is trainer/admin)
        $hasAccess = false;
        if (auth()->user()->isAdmin() || auth()->user()->isStaff()) {
            $hasAccess = true;
        } else {
            $hasAccess = $material->course->enrollments()
                ->where('user_id', auth()->id())
                ->where('status', 'approved')
                ->exists();
        }

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke materi ini.');
        }

        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    public function edit(CourseMaterial $material)
    {
        $material->load('course');
        $view = auth()->user()->isAdmin() ? 'admin.materials.edit' : 'staff.materials.edit';
        return view($view, compact('material'));
    }

    public function update(Request $request, CourseMaterial $material)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['title', 'description', 'order']);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $data['file_path'] = $file->store('materials', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_type'] = $file->getClientMimeType();
            $data['file_size'] = $file->getSize();
        }

        $material->update($data);

        return redirect()->route('materials.index', $material->course)
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(CourseMaterial $material)
    {
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $course = $material->course;
        $material->delete();

        return redirect()->route('materials.index', $course)
            ->with('success', 'Materi berhasil dihapus.');
    }
}
