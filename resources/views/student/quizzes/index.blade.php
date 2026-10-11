<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluasi & Kuis - SKB OKU TIMUR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="max-w-xl mx-auto p-5 space-y-4">

        <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-1 text-xs font-bold text-rose-600 hover:underline">
            ← Kembali ke Dashboard
        </a>

        @if(session('success'))
            <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-xs font-semibold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs font-semibold shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <h1 class="text-base font-extrabold text-slate-800">✍️ Evaluasi & Kuis Online</h1>
            <p class="text-xs text-slate-500 mt-0.5">Ujian online Warga Belajar</p>
        </div>

        <div class="space-y-3">
            @forelse($quizzes as $qz)
                @php
                    $attempt = $attempts->get($qz->id);
                    $isCompleted = $attempt && $attempt->completed_at !== null;

                    // Cek apakah ada soal essay yang belum diperiksa tutor
                    $hasPendingEssay = false;
                    if ($isCompleted) {
                        $hasPendingEssay = $attempt->answers->contains(function($ans) {
                            return $ans->question->type === 'essay' && $ans->score_given === null;
                        });
                    }
                @endphp
                <div class="p-5 bg-white rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <span class="px-2.5 py-0.5 bg-rose-50 text-rose-600 border border-rose-200/60 text-[10px] font-extrabold uppercase rounded-full tracking-wider">
                            {{ $qz->subject->name }}
                        </span>
                        <h4 class="font-extrabold text-slate-800 text-sm pt-0.5">{{ $qz->title }}</h4>
                        <p class="text-[11px] text-slate-400 font-medium">Durasi: {{ $qz->duration_minutes }} Menit</p>
                    </div>

                    <div class="shrink-0">
                        @if($isCompleted)
                            @if($hasPendingEssay)
                                <!-- Card Status Menunggu Koreksi (Skor Disembunyikan) -->
                                <div class="bg-gradient-to-br from-amber-500 to-amber-600 border border-amber-400 text-white rounded-2xl p-3.5 text-right shadow-md min-w-[140px]">
                                    <div class="flex items-center justify-between gap-2 border-b border-white/20 pb-1 mb-1">
                                        <span class="text-[9px] font-extrabold uppercase tracking-wider text-amber-100">Status Evaluasi</span>
                                        <span class="text-xs">⏳</span>
                                    </div>
                                    <p class="text-xs font-black tracking-tight leading-snug">Menunggu Koreksi</p>
                                    <p class="text-[9px] font-medium text-amber-100/90 mt-0.5">Tutor sedang memeriksa essay</p>
                                </div>
                            @else
                                <!-- Card Hasil Nilai Akhir (Muncul Setelah Koreksi Selesai / Kuis Full PG) -->
                                <div class="bg-gradient-to-br {{ $attempt->total_score >= 70 ? 'from-emerald-500 to-teal-600 border-emerald-400' : 'from-slate-800 to-slate-900 border-slate-700' }} border rounded-2xl p-3.5 text-white shadow-md text-right min-w-[130px]">
                                    <div class="flex items-center justify-between gap-2 border-b border-white/20 pb-1 mb-1">
                                        <span class="text-[9px] font-extrabold uppercase tracking-wider text-white/80">Nilai Akhir</span>
                                        <span class="text-xs">🏆</span>
                                    </div>
                                    <div class="flex items-baseline justify-end gap-0.5">
                                        <span class="text-2xl font-black tracking-tight leading-none">{{ $attempt->total_score }}</span>
                                        <span class="text-[10px] font-bold text-white/70">/100</span>
                                    </div>
                                    <p class="text-[9px] font-bold {{ $attempt->total_score >= 70 ? 'text-emerald-100' : 'text-slate-300' }} mt-1">
                                        {{ $attempt->total_score >= 70 ? '✨ Sangat Baik' : '💪 Perlu Tingkatkan' }}
                                    </p>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('student.quizzes.take', $qz->id) }}" class="w-full sm:w-auto px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl text-xs font-bold transition shadow-md shadow-rose-600/20 inline-flex items-center justify-center gap-1.5">
                                Kerjakan Ujian →
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 text-center py-8">Belum ada ujian kuis untuk kelas Anda.</p>
            @endforelse
        </div>

    </div>

</body>
</html>
