<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan Daring & Meet - SKB OKU TIMUR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="max-w-xl mx-auto p-5 space-y-4">

        <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 hover:underline">
            ← Kembali ke Dashboard
        </a>

        @if(session('success'))
            <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <h1 class="text-base font-extrabold text-slate-800">🎥 Pertemuan Daring & Absen</h1>
            <p class="text-xs text-slate-500 mt-0.5">Jadwal tatap muka daring (Sabtu - Minggu)</p>
        </div>

        <div class="space-y-3">
            @forelse($meetings as $mt)
                @php
                    $isAttended = in_array($mt->id, $attendedMeetingIds);
                @endphp
                <div class="p-4 bg-white rounded-2xl border border-slate-200 space-y-3 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[10px] font-bold text-indigo-600 uppercase">{{ $mt->subject->name }}</span>
                            <h4 class="font-bold text-slate-800 text-xs mt-0.5">{{ $mt->title }}</h4>
                            <p class="text-[10px] text-slate-500 mt-0.5">Tutor: {{ $mt->tutor->name }}</p>
                        </div>
                        @if($isAttended)
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded-full">✓ Hadir</span>
                        @else
                            <span class="px-2.5 py-1 bg-amber-100 text-amber-800 text-[10px] font-bold rounded-full">Belum Absen</span>
                        @endif
                    </div>

                    <p class="text-[11px] text-slate-600 font-medium">
                        📅 {{ $mt->start_time->format('d M Y') }} ({{ $mt->start_time->format('H:i') }} - {{ $mt->end_time->format('H:i') }} WIB)
                    </p>

                    <div class="flex gap-2 pt-1">
                        <a href="{{ $mt->meeting_link }}" target="_blank" class="flex-1 text-center py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition">
                            🎥 Buka Room Meet
                        </a>
                        @if(!$isAttended)
                            <form method="POST" action="{{ route('student.meetings.attend', $mt->id) }}">
                                @csrf
                                <button type="submit" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs transition">
                                    Klik Absen
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 text-center py-8">Belum ada jadwal pertemuan daring minggu ini.</p>
            @endforelse
        </div>

    </div>

</body>
</html>
