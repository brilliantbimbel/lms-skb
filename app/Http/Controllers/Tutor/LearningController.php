<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Material;
use App\Models\Subject;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LearningController extends Controller
{
    // --- MATERI ---

    public function indexMaterials()
    {
        $tutorId = auth()->id();
        $subjects = Subject::where('tutor_id', $tutorId)->get();
        $classrooms = Classroom::with('program')->get();

        $materials = Material::with(['subject', 'classroom.program'])
            ->where('user_id', $tutorId)
            ->latest()
            ->get();

        return view('tutor.materials.index', compact('materials', 'subjects', 'classrooms'));
    }

    public function storeMaterial(Request $request)
    {
        $request->validate([
            'subject_id'   => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'title'        => 'required|string|max:255',
            'content'      => 'nullable|string',
            'video_url'    => 'nullable|url',
            'file'         => 'nullable|file|mimes:pdf,docx,doc,ppt,pptx,zip,rar|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materials', 'public');
        }

        Material::create([
            'subject_id'   => $request->subject_id,
            'classroom_id' => $request->classroom_id,
            'user_id'      => auth()->id(),
            'title'        => $request->title,
            'content'      => $request->content,
            'video_url'    => $request->video_url,
            'file_path'    => $filePath,
        ]);

        return redirect()->back()->with('success', 'Materi pembelajaran berhasil ditambahkan!');
    }

    public function destroyMaterial(Material $material)
    {
        if ($material->user_id !== auth()->id()) {
            abort(403);
        }

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->back()->with('success', 'Materi berhasil dihapus!');
    }

    // --- TUGAS ---

    public function indexAssignments()
    {
        $tutorId = auth()->id();
        $subjects = Subject::where('tutor_id', $tutorId)->get();
        $classrooms = Classroom::with('program')->get();

        $assignments = Assignment::with(['subject', 'classroom.program'])
            ->withCount('submissions')
            ->where('user_id', $tutorId)
            ->latest()
            ->get();

        return view('tutor.assignments.index', compact('assignments', 'subjects', 'classrooms'));
    }

    public function storeAssignment(Request $request)
    {
        $request->validate([
            'subject_id'   => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'due_date'     => 'required|date',
            'file'         => 'nullable|file|mimes:pdf,docx,doc,zip,rar|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create([
            'subject_id'   => $request->subject_id,
            'classroom_id' => $request->classroom_id,
            'user_id'      => auth()->id(),
            'title'        => $request->title,
            'description'  => $request->description,
            'file_path'    => $filePath,
            'due_date'     => $request->due_date,
        ]);

        return redirect()->back()->with('success', 'Tugas baru berhasil dibuat!');
    }

    public function destroyAssignment(Assignment $assignment)
    {
        if ($assignment->user_id !== auth()->id()) {
            abort(403);
        }

        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus!');
    }

    public function showSubmissions(Assignment $assignment)
    {
        if ($assignment->user_id !== auth()->id()) {
            abort(403);
        }

        $submissions = Submission::with('student')
            ->where('assignment_id', $assignment->id)
            ->latest()
            ->get();

        return view('tutor.assignments.submissions', compact('assignment', 'submissions'));
    }

    public function gradeSubmission(Request $request, Submission $submission)
    {
        $request->validate([
            'score'    => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'score'    => $request->score,
            'feedback' => $request->feedback,
        ]);

        return redirect()->back()->with('success', 'Nilai tugas berhasil disimpan!');
    }
}
