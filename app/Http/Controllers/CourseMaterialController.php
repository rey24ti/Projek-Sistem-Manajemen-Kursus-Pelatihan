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
        
<<<<<<< HEAD
        $view = auth()->user()->isAdmin() ? 'admin.materials.index' : 'staff.materials.index';
        
        return view($view, compact('course', 'materials'));
=======
        // Check if user is enrolled student (guest role)
        $isEnrolled = false;
        if (auth()->check() && auth()->user()->isGuest()) {
            $isEnrolled = $course->enrollments()
                ->where('user_id', auth()->id())
                ->where('status', 'approved')
                ->exists();
        }
        
        // Determine view based on role
        if (auth()->user()->isAdmin()) {
            $view = 'admin.materials.index';
        } elseif (auth()->user()->isStaff()) {
            $view = 'staff.materials.index';
        } elseif ($isEnrolled) {
            $view = 'guest.materials.index';
        } else {
            abort(403, 'Anda tidak memiliki akses ke materi kursus ini.');
        }
        
        return view($view, compact('course', 'materials', 'isEnrolled'));
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
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
<<<<<<< HEAD
            'file' => 'required|file|max:10240', // 10MB max
=======
            'material_type' => 'required|in:file,video,link',
            'file' => 'required_if:material_type,file|file|max:10240', // 10MB max
            'video_url' => 'required_if:material_type,video|nullable|url',
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

<<<<<<< HEAD
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
=======
        $data = [
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'material_type' => $request->material_type,
            'order' => $request->order ?? 0,
        ];

        if ($request->material_type == 'file' && $request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $file->store('materials', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_type'] = $file->getClientMimeType();
            $data['file_size'] = $file->getSize();
        } elseif ($request->material_type == 'video' && $request->video_url) {
            $data['video_url'] = $request->video_url;
        }

        CourseMaterial::create($data);
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f

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
<<<<<<< HEAD
            'file' => 'nullable|file|max:10240',
=======
            'material_type' => 'required|in:file,video,link',
            'file' => 'required_if:material_type,file|nullable|file|max:10240',
            'video_url' => 'required_if:material_type,video|nullable|url',
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

<<<<<<< HEAD
        $data = $request->only(['title', 'description', 'order']);

        if ($request->hasFile('file')) {
=======
        $data = $request->only(['title', 'description', 'material_type', 'order']);

        if ($request->material_type == 'file' && $request->hasFile('file')) {
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
            // Delete old file
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $data['file_path'] = $file->store('materials', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_type'] = $file->getClientMimeType();
            $data['file_size'] = $file->getSize();
<<<<<<< HEAD
=======
            $data['video_url'] = null;
        } elseif ($request->material_type == 'video' && $request->video_url) {
            // Delete old file if switching from file to video
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $data['video_url'] = $request->video_url;
            $data['file_path'] = null;
            $data['file_name'] = null;
            $data['file_type'] = null;
            $data['file_size'] = null;
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
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
