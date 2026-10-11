<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengerjaan Evaluasi - {{ $quiz->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="max-w-3xl mx-auto p-6 space-y-6">

        <!-- Header Kuis -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex justify-between items-center sticky top-4 z-10">
            <div>
                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full text-[10px] font-bold uppercase">
                    {{ $quiz->subject->name }}
                </span>
                <h1 class="text-lg font-extrabold text-slate-800 mt-1">{{ $quiz->title }}</h1>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-bold text-slate-400 uppercase">Durasi Pengerjaan</p>
                <p class="text-sm font-black text-rose-600">{{ $quiz->duration_minutes }} Menit</p>
            </div>
        </div>

        <!-- Form Lembar Jawab -->
        <form method="POST" action="{{ route('student.quizzes.submit', $quiz->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan ujian ini?')" class="space-y-4">
            @csrf
            @foreach($questions as $index => $q)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-3">
                    <div class="flex justify-between items-start">
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-extrabold text-xs rounded-lg">Soal #{{ $index + 1 }}</span>
                        <span class="text-[11px] font-bold text-indigo-600">Bobot: {{ $q->score_weight }} Poin</span>
                    </div>

                    <p class="text-xs text-slate-800 font-medium leading-relaxed">{{ $q->question_text }}</p>

                    @if($q->type === 'multiple_choice')
                        <div class="space-y-2 pt-2">
                            <label class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-indigo-50/50 transition">
                                <input type="radio" name="answers[{{ $q->id }}]" value="a" class="w-4 h-4 text-indigo-600">
                                <span class="text-xs font-semibold text-slate-700">A. {{ $q->option_a }}</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-indigo-50/50 transition">
                                <input type="radio" name="answers[{{ $q->id }}]" value="b" class="w-4 h-4 text-indigo-600">
                                <span class="text-xs font-semibold text-slate-700">B. {{ $q->option_b }}</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-indigo-50/50 transition">
                                <input type="radio" name="answers[{{ $q->id }}]" value="c" class="w-4 h-4 text-indigo-600">
                                <span class="text-xs font-semibold text-slate-700">C. {{ $q->option_c }}</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-indigo-50/50 transition">
                                <input type="radio" name="answers[{{ $q->id }}]" value="d" class="w-4 h-4 text-indigo-600">
                                <span class="text-xs font-semibold text-slate-700">D. {{ $q->option_d }}</span>
                            </label>
                        </div>
                    @else
                        <div class="pt-2">
                            <textarea name="answers[{{ $q->id }}]" rows="3" placeholder="Ketikkan uraian/jawaban essay Anda di sini..." class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs p-3"></textarea>
                        </div>
                    @endif
                </div>
            @endforeach

            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl text-xs shadow-md transition">
                Selesaikan & Kirim Lembar Ujian
            </button>
        </form>

    </div>

</body>
</html>
