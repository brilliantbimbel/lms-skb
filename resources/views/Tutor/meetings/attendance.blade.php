<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Presensi - SKB OKU TIMUR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="max-w-4xl mx-auto p-6 space-y-6">

        <a href="{{ route('tutor.meetings.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 hover:underline">
            ← Kembali ke Jadwal Pertemuan
        </a>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex justify-between items-center">
            <div>
                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full text-[10px] font-bold uppercase">
                    {{ $meeting->subject->name }} - {{ $meeting->classroom->name }}
                </span>
                <h1 class="text-lg font-extrabold text-slate-800 mt-2">{{ $meeting->title }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Waktu: {{ $meeting->start_time->format('d M Y, H:i') }} - {{ $meeting->end_time->format('H:i') }} WIB
                </p>
            </div>
            <a href="{{ $meeting->meeting_link }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition">
                🎥 Buka Meet
            </a>
        </div>

        <!-- Form Update Presensi Siswa -->
        <form method="POST" action="{{ route('tutor.meetings.attendance.update', $meeting->id) }}">
            @csrf
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-4 border-b border-slate-200 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-sm">Daftar Kehadiran Warga Belajar</h3>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                        Simpan Perubahan Presensi
                    </button>
                </div>

                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                        <tr>
                            <th class="p-4">Warga Belajar</th>
                            <th class="p-4">Status Kehadiran</th>
                            <th class="p-4">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($students as $s)
                            @php
                                $att = $attendances->get($s->id);
                                $currentStatus = $att ? $att->status : 'alpha';
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-4">
                                    <p class="font-bold text-slate-800">{{ $s->name }}</p>
                                    <p class="text-[11px] text-slate-400">@<span>{{ $s->username }}</span></p>
                                </td>
                                <td class="p-4">
                                    <div class="flex gap-2">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendances[{{ $s->id }}][status]" value="hadir" {{ $currentStatus == 'hadir' ? 'checked' : '' }} class="hidden peer">
                                            <span class="px-3 py-1.5 rounded-lg border text-[11px] font-bold peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600 border-slate-200 text-slate-600">Hadir</span>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendances[{{ $s->id }}][status]" value="izin" {{ $currentStatus == 'izin' ? 'checked' : '' }} class="hidden peer">
                                            <span class="px-3 py-1.5 rounded-lg border text-[11px] font-bold peer-checked:bg-amber-500 peer-checked:text-white peer-checked:border-amber-500 border-slate-200 text-slate-600">Izin</span>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendances[{{ $s->id }}][status]" value="sakit" {{ $currentStatus == 'sakit' ? 'checked' : '' }} class="hidden peer">
                                            <span class="px-3 py-1.5 rounded-lg border text-[11px] font-bold peer-checked:bg-blue-500 peer-checked:text-white peer-checked:border-blue-500 border-slate-200 text-slate-600">Sakit</span>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendances[{{ $s->id }}][status]" value="alpha" {{ $currentStatus == 'alpha' ? 'checked' : '' }} class="hidden peer">
                                            <span class="px-3 py-1.5 rounded-lg border text-[11px] font-bold peer-checked:bg-rose-600 peer-checked:text-white peer-checked:border-rose-600 border-slate-200 text-slate-600">Alpha</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <input type="text" name="attendances[{{ $s->id }}][notes]" value="{{ $att ? $att->notes : '' }}" placeholder="Keterangan (opsional)..." class="w-full bg-slate-50 border border-slate-200 rounded-lg text-xs px-2.5 py-1.5">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-slate-400">Belum ada Warga Belajar di kelas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

    </div>

</body>
</html>
