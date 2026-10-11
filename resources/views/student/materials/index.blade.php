<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Pembelajaran - SKB OKU TIMUR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="max-w-xl mx-auto p-5 space-y-4">

        <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:underline">
            ← Kembali ke Dashboard
        </a>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <h1 class="text-base font-extrabold text-slate-800">📖 Materi Pembelajaran</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftar modul & video dari Tutor/Pamong</p>
        </div>

        <div class="space-y-3">
            @forelse($materials as $m)
                <div class="p-4 bg-white rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-blue-600 uppercase">{{ $m->subject->name }}</span>
                        <h4 class="font-bold text-slate-800 text-xs mt-0.5">{{ $m->title }}</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5">Tutor: {{ $m->tutor->name }}</p>
                    </div>
                    <a href="{{ route('student.materials.show', $m->id) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition">
                        Pelajari
                    </a>
                </div>
            @empty
                <p class="text-xs text-slate-400 text-center py-8">Belum ada materi pembelajaran untuk kelas Anda.</p>
            @endforelse
        </div>

    </div>

</body>
</html>
