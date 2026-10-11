<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belum Ada Kelas - LMS SKB OKU TIMUR</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-2xl shadow-md max-w-md text-center space-y-4">
        <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mx-auto text-2xl font-bold">
            ⚠️
        </div>
        <h2 class="text-lg font-bold text-slate-800">Akun Anda Belum Masuk Kelas</h2>
        <p class="text-xs text-slate-500 leading-relaxed">
            Halo, <strong class="text-slate-700">{{ Auth::user()->name }}</strong>. Akun Anda belum didaftarkan ke Rombongan Belajar (Kelas) oleh Admin. Silakan hubungi Admin SKB OKU Timur untuk dimasukkan ke kelas Anda.
        </p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                Keluar / Logout
            </button>
        </form>
    </div>
</body>
</html>
