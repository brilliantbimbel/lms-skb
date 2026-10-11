<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemeriksaan Essay - {{ $attempt->student->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="max-w-3xl mx-auto p-6 space-y-6">

        <a href="{{ route('tutor.quizzes.results', $attempt->quiz_id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 hover:underline">
            ← Kembali ke Rekap Nilai
        </a>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full text-[10px] font-bold uppercase">
                Pemeriksaan Lembar Jawaban Essay
            </span>
            <h1 class="text-lg font-extrabold text-slate-800 mt-2">Siswa: {{ $attempt->student->name }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Ujian: {{ $attempt->quiz->title }} | Mapel: {{ $attempt->quiz->subject->name }}</p>
        </div>

        <form method="POST" action="{{ route('tutor.attempts.grade-essay', $attempt->id) }}" class="space-y-4">
            @csrf

            @foreach($attempt->answers as $index => $ans)
                @if($ans->question->type === 'essay')
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-3">
                        <div class="flex justify-between items-start border-b border-slate-100 pb-2">
                            <span class="font-bold text-xs text-slate-800">Soal Essay #{{ $index + 1 }}</span>
                            <span class="text-[11px] font-bold text-indigo-600">Bobot Maksimal: {{ $ans->question->score_weight }} Poin</span>
                        </div>

                        <p class="text-xs font-medium text-slate-700">{{ $ans->question->question_text }}</p>

                        <!-- Jawaban Siswa -->
                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-800 font-medium">
                            <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Jawaban Siswa:</p>
                            <p class="whitespace-pre-line">{{ $ans->answer ?? '(Siswa tidak mengisi jawaban)' }}</p>
                        </div>

                        <!-- Input Nilai -->
                        <div>
                            <label class="text-xs font-bold text-slate-600">Input Nilai (0 - {{ $ans->question->score_weight }})</label>
                            <input type="number"
                                   name="grades[{{ $ans->id }}]"
                                   value="{{ $ans->score_given ?? 0 }}"
                                   min="0"
                                   max="{{ $ans->question->score_weight }}"
                                   required
                                   class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2 font-bold text-emerald-700">
                        </div>
                    </div>
                @endif
            @endforeach

            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl text-xs shadow-md transition">
                Simpan Penilaian Essay & Kalkulasi Total Nilai
            </button>
        </form>

    </div>

</body>
</html>
