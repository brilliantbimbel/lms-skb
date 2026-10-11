<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Soal - {{ $quiz->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-slate-100 text-slate-800" x-data="{ qType: 'multiple_choice' }">

    <div class="max-w-4xl mx-auto p-6 space-y-6">

        <a href="{{ route('tutor.quizzes.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 hover:underline">
            ← Kembali ke Daftar Evaluasi
        </a>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h1 class="text-lg font-extrabold text-slate-800">{{ $quiz->title }}</h1>
            <p class="text-xs text-slate-500 mt-1">Kelas: {{ $quiz->classroom->name }} | Mapel: {{ $quiz->subject->name }} | Durasi: {{ $quiz->duration_minutes }} Menit</p>
        </div>

        <!-- Form Input Soal Baru -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-800 text-sm">Tambah Soal Baru</h3>
            <form method="POST" action="{{ route('tutor.quizzes.questions.store', $quiz->id) }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-600">Tipe Soal</label>
                        <select name="type" x-model="qType" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                            <option value="multiple_choice">Pilihan Ganda</option>
                            <option value="essay">Essay / Uraian</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-600">Bobot Nilai Soal Ini</label>
                        <input type="number" name="score_weight" value="10" min="1" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2 font-bold">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-600">Pertanyaan / Pertanyaan Ujian</label>
                    <textarea name="question_text" rows="3" required placeholder="Tuliskan pertanyaan di sini..." class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2"></textarea>
                </div>

                <!-- Pilihan Jawaban (Jika Pilihan Ganda) -->
                <div x-show="qType === 'multiple_choice'" class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <p class="text-xs font-bold text-slate-700">Opsi Pilihan Ganda & Kunci Jawaban:</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[11px] font-bold text-slate-600">Pilihan A</label>
                            <input type="text" name="option_a" placeholder="Opsi A" class="w-full mt-1 bg-white border border-slate-200 rounded-lg text-xs px-3 py-2">
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-600">Pilihan B</label>
                            <input type="text" name="option_b" placeholder="Opsi B" class="w-full mt-1 bg-white border border-slate-200 rounded-lg text-xs px-3 py-2">
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-600">Pilihan C</label>
                            <input type="text" name="option_c" placeholder="Opsi C" class="w-full mt-1 bg-white border border-slate-200 rounded-lg text-xs px-3 py-2">
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-600">Pilihan D</label>
                            <input type="text" name="option_d" placeholder="Opsi D" class="w-full mt-1 bg-white border border-slate-200 rounded-lg text-xs px-3 py-2">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-emerald-700">Kunci Jawaban Benar</label>
                        <select name="correct_answer" class="w-full mt-1 bg-white border border-emerald-300 rounded-xl text-xs px-3 py-2 font-bold text-emerald-700">
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold text-xs rounded-xl hover:bg-indigo-700 transition">
                    Simpan Soal ke Bank Soal
                </button>
            </form>
        </div>

        <!-- Daftar Soal Terbuat -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-800 text-sm">Daftar Soal Dalam Kuis Ini (Total: {{ $questions->count() }})</h3>
            <div class="space-y-3">
                @forelse($questions as $index => $q)
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-start gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-800 text-xs">#{{ $index + 1 }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-indigo-100 text-indigo-700">
                                    {{ $q->type === 'multiple_choice' ? 'Pilihan Ganda' : 'Essay' }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-500">Bobot: {{ $q->score_weight }} Poin</span>
                            </div>
                            <p class="text-xs text-slate-800 font-medium mt-1">{{ $q->question_text }}</p>

                            @if($q->type === 'multiple_choice')
                                <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-600 mt-2">
                                    <p class="{{ $q->correct_answer == 'a' ? 'font-bold text-emerald-600' : '' }}">A. {{ $q->option_a }}</p>
                                    <p class="{{ $q->correct_answer == 'b' ? 'font-bold text-emerald-600' : '' }}">B. {{ $q->option_b }}</p>
                                    <p class="{{ $q->correct_answer == 'c' ? 'font-bold text-emerald-600' : '' }}">C. {{ $q->option_c }}</p>
                                    <p class="{{ $q->correct_answer == 'd' ? 'font-bold text-emerald-600' : '' }}">D. {{ $q->option_d }}</p>
                                </div>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('tutor.questions.destroy', $q->id) }}" onsubmit="return confirm('Hapus soal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:underline text-xs font-bold">Hapus</button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-4">Belum ada soal ditambahkan.</p>
                @endforelse
            </div>
        </div>

    </div>

</body>
</html>
