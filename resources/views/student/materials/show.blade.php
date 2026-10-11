<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $material->title }} - LMS SKB OKU TIMUR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Pastikan elemen fullscreen mengisi penuh layar saat mode aktif */
        :fullscreen { width: 100vw !important; height: 100vh !important; background: #000; }
        :-webkit-full-screen { width: 100vw !important; height: 100vh !important; background: #000; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="max-w-4xl mx-auto p-4 sm:p-6 space-y-6">

        <a href="{{ route('student.materials.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:underline">
            ← Kembali ke Daftar Materi
        </a>

        <div class="bg-white rounded-3xl border border-slate-200 p-5 sm:p-6 shadow-sm space-y-6">

            <!-- Judul & Pengunggah -->
            <div>
                <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-[10px] font-extrabold uppercase tracking-wider">
                    {{ $material->subject->name }}
                </span>
                <h1 class="text-xl font-extrabold text-slate-800 mt-2.5">{{ $material->title }}</h1>
                <p class="text-xs text-slate-400 mt-1">Diupload oleh Tutor: <strong class="text-slate-600">{{ $material->tutor->name }}</strong></p>
            </div>

            <!-- Content Ringkasan Teks -->
            @if($material->content)
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 text-xs leading-relaxed text-slate-700 whitespace-pre-line">
                    <h3 class="font-bold text-slate-800 mb-1.5">Ringkasan Materi:</h3>
                    {{ $material->content }}
                </div>
            @endif

            <!-- Player Video (Embed Player + Full Screen) -->
            @if($material->video_url)
                @php
                    // Konversi URL Youtube standar menjadi Embed URL
                    $embedUrl = $material->video_url;
                    if (str_contains($embedUrl, 'watch?v=')) {
                        $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                        $embedUrl = explode('&', $embedUrl)[0];
                    } elseif (str_contains($embedUrl, 'youtu.be/')) {
                        $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $embedUrl);
                    }
                @endphp

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-slate-800 text-xs flex items-center gap-1.5">
                            🎬 Layar Video Pembelajaran:
                        </h3>
                        <!-- Tombol Fullscreen Video -->
                        <button onclick="toggleFullScreen('video-container')" class="px-3 py-1 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-[11px] font-bold transition flex items-center gap-1 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-5h-4m4 0v4m0-4l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            Layar Penuh Video
                        </button>
                    </div>

                    <!-- Container Layar Video -->
                    <div id="video-container" class="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-900 shadow-md border border-slate-800">
                        <iframe
                            src="{{ $embedUrl }}"
                            title="Video Pembelajaran"
                            class="absolute top-0 left-0 w-full h-full border-0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>

                    <div class="flex justify-end pt-1">
                        <a href="{{ $material->video_url }}" target="_blank" class="text-[11px] font-bold text-slate-400 hover:text-rose-600 transition inline-flex items-center gap-1">
                            Buka di Aplikasi YouTube →
                        </a>
                    </div>
                </div>
            @endif

            <!-- Layar PDF Viewer + Full Screen & Download -->
            @if($material->file_path)
                @php
                    $filePath = asset('storage/' . $material->file_path);
                @endphp

                <div class="space-y-3 pt-2">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-t border-slate-100 pt-4">
                        <div>
                            <h3 class="font-bold text-slate-800 text-xs flex items-center gap-1.5">
                                📄 Dokumen Modul Pembelajaran:
                            </h3>
                            <p class="text-[10px] text-slate-400 mt-0.5">Anda dapat membaca langsung dokumen di bawah ini.</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Tombol Fullscreen PDF -->
                            <button onclick="toggleFullScreen('pdf-container')" class="px-3 py-2 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl shadow-sm transition inline-flex items-center gap-1.5 shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-5h-4m4 0v4m0-4l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                Fullscreen PDF
                            </button>

                            <!-- Tombol Download PDF -->
                            <a href="{{ $filePath }}" download target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-sm transition inline-flex items-center justify-center gap-1.5 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Download Modul
                            </a>
                        </div>
                    </div>

                    <!-- Container Layar PDF -->
                    <div id="pdf-container" class="w-full h-[500px] rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-inner">
                        <iframe
                            src="{{ $filePath }}"
                            class="w-full h-full border-0"
                            type="application/pdf">
                            <p class="p-4 text-xs text-slate-500 text-center">
                                Browser Anda tidak mendukung penampil PDF otomatis. Silakan klik tombol download di atas.
                            </p>
                        </iframe>
                    </div>
                </div>
            @endif

        </div>

    </div>

    <!-- Script JavaScript Fullscreen -->
    <script>
        function toggleFullScreen(elementId) {
            const elem = document.getElementById(elementId);
            if (!elem) return;

            if (!document.fullscreenElement && !document.webkitFullscreenElement) {
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) { /* Safari */
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) { /* IE11 */
                    elem.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
            }
        }
    </script>

</body>
</html>
