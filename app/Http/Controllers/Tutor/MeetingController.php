<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\OnlineMeeting;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    // 1. Halaman Daftar Pertemuan Daring Tutor
    public function index()
    {
        $tutorId = auth()->id();
        $subjects = Subject::where('tutor_id', $tutorId)->get();
        $classrooms = Classroom::with('program')->get();

        $meetings = OnlineMeeting::with(['classroom.program', 'subject'])
            ->withCount('attendances')
            ->where('user_id', $tutorId)
            ->latest()
            ->get();

        return view('tutor.meetings.index', compact('meetings', 'subjects', 'classrooms'));
    }

    // 2. Simpan Pertemuan Daring Baru (Sematkan Link Meet)
    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id'   => 'required|exists:subjects,id',
            'title'        => 'required|string|max:255',
            'meeting_link' => 'required|url',
            'start_time'   => 'required|date',
            'end_time'     => 'required|date|after:start_time',
            'notes'        => 'nullable|string',
        ]);

        OnlineMeeting::create([
            'classroom_id' => $request->classroom_id,
            'subject_id'   => $request->subject_id,
            'user_id'      => auth()->id(),
            'title'        => $request->title,
            'meeting_link' => $request->meeting_link,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'notes'        => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Jadwal Pertemuan Daring & Link Meet berhasil disimpan!');
    }

    // 3. Hapus Pertemuan Daring
    public function destroy(OnlineMeeting $meeting)
    {
        if ($meeting->user_id !== auth()->id()) {
            abort(403);
        }

        $meeting->delete();
        return redirect()->back()->with('success', 'Pertemuan Daring berhasil dihapus!');
    }

    // 4. Halaman Rekap Absensi Siswa per Pertemuan
    public function showAttendance(OnlineMeeting $meeting)
    {
        if ($meeting->user_id !== auth()->id()) {
            abort(403);
        }

        // Ambil semua Warga Belajar yang terdaftar di kelas pertemuan ini
        $students = User::where('role', 'siswa')
            ->where('classroom_id', $meeting->classroom_id)
            ->get();

        // Ambil data absensi yang sudah tercatat
        $attendances = Attendance::where('online_meeting_id', $meeting->id)
            ->get()
            ->keyBy('student_id');

        return view('tutor.meetings.attendance', compact('meeting', 'students', 'attendances'));
    }

    // 5. Tutor Update/Set Status Absensi Siswa Manual
    public function updateAttendance(Request $request, OnlineMeeting $meeting)
    {
        $request->validate([
            'attendances' => 'required|array',
            'attendances.*.status' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        foreach ($request->attendances as $studentId => $data) {
            Attendance::updateOrCreate(
                [
                    'online_meeting_id' => $meeting->id,
                    'student_id'        => $studentId,
                ],
                [
                    'status' => $data['status'],
                    'notes'  => $data['notes'] ?? null,
                ]
            );
        }

        return redirect()->back()->with('success', 'Rekap Presensi / Kehadiran berhasil diperbarui!');
    }
}
