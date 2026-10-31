<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library SMK Al-Hasra</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AOS Animation CDN -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased overflow-x-hidden">

    <!-- Header / Navbar -->
    <nav class="w-full bg-white/80 backdrop-blur-md fixed top-0 z-50 border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-200">
                    A
                </div>
                <span class="font-bold text-xl tracking-tight text-slate-900">Perpustakaan <span class="text-indigo-600">SMK Al-Hasra</span></span>
            </div>
            <div class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-all shadow-md shadow-indigo-200 hover:scale-105">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-indigo-600 border border-indigo-200 font-medium hover:bg-indigo-50 transition-all">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-all shadow-md shadow-indigo-200 hover:scale-105">Daftar Siswa</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen pt-32 pb-20 flex items-center justify-center px-6">
        <div class="max-w-5xl mx-auto text-center" data-aos="fade-up" data-aos-duration="1000">
            <span class="px-4 py-1.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700 uppercase tracking-wider">Literasi Digital Sekolah</span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 mt-6 leading-tight">
                Jelajahi Ilmu & Literasi Digital <br><span class="text-indigo-600">SMK Al-Hasra</span>
            </h1>
            <p class="text-lg text-slate-600 mt-6 max-w-2xl mx-auto">
                Akses katalog buku pelajaran, modul kejuruan, dan referensi digital secara cepat, nyaman, dan interaktif dari mana saja.
            </p>
            <div class="mt-8 flex justify-center gap-4">
                <a href="{{ route('login') }}" class="px-8 py-3.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:scale-105 transition-all">Mulai Membaca Buku</a>
            </div>
        </div>
    </section>

    <!-- Script AOS Animation -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });
    </script>
</body>
</html> 