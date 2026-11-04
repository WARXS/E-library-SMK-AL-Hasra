
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Perpustakaan Al-Hasra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css'])
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow px-8 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-blue-700">
            Perpustakaan Al-Hasra
        </h1>

        <div class="flex items-center gap-4">
            <span class="text-gray-600">
                Admin, {{ Auth::user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">

        <!-- Judul -->
        <h2 class="text-3xl font-bold text-gray-800">
            Dashboard Admin
        </h2>

        <p class="text-gray-500 mt-2 mb-8">
            Selamat datang! Berikut ringkasan aktivitas Perpustakaan Al-Hasra.
        </p>

        <!-- Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-500">Total Buku</p>
                <h3 class="text-4xl font-bold text-blue-600 mt-3">
                    {{ $totalBuku }}
                </h3>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-500">Total Siswa</p>
                <h3 class="text-4xl font-bold text-purple-600 mt-3">
                    {{ $totalSiswa }}
                </h3>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-500">Total Peminjaman</p>
                <h3 class="text-4xl font-bold text-green-600 mt-3">
                    {{ $totalPeminjaman }}
                </h3>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-500">Menunggu Persetujuan</p>
                <h3 class="text-4xl font-bold text-yellow-500 mt-3">
                    {{ $menunggu }}
                </h3>
            </div>

        </div>

        <!-- Menu Admin -->
        <h3 class="text-xl font-bold text-gray-800 mt-10 mb-5">
            Menu Pengelolaan
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <a href="{{ route('admin.buku.index') }}"
               class="bg-blue-600 text-white p-6 rounded-xl shadow hover:bg-blue-700 transition">
                <h4 class="text-xl font-bold">Kelola Data Buku</h4>
                <p class="mt-2 text-blue-100">
                    Tambah, edit, hapus, dan lihat koleksi buku perpustakaan.
                </p>
            </a>

            <a href="{{ route('admin.peminjaman.index') }}"
               class="bg-white text-gray-800 p-6 rounded-xl shadow hover:bg-gray-50 transition">
                <h4 class="text-xl font-bold">Kelola Peminjaman</h4>
                <p class="mt-2 text-gray-500">
                    Periksa pengajuan, setujui, tolak, dan catat pengembalian buku.
                </p>
            </a>

        </div>

    </main>

</body>
</html>
