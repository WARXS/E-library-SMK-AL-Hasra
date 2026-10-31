<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - Perpustakaan SMK Al-Hasra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-100 shadow-sm py-4 px-6 flex justify-between items-center">
        <a href="/" class="font-bold text-xl text-slate-900">Perpustakaan <span class="text-indigo-600">SMK Al-Hasra</span></a>
        <a href="{{ url('/') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600">Beranda</a>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Katalog Buku Perpustakaan</h1>
        <p class="text-slate-600 mb-8">Pilih buku referensi atau modul pelajaran yang ingin kamu pinjam.</p>

        <!-- Grid Buku -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($bukus as $buku)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-all">
                    <div>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-semibold rounded-full">Stok: {{ $buku->stok }}</span>
                        <h3 class="text-xl font-bold text-slate-900 mt-4">{{ $buku->judul }}</h3>
                        <p class="text-sm text-slate-500 mt-1">Penulis: {{ $buku->penulis }}</p>
                        <p class="text-sm text-slate-500">Penerbit: {{ $buku->penerbit }} ({{ $buku->tahun_terbit }})</p>
                    </div>
                    <div class="mt-6">
                        <button class="w-full py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-all shadow-sm shadow-indigo-200">
                            Pinjam Buku
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>