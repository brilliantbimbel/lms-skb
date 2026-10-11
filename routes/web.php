<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController; // 1. Import UserController
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Tutor\LearningController;
use App\Http\Controllers\Tutor\MeetingController;
use App\Http\Controllers\Tutor\QuizController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    if (auth()->user()->isGuru()) {
        return redirect()->route('tutor.materials.index');
    }
    return redirect()->route('student.dashboard'); // Nanti untuk Warga Belajar
})->middleware(['auth', 'verified'])->name('dashboard');

// Route Khusus Admin
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Manajemen Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Route Program & Kelas
    Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
    Route::post('/classrooms', [ProgramController::class, 'storeClassroom'])->name('classrooms.store');
    Route::delete('/classrooms/{classroom}', [ProgramController::class, 'destroyClassroom'])->name('classrooms.destroy');

    // Route Mata Pelajaran
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'is_guru'])->prefix('tutor')->name('tutor.')->group(function () {
    // Materi
    Route::get('/materials', [LearningController::class, 'indexMaterials'])->name('materials.index');
    Route::post('/materials', [LearningController::class, 'storeMaterial'])->name('materials.store');
    Route::delete('/materials/{material}', [LearningController::class, 'destroyMaterial'])->name('materials.destroy');

    // Tugas
    Route::get('/assignments', [LearningController::class, 'indexAssignments'])->name('assignments.index');
    Route::post('/assignments', [LearningController::class, 'storeAssignment'])->name('assignments.store');
    Route::delete('/assignments/{assignment}', [LearningController::class, 'destroyAssignment'])->name('assignments.destroy');
    Route::get('/assignments/{assignment}/submissions', [LearningController::class, 'showSubmissions'])->name('assignments.submissions');
    Route::post('/submissions/{submission}/grade', [LearningController::class, 'gradeSubmission'])->name('submissions.grade');

    // Pertemuan Daring & Absensi (Sabtu-Minggu)
    Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings.index');
    Route::post('/meetings', [MeetingController::class, 'store'])->name('meetings.store');
    Route::delete('/meetings/{meeting}', [MeetingController::class, 'destroy'])->name('meetings.destroy');
    Route::get('/meetings/{meeting}/attendance', [MeetingController::class, 'showAttendance'])->name('meetings.attendance');
    Route::post('/meetings/{meeting}/attendance', [MeetingController::class, 'updateAttendance'])->name('meetings.attendance.update');

    // Route Evaluasi / CBT Kuis
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::get('/quizzes/{quiz}/questions', [QuizController::class, 'questions'])->name('quizzes.questions');
    Route::post('/quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
    Route::delete('/questions/{question}', [QuizController::class, 'destroyQuestion'])->name('questions.destroy');
    Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');

    Route::get('/attempts/{attempt}/review', [QuizController::class, 'showReview'])->name('attempts.review');
    Route::post('/attempts/{attempt}/grade-essay', [QuizController::class, 'gradeEssay'])->name('attempts.grade-essay');
    Route::delete('/attempts/{attempt}/reset', [QuizController::class, 'resetAttempt'])->name('attempts.reset');
});

// Route Khusus Warga Belajar (Siswa)
Route::middleware(['auth', 'is_siswa'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');

    // Route Daftar Per Modul (Tampilan Kartu)
    Route::get('/materials', [StudentDashboard::class, 'indexMaterials'])->name('materials.index');
    Route::get('/materials/{material}', [StudentDashboard::class, 'showMaterial'])->name('materials.show');

    Route::get('/assignments', [StudentDashboard::class, 'indexAssignments'])->name('assignments.index');
    Route::get('/assignments/{assignment}', [StudentDashboard::class, 'showAssignment'])->name('assignments.show');
    Route::post('/assignments/{assignment}/submit', [StudentDashboard::class, 'submitAssignment'])->name('assignments.submit');

    Route::get('/meetings', [StudentDashboard::class, 'indexMeetings'])->name('meetings.index');
    Route::post('/meetings/{meeting}/attend', [StudentDashboard::class, 'attendMeeting'])->name('meetings.attend');

    Route::get('/quizzes', [StudentDashboard::class, 'indexQuizzes'])->name('quizzes.index');
    Route::get('/quizzes/{quiz}/take', [StudentDashboard::class, 'startQuiz'])->name('quizzes.take');
    Route::post('/quizzes/{quiz}/submit', [StudentDashboard::class, 'submitQuiz'])->name('quizzes.submit');
});
require __DIR__.'/auth.php';
