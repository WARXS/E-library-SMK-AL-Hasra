
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Library Al-Hasra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css'])
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="max-w-3xl mx-auto px-6 py-10">

        <div class="mb-8">
            <a href="{{ route('admin.buku.index') }}"
               class="text-blue-600 hover:underline">
                ← Kembali ke Manajemen Buku
            </a>

            <h1 class="text-3xl font-bold text-gray-800 mt-4">
                Tambah Buku
            </h1>

            <p class="text-gray-500 mt-2">
                Masukkan informasi buku yang ingin ditambahkan.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-8">

            <form action="{{ route('admin.buku.store') }}" method="POST">
                @csrf

                <div class="space-y-5">

                    <div>
                        <label class="block font-medium mb-2">Judul Buku</label>
                        <input type="text" name="judul"
                            value="{{ old('judul') }}"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="Masukkan judul buku">
                        <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block font-medium mb-2">Penulis</label>
                        <input type="text" name="penulis"
                            value="{{ old('penulis') }}"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="Masukkan nama penulis">
                        <x-input-error :messages="$errors->get('penulis')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block font-medium mb-2">Penerbit</label>
                        <input type="text" name="penerbit"
                            value="{{ old('penerbit') }}"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="Masukkan nama penerbit">
                        <x-input-error :messages="$errors->get('penerbit')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block font-medium mb-2">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit"
                            value="{{ old('tahun_terbit') }}"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="Contoh: 2024">
                        <x-input-error :messages="$errors->get('tahun_terbit')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block font-medium mb-2">Stok Tersedia</label>
                        <p class="text-sm text-gray-500 mb-2">Jumlah buku yang saat ini tersedia secara fisik dan siap dipinjam. Buku yang sedang dipinjam tidak termasuk.</p>
                        <input type="number" name="stok" min="0" step="1" required
                            value="{{ old('stok') }}"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="Masukkan jumlah buku tersedia">
                        <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.buku.index') }}"
                           class="px-5 py-3 rounded-lg bg-gray-200 hover:bg-gray-300">
                            Batal
                        </a>

                        <button type="submit"
                            class="px-5 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                            Simpan Buku
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

</body>
</html>
