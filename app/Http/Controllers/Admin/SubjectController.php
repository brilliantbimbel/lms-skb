<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with(['program', 'tutor'])->latest()->get();
        $programs = Program::all();
        $tutors   = User::where('role', 'guru')->get();

        return view('admin.subjects.index', compact('subjects', 'programs', 'tutors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'        => 'required|string|max:50|unique:subjects,code',
            'name'        => 'required|string|max:255',
            'program_id'  => 'nullable|exists:programs,id',
            'tutor_id'    => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);

        Subject::create([
            'code'        => strtoupper($request->code),
            'name'        => $request->name,
            'program_id'  => $request->program_id,
            'tutor_id'    => $request->tutor_id,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Mata Pelajaran berhasil ditambahkan!');
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'code'        => ['required', 'string', 'max:50', Rule::unique('subjects')->ignore($subject->id)],
            'name'        => 'required|string|max:255',
            'program_id'  => 'nullable|exists:programs,id',
            'tutor_id'    => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);

        $subject->update([
            'code'        => strtoupper($request->code),
            'name'        => $request->name,
            'program_id'  => $request->program_id,
            'tutor_id'    => $request->tutor_id,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Mata Pelajaran berhasil diperbarui!');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->back()->with('success', 'Mata Pelajaran berhasil dihapus!');
    }
}
