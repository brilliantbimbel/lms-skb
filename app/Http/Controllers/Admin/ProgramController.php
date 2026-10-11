<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::withCount(['classrooms'])->get();
        $classrooms = Classroom::with(['program', 'tutor'])->withCount('students')->latest()->get();
        $tutors = User::where('role', 'guru')->get();

        return view('admin.programs.index', compact('programs', 'classrooms', 'tutors'));
    }

    public function storeClassroom(Request $request)
    {
        $request->validate([
            'program_id'    => 'required|exists:programs,id',
            'tutor_id'      => 'nullable|exists:users,id',
            'name'          => 'required|string|max:255',
            'academic_year' => 'required|string|max:20',
        ]);

        Classroom::create([
            'program_id'    => $request->program_id,
            'tutor_id'      => $request->tutor_id,
            'name'          => $request->name,
            'academic_year' => $request->academic_year,
        ]);

        return redirect()->back()->with('success', 'Kelas / Rombel berhasil ditambahkan!');
    }

    public function destroyClassroom(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->back()->with('success', 'Kelas / Rombel berhasil dihapus!');
    }
}
