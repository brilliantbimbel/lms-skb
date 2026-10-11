<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemeriksaan Tugas - {{ $assignment->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800" x-data="{ gradeModal: false, selectedSub: null }">

    <div class="max-w-5xl mx-auto p-6 space-y-6">

        <a href="{{ route('tutor.assignments.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 hover:underline">
            ← Kembali ke Daftar Tugas
        </a>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full text-[10px] font-bold uppercase">
                Pemeriksaan Hasil Tugas
            </span>
            <h1 class="text-lg font-extrabold text-slate-800 mt-2">{{ $assignment->title }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Mata Pelajaran: {{ $assignment->subject->name }} | Kelas: {{ $assignment->classroom->name }}
            </p>
        </div>

        <!-- Table Jawaban Siswa -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Warga Belajar</th>
                        <th class="p-4">Tanggal Dikirim</th>
                        <th class="p-4">File Jawaban</th>
                        <th class="p-4">Nilai Saat Ini</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($submissions as $s)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4">
                                <p class="font-bold text-slate-800">{{ $s->student->name }}</p>
                                <p class="text-[11px] text-slate-400">@<span>{{ $s->student->username }}</span></p>
                            </td>
                            <td class="p-4 text-slate-600">
                                {{ $s->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="p-4">
                                @if($s->file_path)
                                    @php
                                        $fileUrl = asset('storage/' . $s->file_path);
                                    @endphp
                                    <div class="flex items-center gap-1.5">
                                        <!-- OPSI 1: Buka & Lihat Langsung di Browser Tanpa Download Auto -->
                                        <a href="{{ $fileUrl }}" target="_blank" class="px-2.5 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg text-[11px] font-bold transition inline-flex items-center gap-1" title="Lihat dokumen langsung di browser">
                                            👁️ Lihat
                                        </a>

                                        <!-- OPSI 2: Tombol Download Manual -->
                                        <a href="{{ $fileUrl }}" download class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 rounded-lg text-[11px] font-bold transition inline-flex items-center gap-1" title="Unduh file ke perangkat">
                                            ⬇️ Unduh
                                        </a>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Hanya Catatan Teks</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($s->score !== null)
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[11px] font-bold">
                                        Nilai: {{ $s->score }} / 100
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-[11px] font-bold">
                                        Belum Dinilai
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <button @click="selectedSub = {{ json_encode($s) }}; gradeModal = true" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-[11px] rounded-lg transition shadow-sm">
                                    {{ $s->score !== null ? 'Edit Nilai' : 'Beri Nilai' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">Belum ada Warga Belajar yang mengumpulkan tugas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Modal Penilaian Tutor -->
    <div x-show="gradeModal" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4" @click.away="gradeModal = false">
            <h3 class="font-bold text-slate-800 text-base">Input Nilai & Catatan Tugas</h3>

            <template x-if="selectedSub">
                <form method="POST" :action="'/tutor/submissions/' + selectedSub.id + '/grade'" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs font-bold text-slate-600">Catatan / Jawaban Teks Siswa</label>
                        <div class="mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 whitespace-pre-line max-h-32 overflow-y-auto" x-text="selectedSub.notes || '(Siswa tidak menyertakan catatan)'"></div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-600">Nilai (0 - 100)</label>
                        <input type="number" name="score" x-model="selectedSub.score" min="0" max="100" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2 font-bold text-emerald-700">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-600">Umpan Balik / Catatan Tutor (Opsional)</label>
                        <textarea name="feedback" x-model="selectedSub.feedback" rows="3" placeholder="Contoh: Kerja bagus, tingkatkan lagi kerapian tulisan..." class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="gradeModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold">Simpan Nilai</button>
                    </div>
                </form>
            </template>
        </div>
    </div>

</body>
</html>
