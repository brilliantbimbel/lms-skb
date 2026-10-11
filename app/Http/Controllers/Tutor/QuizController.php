<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\Subject;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $tutorId = auth()->id();
        $subjects = Subject::where('tutor_id', $tutorId)->get();
        $classrooms = Classroom::with('program')->get();

        $quizzes = Quiz::with(['classroom.program', 'subject'])
            ->withCount(['questions', 'attempts'])
            ->where('user_id', $tutorId)
            ->latest()
            ->get();

        return view('tutor.quizzes.index', compact('quizzes', 'subjects', 'classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_id'     => 'required|exists:classrooms,id',
            'subject_id'       => 'required|exists:subjects,id',
            'title'            => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:5',
            'start_time'       => 'required|date',
            'end_time'         => 'required|date|after:start_time',
            'description'      => 'nullable|string',
        ]);

        Quiz::create([
            'classroom_id'     => $request->classroom_id,
            'subject_id'       => $request->subject_id,
            'user_id'          => auth()->id(),
            'title'            => $request->title,
            'duration_minutes' => $request->duration_minutes,
            'start_time'       => $request->start_time,
            'end_time'         => $request->end_time,
            'description'      => $request->description,
        ]);

        return redirect()->back()->with('success', 'Paket Soal Evaluasi berhasil dibuat!');
    }

    public function destroy(Quiz $quiz)
    {
        if ($quiz->user_id !== auth()->id()) { abort(403); }
        $quiz->delete();
        return redirect()->back()->with('success', 'Paket Evaluasi berhasil dihapus!');
    }

    public function questions(Quiz $quiz)
    {
        if ($quiz->user_id !== auth()->id()) { abort(403); }
        $questions = Question::where('quiz_id', $quiz->id)->latest()->get();
        return view('tutor.quizzes.questions', compact('quiz', 'questions'));
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question_text'  => 'required|string',
            'type'           => 'required|in:multiple_choice,essay',
            'score_weight'   => 'required|integer|min:1',
            'option_a'       => 'required_if:type,multiple_choice|nullable|string',
            'option_b'       => 'required_if:type,multiple_choice|nullable|string',
            'option_c'       => 'required_if:type,multiple_choice|nullable|string',
            'option_d'       => 'required_if:type,multiple_choice|nullable|string',
            'correct_answer' => 'required_if:type,multiple_choice|nullable|in:a,b,c,d',
        ]);

        Question::create([
            'quiz_id'        => $quiz->id,
            'question_text'  => $request->question_text,
            'type'           => $request->type,
            'score_weight'   => $request->score_weight,
            'option_a'       => $request->option_a,
            'option_b'       => $request->option_b,
            'option_c'       => $request->option_c,
            'option_d'       => $request->option_d,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function destroyQuestion(Question $question)
    {
        $question->delete();
        return redirect()->back()->with('success', 'Soal berhasil dihapus!');
    }

    // Rekap Nilai Siswa
    public function results(Quiz $quiz)
    {
        if ($quiz->user_id !== auth()->id()) { abort(403); }

        $hasEssay = Question::where('quiz_id', $quiz->id)->where('type', 'essay')->exists();

        $attempts = QuizAttempt::with(['student', 'answers.question'])
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->get();

        return view('tutor.quizzes.results', compact('quiz', 'attempts', 'hasEssay'));
    }

    // Halaman Pemeriksaan Essay per Siswa
    public function showReview(QuizAttempt $attempt)
    {
        if ($attempt->quiz->user_id !== auth()->id()) { abort(403); }

        $attempt->load(['student', 'quiz', 'answers.question']);
        return view('tutor.quizzes.review', compact('attempt'));
    }

    // Simpan Nilai Essay dari Tutor
    public function gradeEssay(Request $request, QuizAttempt $attempt)
    {
        if ($attempt->quiz->user_id !== auth()->id()) { abort(403); }

        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'required|integer|min:0',
        ]);

        foreach ($request->grades as $answerId => $score) {
            $answer = QuizAnswer::find($answerId);
            if ($answer) {
                // Jangan melebihkan bobot maksimal
                $maxScore = $answer->question->score_weight;
                $finalScore = min($score, $maxScore);
                $answer->update(['score_given' => $finalScore]);
            }
        }

        // Hitung ulang total nilai seluruh soal (PG + Essay)
        $totalScore = QuizAnswer::where('quiz_attempt_id', $attempt->id)->sum('score_given');
        $attempt->update(['total_score' => $totalScore]);

        return redirect()->route('tutor.quizzes.results', $attempt->quiz_id)->with('success', 'Nilai Essay berhasil disimpan!');
    }

    // Reset Ujian Siswa (Agar Bisa Mengerjakan Ulang)
    public function resetAttempt(QuizAttempt $attempt)
    {
        if ($attempt->quiz->user_id !== auth()->id()) { abort(403); }

        $quizId = $attempt->quiz_id;
        $attempt->delete(); // Hapus pengerjaan & jawaban terkait

        return redirect()->back()->with('success', 'Pengerjaan kuis siswa berhasil direset! Siswa dapat mengerjakan kembali.');
    }
}
