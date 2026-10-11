<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai - {{ $quiz->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="max-w-5xl mx-auto p-6 space-y-6">

        <a href="{{ route('tutor.quizzes.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 hover:underline">
            ← Kembali ke Daftar Evaluasi
        </a>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h1 class="text-lg font-extrabold text-slate-800">Rekapitulasi Hasil Evaluasi: {{ $quiz->title }}</h1>
            <p class="text-xs text-slate-500 mt-1">Kelas: {{ $quiz->classroom->name }} | Mata Pelajaran: {{ $quiz->subject->name }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Warga Belajar</th>
                        <th class="p-4">Waktu Selesai</th>
                        <th class="p-4">Status / Nilai</th>
                        <th class="p-4 text-right">Aksi & Opsi Tutor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($attempts as $a)
                        @php
                            // Cek apakah ada soal essay yang belum dinilai (score_given === null)
                            $unGradedEssay = $a->answers->contains(function($ans) {
                                return $ans->question->type === 'essay' && $ans->score_given === null;
                            });
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4">
                                <p class="font-bold text-slate-800">{{ $a->student->name }}</p>
                                <p class="text-[11px] text-slate-400">@<span>{{ $a->student->username }}</span></p>
                            </td>
                            <td class="p-4 text-slate-600">
                                {{ $a->completed_at ? $a->completed_at->format('d M Y, H:i') : 'Sedang Mengerjakan' }}
                            </td>
                            <td class="p-4">
                                @if($unGradedEssay)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 inline-block mb-1">
                                        Perlu Periksa Essay
                                    </span>
                                    <p class="text-xs font-bold text-slate-600">PG: {{ $a->total_score }} Poin</p>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-block mb-1">
                                        Nilai Final
                                    </span>
                                    <p class="text-sm font-extrabold text-emerald-600">{{ $a->total_score }} / 100</p>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-1">
                                @if($hasEssay)
                                    <a href="{{ route('tutor.attempts.review', $a->id) }}" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-[11px] font-bold transition">
                                        Periksa Essay
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('tutor.attempts.reset', $a->id) }}" class="inline" onsubmit="return confirm('Yakin reset kuis siswa ini? Seluruh pengerjaan akan dihapus agar siswa dapat ujian ulang.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-[11px] font-bold transition" title="Reset pengerjaan agar siswa bisa re-take kuis">
                                        ↺ Reset / Remidi
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400">Belum ada Warga Belajar yang mengerjakan evaluasi ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
