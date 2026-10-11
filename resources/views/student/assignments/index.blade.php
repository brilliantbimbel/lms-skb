<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penugasan Kelas - SKB OKU TIMUR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="max-w-xl mx-auto p-5 space-y-4">

        <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:underline">
            ← Kembali ke Dashboard
        </a>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <h1 class="text-base font-extrabold text-slate-800">📝 Tugas & Penilaian</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftar lembar soal & penugasan</p>
        </div>

        <div class="space-y-3">
            @forelse($assignments as $a)
                @php
                    $sub = $submissions->get($a->id);
                    $isSubmitted = $sub !== null;
                    $isGraded = $isSubmitted && $sub->score !== null;
                @endphp
                <div class="p-5 bg-white rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-[10px] font-extrabold uppercase rounded-full tracking-wider">
                                {{ $a->subject->name }}
                            </span>

                            @if(!$isSubmitted)
                                <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200/60 text-[10px] font-bold rounded-full">
                                    Belum Dikirim
                                </span>
                            @elseif(!$isGraded)
                                <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 border border-blue-200/60 text-[10px] font-bold rounded-full">
                                    ✓ Sudah Dikirim
                                </span>
                            @endif
                        </div>

                        <h4 class="font-extrabold text-slate-800 text-sm pt-0.5">{{ $a->title }}</h4>
                        <p class="text-[11px] text-rose-500 font-bold">Deadline: {{ $a->due_date->format('d M Y, H:i') }} WIB</p>
                    </div>

                    <div class="shrink-0 flex items-center justify-between sm:justify-end gap-3 border-t sm:border-0 border-slate-100 pt-3 sm:pt-0">
                        @if($isGraded)
                            <!-- Kartu Hasil Nilai Tugas -->
                            <div class="bg-gradient-to-br {{ $sub->score >= 70 ? 'from-emerald-500 to-teal-600 border-emerald-400' : 'from-slate-800 to-slate-900 border-slate-700' }} border rounded-2xl p-3 text-white shadow-md text-right min-w-[120px]">
                                <div class="flex items-center justify-between gap-2 border-b border-white/20 pb-1 mb-1">
                                    <span class="text-[9px] font-extrabold uppercase tracking-wider text-white/80">Nilai Tugas</span>
                                    <span class="text-[10px]">📝</span>
                                </div>
                                <div class="flex items-baseline justify-end gap-0.5">
                                    <span class="text-2xl font-black tracking-tight leading-none">{{ $sub->score }}</span>
                                    <span class="text-[10px] font-bold text-white/70">/100</span>
                                </div>
                            </div>
                        @elseif($isSubmitted)
                            <!-- Status Menunggu Pemeriksaan -->
                            <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl px-3 py-2 text-right">
                                <p class="text-[10px] font-extrabold uppercase tracking-wider text-amber-600">Status Tugas</p>
                                <p class="text-xs font-black text-amber-700 mt-0.5">⏳ Menunggu Periksa</p>
                            </div>
                        @endif

                        <a href="{{ route('student.assignments.show', $a->id) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-xs font-bold transition shadow-md shadow-emerald-600/20 shrink-0 inline-flex items-center gap-1">
                            {{ $isSubmitted ? 'Lihat Detail' : 'Kerjakan' }} →
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 text-center py-8">Belum ada tugas untuk kelas Anda.</p>
            @endforelse
        </div>

    </div>

</body>
</html>
