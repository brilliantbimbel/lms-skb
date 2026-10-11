<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warga Belajar - SKB OKU TIMUR</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <header class="bg-slate-900 text-white px-5 py-4 flex items-center justify-between sticky top-0 z-20 shadow-md">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-emerald-600 rounded-xl flex items-center justify-center font-bold text-sm text-white shadow-sm">
                SKB
            </div>
            <div>
                <h2 class="text-xs font-bold leading-tight">SKB OKU TIMUR</h2>
                <p class="text-[10px] text-slate-400">Portal Warga Belajar</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-emerald-400 font-semibold">{{ $classroom->name }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-red-400 transition" title="Keluar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </header>

    <!-- Content -->
    <main class="max-w-xl mx-auto w-full p-5 space-y-5 flex-1">

        @if(session('success'))
            <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-xs font-semibold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Banner Profil Ringkas -->
<div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 rounded-3xl p-5 text-white shadow-lg space-y-3">

    <!-- Badge Program Kesetaraan & Kelas -->
    <div class="flex items-center gap-2 flex-wrap">
        <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white rounded-full text-[10px] font-extrabold uppercase tracking-wider border border-white/10 shadow-sm">
            {{ $classroom->program->name }}
        </span>
        <span class="px-3 py-1 bg-emerald-950/40 backdrop-blur-md text-emerald-100 rounded-full text-[11px] font-bold border border-emerald-400/30 flex items-center gap-1.5 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            {{ $classroom->name }}
        </span>
    </div>

    <!-- Nama Siswa -->
    <div>
        <h1 class="text-xl font-extrabold leading-snug tracking-tight">
            Halo, {{ Auth::user()->name }} 👋
        </h1>
        <p class="text-[11px] text-emerald-100/90 font-medium mt-0.5">
            Selamat datang kembali di Portal Belajar SKB OKU Timur
        </p>
    </div>

</div>

        <p class="text-xs font-extrabold text-slate-500 uppercase tracking-wider px-1">Menu Utama Pembelajaran</p>

        <!-- GRID 4 KARTU UTAMA -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <!-- KARTU 1: Materi Pembelajaran -->
            <a href="{{ route('student.materials.index') }}" class="group bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-500 transition-all flex flex-col justify-between space-y-4">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold group-hover:scale-110 transition-transform">
                        📖
                    </div>
                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-full">
                        {{ $totalMaterials }} Materi
                    </span>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-slate-800 group-hover:text-blue-600 transition">1. Materi Pembelajaran</h3>
                    <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Baca modul PDF & tonton video pembelajaran dari Tutor.</p>
                </div>
                <div class="text-xs font-bold text-blue-600 flex items-center gap-1">
                    Buka Materi →
                </div>
            </a>

            <!-- KARTU 2: Penugasan -->
            <a href="{{ route('student.assignments.index') }}" class="group bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all flex flex-col justify-between space-y-4">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold group-hover:scale-110 transition-transform">
                        📝
                    </div>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full">
                        {{ $submittedCount }} / {{ $totalAssignments }} Terkirim
                    </span>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-slate-800 group-hover:text-emerald-600 transition">2. Tugas</h3>
                    <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Kirim file jawaban tugas & lihat nilai dari Tutor.</p>
                </div>
                <div class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                    Lihat Tugas →
                </div>
            </a>

            <!-- KARTU 3: Pertemuan Daring & Meet -->
            <a href="{{ route('student.meetings.index') }}" class="group bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-indigo-500 transition-all flex flex-col justify-between space-y-4">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl font-bold group-hover:scale-110 transition-transform">
                        🎥
                    </div>
                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded-full">
                        {{ $attendedCount }} Absen
                    </span>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-slate-800 group-hover:text-indigo-600 transition">3. Pertemuan Daring</h3>
                    <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Link Google Meet / Zoom (Sabtu-Minggu) & Absensi.</p>
                </div>
                <div class="text-xs font-bold text-indigo-600 flex items-center gap-1">
                    Masuk Room & Absen →
                </div>
            </a>

            <!-- KARTU 4: Evaluasi Pembelajaran -->
            <a href="{{ route('student.quizzes.index') }}" class="group bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-rose-500 transition-all flex flex-col justify-between space-y-4">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl font-bold group-hover:scale-110 transition-transform">
                        ✍️
                    </div>
                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 text-[10px] font-bold rounded-full">
                        {{ $completedQuizCount }} / {{ $totalQuizzes }} Selesai
                    </span>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-slate-800 group-hover:text-rose-600 transition">4. Evaluasi & Kuis</h3>
                    <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Kerjakan ujian kuis online & lihat hasil skor Anda.</p>
                </div>
                <div class="text-xs font-bold text-rose-600 flex items-center gap-1">
                    Kerjakan Evaluasi →
                </div>
            </a>

        </div>

    </main>

</body>
</html>
