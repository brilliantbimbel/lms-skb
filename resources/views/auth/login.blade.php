<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - SKB OKU TIMUR</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js (Wajib agar Toggle Password Berjalan) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

        <!-- Header Instansi -->
        <div class="bg-gradient-to-r from-blue-900 to-indigo-900 pt-7 pb-6 px-6 text-center text-white relative">
            <div class="w-14 h-14 bg-white/10 rounded-2xl backdrop-blur-md flex items-center justify-center mx-auto mb-3 border border-white/20 shadow-inner">
                <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
            </div>
            <h1 class="text-xl font-extrabold tracking-wide">SKB OKU TIMUR</h1>
            <p class="text-xs font-bold text-blue-200 tracking-wider uppercase mt-0.5">LEARNING MANAGEMENT SYSTEM</p>
            <p class="text-[11px] text-blue-300/80 mt-1">Pendidikan Kesetaraan Paket A, B, & C</p>
        </div>

        <!-- Form Area -->
        <div class="p-6 sm:p-8">

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs">
                    <div class="font-semibold mb-1">Gagal Masuk:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Username -->
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
                        Username
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        autofocus
                        placeholder="masukkan username anda"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition duration-150"
                    >
                </div>

                <!-- Password (Default tertutup/bintang, klik mata untuk lihat) -->
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
                        Kata Sandi
                    </label>
                    <div class="relative flex items-center">
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            name="password"
                            required
                            placeholder="••••••••"
                            class="w-full pl-4 pr-11 py-3 rounded-xl border border-slate-300 text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition duration-150"
                        >
                        <!-- Tombol Toggle Mata -->
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-3.5 text-slate-400 hover:text-slate-600 focus:outline-none p-1"
                        >
                            <!-- Ikon Mata Terbuka (Muncul saat password tersembunyi) -->
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Ikon Mata Coret (Muncul saat password terlihat) -->
                            <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.98 8.98 0 013.682-.793c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-1.282 1.282a9.98 9.98 0 01-4.133 1.033" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center pt-1">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <label for="remember" class="ml-2.5 text-xs text-slate-600 font-medium cursor-pointer">
                        Ingat sesi login saya
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full mt-3 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm shadow-md hover:shadow-lg transition duration-200"
                >
                    Masuk ke Sistem
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-8 pt-4 border-t border-slate-100 text-center">
                <p class="text-[11px] text-slate-500 font-semibold">
                    &copy; {{ date('Y') }} Sanggar Kegiatan Belajar OKU TIMUR.
                </p>
                <p class="text-[10px] text-slate-400 mt-0.5">
                    Dinas Pendidikan dan Kebudayaan Kab. OKU Timur
                </p>
            </div>

        </div>

    </div>

</body>
</html>
