<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $assignment->title }} - LMS SKB OKU TIMUR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="max-w-3xl mx-auto p-4 sm:p-6 space-y-6">

        <a href="{{ route('student.assignments.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:underline">
            ← Kembali ke Daftar Tugas
        </a>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-xs font-semibold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Informasi & Detail Tugas -->
        <div class="bg-white rounded-3xl border border-slate-200 p-5 sm:p-6 shadow-sm space-y-4">
            <div>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[10px] font-extrabold uppercase tracking-wider">
                    {{ $assignment->subject->name }}
                </span>
                <h1 class="text-xl font-extrabold text-slate-800 mt-2.5">{{ $assignment->title }}</h1>
                <p class="text-xs text-rose-600 font-bold mt-1 flex items-center gap-1">
                    ⏰ Tenggat Waktu: {{ $assignment->due_date->format('d M Y, H:i') }} WIB
                </p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 text-xs text-slate-700 leading-relaxed whitespace-pre-line">
                <h3 class="font-bold text-slate-800 mb-1">Petunjuk Tugas:</h3>
                {{ $assignment->description }}
            </div>

            <!-- Lampiran Lembar Soal dari Tutor (Opsi Lihat & Download) -->
            @if($assignment->file_path)
                @php
                    $soalUrl = asset('storage/' . $assignment->file_path);
                @endphp
                <div class="p-3.5 bg-blue-50/80 border border-blue-200/80 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">📄</span>
                        <div>
                            <p class="font-bold text-slate-800">Lampiran Lembar Tugas dari Tutor</p>
                            <p class="text-[10px] text-slate-500">Anda dapat membuka langsung tanpa mendownload.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <!-- OPSI 1: Buka & Lihat Soal di Browser Tanpa Download -->
                        <a href="{{ $soalUrl }}" target="_blank" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-[11px] font-bold transition inline-flex items-center gap-1 shadow-sm">
                            👁️ Lihat Tugas
                        </a>
                        <!-- OPSI 2: Download File Soal -->
                        <a href="{{ $soalUrl }}" download class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-xl text-[11px] font-bold transition inline-flex items-center gap-1 shadow-sm">
                            ⬇️ Unduh
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Form Lembar Pengumpulan Tugas Siswa -->
        <div class="bg-white rounded-3xl border border-slate-200 p-5 sm:p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-800 text-sm">Lembar Pengumpulan Tugas Anda</h3>

            @if($submission && $submission->score !== null)
                <!-- Kartu Hasil Nilai dari Tutor -->
                <div class="p-4 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-2xl space-y-2">
                    <p class="text-[10px] text-emerald-800 font-extrabold uppercase tracking-wider">Tugas Anda Telah Dinilai!</p>
                    <div class="text-2xl font-black text-emerald-700">
                        {{ $submission->score }} <span class="text-xs font-bold text-slate-400">/ 100</span>
                    </div>
                    @if($submission->feedback)
                        <p class="text-xs text-slate-600 bg-white/70 p-2.5 rounded-xl border border-emerald-100">
                            <strong>Catatan Tutor:</strong> "{{ $submission->feedback }}"
                        </p>
                    @endif
                </div>
            @endif

            <form method="POST" action="{{ route('student.assignments.submit', $assignment->id) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-bold text-slate-600">Catatan / Jawaban Teks (Opsional)</label>
                    <textarea name="notes" rows="4" placeholder="Ketikkan jawaban Anda di sini..." class="w-full mt-1.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs px-3.5 py-2.5 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition">{{ optional($submission)->notes }}</textarea>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-600">Upload File Jawaban (PDF/Word/Foto, Maks 10MB)</label>
                    <input type="file" name="file" class="w-full mt-1.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs px-3.5 py-2">

                    <!-- Opsi Cek File Jawaban yang Sudah Diupload -->
                    @if(optional($submission)->file_path)
                        @php
                            $jawabanUrl = asset('storage/' . $submission->file_path);
                        @endphp
                        <div class="mt-2.5 p-3 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-between text-xs">
                            <span class="text-[11px] font-bold text-emerald-700 flex items-center gap-1">
                                ✓ File jawaban Anda saat ini sudah terunggah.
                            </span>
                            <div class="flex items-center gap-1.5">
                                <a href="{{ $jawabanUrl }}" target="_blank" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-[10px] font-bold transition inline-flex items-center gap-1">
                                    👁️ Lihat Jawaban Saya
                                </a>
                                <a href="{{ $jawabanUrl }}" download class="px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-lg text-[10px] font-bold transition inline-flex items-center gap-1">
                                    ⬇️ Unduh
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl text-xs shadow-md transition">
                    {{ $submission ? 'Kirim Ulang Jawaban' : 'Kirim Jawaban Tugas' }}
                </button>
            </form>
        </div>

    </div>

</body>
</html>
