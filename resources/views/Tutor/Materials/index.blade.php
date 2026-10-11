<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Pembelajaran - Panel Tutor SKB OKU TIMUR</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased" x-data="{ addModal: false }">

    <div class="min-h-screen flex">

        <!-- Sidebar Tutor -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0">
            <div class="p-5 bg-slate-950 flex items-center gap-3 border-b border-slate-800">
                <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                    SKB
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white leading-tight">SKB OKU TIMUR</h2>
                    <p class="text-[10px] text-slate-400">Panel Tutor / Pamong</p>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1.5 text-xs font-semibold">
                <div class="pt-2 pb-1 px-3 text-[10px] uppercase font-bold text-slate-500 tracking-wider">Modul Pembelajaran</div>

                <a href="{{ route('tutor.materials.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-indigo-600 text-white shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Materi Pembelajaran
                </a>

                <a href="{{ route('tutor.assignments.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Tugas & Penilaian
                </a>

                             <a href="{{ route('tutor.meetings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 0_2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
    Pertemuan Daring & Absen
</a>
   <a href="{{ route('tutor.quizzes.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    Soal Evaluasi & Rekap Nilai
</a>
            </nav>

            <div class="p-4 border-t border-slate-800 bg-slate-950/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-white">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-slate-400">@<span>{{ Auth::user()->username }}</span></p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 text-slate-400 hover:text-red-400 transition" title="Keluar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">

            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-10">
                <div>
                    <h1 class="text-lg font-bold text-slate-800">Materi Pembelajaran</h1>
                    <p class="text-xs text-slate-500">Unggah modul dan materi untuk Warga Belajar</p>
                </div>
                <button @click="addModal = true" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Materi Baru
                </button>
            </header>

            <div class="p-6 space-y-6">

                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table Materi -->
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                            <tr>
                                <th class="p-4">Judul Materi</th>
                                <th class="p-4">Mata Pelajaran</th>
                                <th class="p-4">Kelas / Rombel</th>
                                <th class="p-4">Lampiran & Video</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($materials as $m)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-slate-800">{{ $m->title }}</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">{{ $m->content }}</p>
                                    </td>
                                    <td class="p-4 font-bold text-indigo-600">{{ $m->subject->name }}</td>
                                    <td class="p-4 text-slate-700">{{ $m->classroom->name }} ({{ $m->classroom->program->name }})</td>
                                    <td class="p-4">
                                        <div class="flex flex-col gap-1">
                                            @if($m->file_path)
                                                <a href="{{ asset('storage/' . $m->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:underline">
                                                    📄 File Modul
                                                </a>
                                            @endif
                                            @if($m->video_url)
                                                <a href="{{ $m->video_url }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-rose-600 hover:underline">
                                                    🎬 Tonton Video
                                                </a>
                                            @endif
                                            @if(!$m->file_path && !$m->video_url)
                                                <span class="text-slate-300">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 text-right">
                                        <form method="POST" action="{{ route('tutor.materials.destroy', $m->id) }}" class="inline" onsubmit="return confirm('Yakin hapus materi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-[11px] font-bold transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-400">Belum ada materi pembelajaran yang dibuat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </main>

    </div>

    <!-- Modal Tambah Materi -->
    <div x-show="addModal" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4" @click.away="addModal = false">
            <h3 class="font-bold text-slate-800 text-base">Tambah Materi Pembelajaran</h3>
            <form method="POST" action="{{ route('tutor.materials.store') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <label class="text-xs font-bold text-slate-600">Mata Pelajaran</label>
                    <select name="subject_id" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                        @foreach($subjects as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Kelas / Rombel Sasaran</label>
                    <select name="classroom_id" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                        @foreach($classrooms as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->program->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Judul Materi</label>
                    <input type="text" name="title" required placeholder="Contoh: Bab 1 - Operasi Hitung" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Ringkasan / Rangkuman Materi</label>
                    <textarea name="content" rows="3" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2"></textarea>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Link Video Pembelajaran (YouTube / GDrive - Opsional)</label>
                    <input type="url" name="video_url" placeholder="Contoh: https://www.youtube.com/watch?v=..." class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Lampiran File (PDF/Doc/PPT, Maks 10MB - Opsional)</label>
                    <input type="file" name="file" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="addModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold">Simpan Materi</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
