<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - SKB OKU TIMUR</title>

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
<body class="bg-slate-100 text-slate-800 antialiased" x-data="{ addModal: false, editModal: false, resetModal: false, activeUser: {}, roleType: 'siswa', editRoleType: 'siswa' }">

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

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Data Pengguna
                </a>

                <div class="pt-4 pb-1 px-3 text-[10px] uppercase font-bold text-slate-500 tracking-wider">Akademik</div>

                <a href="{{ route('admin.programs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Program Kesetaraan
                </a>

                <a href="{{ route('admin.subjects.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">
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
                    <h1 class="text-lg font-bold text-slate-800">Manajemen Data Pengguna</h1>
                    <p class="text-xs text-slate-500">Kelola akun Admin, Tutor/Pamong, dan Warga Belajar</p>
                </div>
                <button @click="addModal = true" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah User Baru
                </button>
            </header>

            <div class="p-6 space-y-6">

                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-semibold">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Filter & Search -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200 flex flex-col md:flex-row gap-3 justify-between items-center">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-3 w-full">
                        <select name="role" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Tutor / Pamong</option>
                            <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Warga Belajar</option>
                        </select>

                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, Username, atau Email..." class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs pl-9 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                            <tr>
                                <th class="p-4">Pengguna</th>
                                <th class="p-4">Username</th>
                                <th class="p-4">Role</th>
                                <th class="p-4">Kelas / Rombel</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($users as $u)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-slate-800">{{ $u->name }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $u->email }}</p>
                                    </td>
                                    <td class="p-4 text-slate-600 font-mono">@<span>{{ $u->username }}</span></td>
                                    <td class="p-4">
                                        @if($u->role === 'admin')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">Admin</span>
                                        @elseif($u->role === 'guru')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">Tutor / Pamong</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Warga Belajar</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        @if($u->role === 'siswa')
                                            @if($u->classroom)
                                                <span class="font-bold text-slate-700">{{ $u->classroom->name }}</span>
                                                <span class="block text-[10px] text-slate-400">{{ $u->classroom->program->name }}</span>
                                            @else
                                                <span class="text-amber-600 font-bold text-[11px]">Belum Ada Kelas</span>
                                            @endif
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right space-x-1">
                                        <button @click="activeUser = {{ $u }}; resetModal = true" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-lg text-[11px] font-bold transition">
                                            Reset Pass
                                        </button>
                                        <button @click="activeUser = {{ json_encode($u) }}; editRoleType = '{{ $u->role }}'; editModal = true" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-bold transition">
    Edit
</button>
                                        @if(Auth::id() !== $u->id)
                                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" class="inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-[11px] font-bold transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-400">Tidak ada data pengguna ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="p-4 border-t border-slate-100">
                        {{ $users->links() }}
                    </div>
                </div>

            </div>

        </main>

    </div>

    <!-- Modal Tambah User -->
    <div x-show="addModal" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4" @click.away="addModal = false">
            <h3 class="font-bold text-slate-800 text-base">Tambah Pengguna Baru</h3>
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="text-xs font-bold text-slate-600">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Username</label>
                    <input type="text" name="username" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Email</label>
                    <input type="email" name="email" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Password</label>
                    <input type="password" name="password" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Role</label>
                    <select name="role" x-model="roleType" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                        <option value="siswa">Warga Belajar (Siswa)</option>
                        <option value="guru">Tutor / Pamong</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div x-show="roleType === 'siswa'">
                    <label class="text-xs font-bold text-slate-600">Pilih Kelas / Rombel</label>
                    <select name="classroom_id" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                        <option value="">-- Pilih Kelas (Opsional) --</option>
                        @foreach($classrooms as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->program->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="addModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div x-show="editModal" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4" @click.away="editModal = false">
            <h3 class="font-bold text-slate-800 text-base">Edit Data Pengguna</h3>
            <form :action="'/admin/users/' + activeUser.id" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="text-xs font-bold text-slate-600">Nama Lengkap</label>
                    <input type="text" name="name" x-model="activeUser.name" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Username</label>
                    <input type="text" name="username" x-model="activeUser.username" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Email</label>
                    <input type="email" name="email" x-model="activeUser.email" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-600">Role</label>
                    <select name="role" x-model="editRoleType" required class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                        <option value="siswa">Warga Belajar (Siswa)</option>
                        <option value="guru">Tutor / Pamong</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div x-show="editRoleType === 'siswa'">
                    <label class="text-xs font-bold text-slate-600">Pilih Kelas / Rombel</label>
                    <select name="classroom_id" x-model="activeUser.classroom_id" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                        <option value="">-- Pilih Kelas (Opsional) --</option>
                        @foreach($classrooms as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->program->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="editModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Reset Password -->
    <div x-show="resetModal" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl space-y-4" @click.away="resetModal = false">
            <h3 class="font-bold text-slate-800 text-base">Reset Password</h3>
            <p class="text-xs text-slate-500">Ubah password untuk user <span class="font-bold text-slate-800" x-text="activeUser.name"></span></p>
            <form :action="'/admin/users/' + activeUser.id + '/reset-password'" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="text-xs font-bold text-slate-600">Password Baru</label>
                    <input type="password" name="password" minlength="6" required placeholder="Minimal 6 karakter" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl text-xs px-3 py-2">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="resetModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-xl text-xs font-bold">Reset Password</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
