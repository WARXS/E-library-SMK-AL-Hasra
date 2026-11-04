
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman - Perpustakaan Al-Hasra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css'])
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow px-8 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-blue-700">
            Perpustakaan Al-Hasra
        </h1>

        <a href="{{ route('admin.dashboard') }}"
           class="text-blue-600 hover:text-blue-800">
            Dashboard Admin
        </a>
    </nav>

    <main class="max-w-3xl mx-auto px-6 py-10">

        <div class="bg-white rounded-xl shadow p-8">

            <h2 class="text-2xl font-bold text-gray-800">
                Tambah Peminjaman Offline
            </h2>

            <p class="text-gray-500 mt-2 mb-8">
                Catat transaksi peminjaman buku yang dilakukan langsung di perpustakaan.
            </p>

            <!-- Pesan Error -->
            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-5">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-5">
                    <p class="font-semibold mb-2">Periksa kembali data berikut:</p>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                @csrf

                <!-- Pilih Siswa -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Nama Siswa
                    </label>

                    <select name="user_id"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">

                        <option value="">-- Pilih Siswa --</option>

                        @foreach ($siswas as $siswa)
                            <option value="{{ $siswa->id }}"
                                {{ old('user_id') == $siswa->id ? 'selected' : '' }}>
                                {{ $siswa->name }} ({{ $siswa->email }})
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- Pilih Buku -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Judul Buku
                    </label>

                    <select name="buku_id"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">

                        <option value="">-- Pilih Buku --</option>

                        @foreach ($bukus as $buku)
                            <option value="{{ $buku->id }}"
                                {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                {{ $buku->judul }} (Stok: {{ $buku->stok }})
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- Tanggal Pinjam -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Tanggal Peminjaman
                    </label>

                    <input type="date"
                           name="tanggal_pinjam"
                           value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                           required
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Tanggal Kembali -->
                <div class="mb-8">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Tanggal Jatuh Tempo
                    </label>

                    <input type="date"
                           name="tanggal_kembali"
                           value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}"
                           required
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Tombol -->
                <div class="flex flex-col sm:flex-row gap-3">

                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        Simpan Peminjaman
                    </button>

                    <a href="{{ route('admin.peminjaman.index') }}"
                       class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 text-center font-semibold">
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </main>

</body>
</html>
