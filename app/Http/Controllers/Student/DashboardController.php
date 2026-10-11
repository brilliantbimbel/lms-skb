<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Material;
use App\Models\OnlineMeeting;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\Submission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // 1. Dashboard Utama (Tampilan 4 Kartu)
    public function index()
    {
        $user = auth()->user();
        $classroom = $user->classroom;

        if (!$classroom) {
            return view('student.no_class');
        }

        // Hitung Jumlah untuk Badge Ringkasan pada Kartu
        $totalMaterials = Material::where('classroom_id', $classroom->id)->count();

        $totalAssignments = Assignment::where('classroom_id', $classroom->id)->count();
        $submittedCount = Submission::where('student_id', $user->id)->count();

        $totalMeetings = OnlineMeeting::where('classroom_id', $classroom->id)->count();
        $attendedCount = Attendance::where('student_id', $user->id)->count();

        $totalQuizzes = Quiz::where('classroom_id', $classroom->id)->count();
        $completedQuizCount = QuizAttempt::where('student_id', $user->id)
            ->whereNotNull('completed_at')
            ->count();

        return view('student.dashboard', compact(
            'classroom',
            'totalMaterials',
            'totalAssignments',
            'submittedCount',
            'totalMeetings',
            'attendedCount',
            'totalQuizzes',
            'completedQuizCount'
        ));
    }

    // 2. Halaman Daftar Materi Pembelajaran
    public function indexMaterials()
    {
        $user = auth()->user();
        $materials = Material::with(['subject', 'tutor'])
            ->where('classroom_id', $user->classroom_id)
            ->latest()
            ->get();

        return view('student.materials.index', compact('materials'));
    }

   // 3. Halaman Daftar Tugas Siswa
public function indexAssignments()
{
    $user = auth()->user();
    $assignments = Assignment::with(['subject', 'tutor'])
        ->where('classroom_id', $user->classroom_id)
        ->latest()
        ->get();

    // Ambil data pengerjaan tugas milik siswa di-index berdasarkan assignment_id
    $submissions = Submission::where('student_id', $user->id)
        ->get()
        ->keyBy('assignment_id');

    return view('student.assignments.index', compact('assignments', 'submissions'));
}

    // 4. Halaman Daftar Pertemuan Daring
    public function indexMeetings()
    {
        $user = auth()->user();
        $meetings = OnlineMeeting::with(['subject', 'tutor'])
            ->where('classroom_id', $user->classroom_id)
            ->latest()
            ->get();

        $attendedMeetingIds = Attendance::where('student_id', $user->id)
            ->pluck('online_meeting_id')
            ->toArray();

        return view('student.meetings.index', compact('meetings', 'attendedMeetingIds'));
    }

   // 5. Halaman Daftar Kuis / Evaluasi Siswa
public function indexQuizzes()
{
    $user = auth()->user();
    $quizzes = Quiz::with(['subject', 'tutor', 'questions'])
        ->where('classroom_id', $user->classroom_id)
        ->latest()
        ->get();

    // Ambil semua pengerjaan kuis milik siswa ini
    $attempts = QuizAttempt::with('answers.question')
        ->where('student_id', $user->id)
        ->get()
        ->keyBy('quiz_id');

    return view('student.quizzes.index', compact('quizzes', 'attempts'));
}

    // --- METHOD LAINNYA ---

    public function attendMeeting(OnlineMeeting $meeting)
    {
        $user = auth()->user();
        if ($meeting->classroom_id !== $user->classroom_id) { abort(403); }

        Attendance::updateOrCreate(
            ['online_meeting_id' => $meeting->id, 'student_id' => $user->id],
            ['status' => 'hadir', 'notes' => 'Hadir mandiri melalui LMS']
        );

        return redirect()->back()->with('success', 'Presensi berhasil dicatat!');
    }

    public function showMaterial(Material $material)
    {
        if ($material->classroom_id !== auth()->user()->classroom_id) { abort(403); }
        return view('student.materials.show', compact('material'));
    }

    public function showAssignment(Assignment $assignment)
    {
        $user = auth()->user();
        if ($assignment->classroom_id !== $user->classroom_id) { abort(403); }

        $submission = Submission::where('assignment_id', $assignment->id)->where('student_id', $user->id)->first();
        return view('student.assignments.show', compact('assignment', 'submission'));
    }

    public function submitAssignment(Request $request, Assignment $assignment)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'file'  => 'nullable|file|mimes:pdf,docx,doc,jpg,png,zip,rar|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('submissions', 'public');
        }

        Submission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => auth()->id()],
            [
                'notes'     => $request->notes,
                'file_path' => $filePath ?? optional(Submission::where('assignment_id', $assignment->id)->where('student_id', auth()->id())->first())->file_path,
            ]
        );

        return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan!');
    }

    public function startQuiz(Quiz $quiz)
    {
        $user = auth()->user();
        if ($quiz->classroom_id !== $user->classroom_id) { abort(403); }

        $attempt = QuizAttempt::firstOrCreate(
            ['quiz_id' => $quiz->id, 'student_id' => $user->id],
            ['started_at' => now()]
        );

        if ($attempt->completed_at) {
            return redirect()->route('student.quizzes.index')->with('error', 'Anda sudah menyelesaikan kuis ini.');
        }

        $questions = Question::where('quiz_id', $quiz->id)->get();
        return view('student.quizzes.take', compact('quiz', 'attempt', 'questions'));
    }

    public function submitQuiz(Request $request, Quiz $quiz)
{
    $user = auth()->user();
    $attempt = QuizAttempt::where('quiz_id', $quiz->id)
        ->where('student_id', $user->id)
        ->firstOrFail();

    $questions = Question::where('quiz_id', $quiz->id)->get();
    $totalScore = 0;
    $hasEssay = false;

    foreach ($questions as $q) {
        $userAnswer = $request->input('answers.' . $q->id);
        $scoreGiven = null;

        if ($q->type === 'multiple_choice') {
            if (strtolower($userAnswer) === strtolower($q->correct_answer)) {
                $scoreGiven = $q->score_weight;
                $totalScore += $scoreGiven;
            } else {
                $scoreGiven = 0;
            }
        } else {
            // Soal Essay: Nilai sementara NULL (menunggu koreksi guru)
            $hasEssay = true;
            $scoreGiven = null;
        }

        QuizAnswer::updateOrCreate(
            [
                'quiz_attempt_id' => $attempt->id,
                'question_id'     => $q->id,
            ],
            [
                'answer'      => $userAnswer,
                'score_given' => $scoreGiven,
            ]
        );
    }

    $attempt->update([
        'completed_at' => now(),
        'total_score'  => $totalScore,
    ]);

    // Pesan rapi tanpa mempublikasikan nilai sementara jika ada essay
    $message = $hasEssay
        ? 'Jawaban ujian berhasil dikirim! Nilai akhir akan ditampilkan setelah jawaban essay dikoreksi oleh Tutor.'
        : 'Ujian selesai! Nilai Akhir Anda: ' . $totalScore;

    return redirect()->route('student.quizzes.index')->with('success', $message);
}
}
