<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mata Pelajaran - SKB OKU TIMUR</title>

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
<body class="bg-slate-100 text-slate-800 antialiased" x-data="{ addModal: false, editModal: false, activeSubject: {} }">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0">
            <div class="p-5 bg-slate-950 flex items-center gap-3 border-b border-slate-800">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                    SKB
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white leading-tight">SKB OKU TIMUR</h2>
                    <p class="text-[10px] text-slate-400">Admin Panel LMS</p>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1.5 text-xs font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <div class="pt-4 pb-1 px-3 text-[10px] uppercase font-bold text-slate-500 tracking-wider">Manajemen Pengguna</div>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Data Pengguna
                </a>

                <div class="pt-4 pb-1 px-3 text-[10px] uppercase font-bold text-slate-500 tracking-wider">Akademik</div>

                <a href="{{ route('admin.programs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Program Kesetaraan
                </a>

                <a href="{{ route('admin.subjects.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Mata Pelajaran
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
                    <h1 class="text-lg font-bold text-slate-800">Manajemen Mata Pelajaran</h1>
                    <p class="text-xs text-slate-500">Kelola kurikulum dan penugasan Tutor Pengampu Mapel</p>
                </div>
                <button @click="addModal = true" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Mapel Baru
                </button>
            </header>

            <div class="p-6 space-y-6">

                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table Mapel -->
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                            <tr>
                                <th class="p-4">Kode</th>
                                <th class="p-4">Mata Pelajaran</th>
                                <th class="p-4">Program Kesetaraan</th>
                                <th class="p-4">Tutor Pengampu</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($subjects as $s)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="p-4 font-mono font-bold text-blue-600">{{ $s->code }}</td>
                                    <td class="p-4">
                                        <p class="font-bold text-slate-800">{{ $s->name }}</p>
                                        @if($s->description)
                                            <p class="text-[11px] text-slate-400 mt-0.5">{{ $s->description }}</p>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        @if($s->program)
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                {{ $s->program->name }}
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                                Semua Program
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-slate-700">
                                        {{ $s->tutor ? $s->tutor->name : 'Belum Ditentukan' }}
                                    </td>
                                    <td class="p-4 text-right space-x-1">
                                        <button @click="activeSubject = {{ json_encode($s) }}; editModal = true" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-bold transition">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.subjects.destroy', $s->id) }}" class="inline" onsubmit="return confirm('Yakin hapus mata pelajaran ini?')">
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
                                    <td colspan="5" class="p-8 text-center text-slate-400">Belum ada mata pelajaran. Silakan tambahkan mapel baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </main>

    </div>

    <!-- Modal Tambah Mapel -->
    <div x-show="addModal" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4" @click.away="addModal = false">
            <h3 class="font-bold text-slate-800 text-base">Tambah Mata Pelajaran Baru</h3>
            <form method="POST" action="{{ route('admin.subjects.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="text-xs font-bold text-slate-600">Kode Mapel</label>
                    <input type="text" name="code" required placeholder="Contoh: MAT-A" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2 uppercase">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Nama Mata Pelajaran</label>
                    <input type="text" name="name" required placeholder="Contoh: Matematika" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Program Kesetaraan</label>
                    <select name="program_id" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                        <option value="">-- Semua Program (Umum) --</option>
                        @foreach($programs as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Tutor / Pamong Pengampu</label>
                    <select name="tutor_id" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                        <option value="">-- Pilih Tutor (Opsional) --</option>
                        @foreach($tutors as $t)
                            <option value="{{ $t->id }}">{{ $t->name }} (@<span>{{ $t->username }}</span>)</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="2" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="addModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold">Simpan Mapel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Mapel -->
    <div x-show="editModal" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4" @click.away="editModal = false">
            <h3 class="font-bold text-slate-800 text-base">Edit Mata Pelajaran</h3>
            <form :action="'/admin/subjects/' + activeSubject.id" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="text-xs font-bold text-slate-600">Kode Mapel</label>
                    <input type="text" name="code" x-model="activeSubject.code" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2 uppercase">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Nama Mata Pelajaran</label>
                    <input type="text" name="name" x-model="activeSubject.name" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Program Kesetaraan</label>
                    <select name="program_id" x-model="activeSubject.program_id" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                        <option value="">-- Semua Program (Umum) --</option>
                        @foreach($programs as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Tutor / Pamong Pengampu</label>
                    <select name="tutor_id" x-model="activeSubject.tutor_id" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                        <option value="">-- Pilih Tutor (Opsional) --</option>
                        @foreach($tutors as $t)
                            <option value="{{ $t->id }}">{{ $t->name }} (@<span>{{ $t->username }}</span>)</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Deskripsi (Opsional)</label>
                    <textarea name="description" x-model="activeSubject.description" rows="2" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="editModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold">Perbarui Mapel</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
