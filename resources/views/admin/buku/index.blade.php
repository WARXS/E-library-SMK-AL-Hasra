
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku - Library Al-Hasra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css'])
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center">
        <a href="{{ route('admin.dashboard') }}"
           class="font-bold text-xl text-slate-900">
            Library <span class="text-indigo-600">Al-Hasra</span>
        </a>

        <a href="{{ route('admin.dashboard') }}"
           class="text-sm text-slate-600 hover:text-indigo-600">
            Dashboard Admin
        </a>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">
                    Manajemen Buku
                </h1>
                <p class="text-slate-500 mt-2">
                    Kelola data koleksi buku perpustakaan.
                </p>
            </div>

            <a href="{{ route('admin.buku.create') }}"
               class="bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700">
                + Tambah Buku
            </a>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-5 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 px-5 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabel Buku -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">

            <table class="w-full text-sm text-left">
                <thead class="bg-slate-100 text-slate-600 uppercase">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Judul Buku</th>
                        <th class="px-6 py-4">Penulis</th>
                        <th class="px-6 py-4">Penerbit</th>
                        <th class="px-6 py-4">Tahun</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($bukus as $buku)
                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-900">
                                {{ $buku->judul }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $buku->penulis }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $buku->penerbit ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $buku->tahun_terbit ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $buku->stok }}
                            </td>

                            <td class="px-6 py-4">
                                <a href="{{ route('admin.buku.edit', $buku->id) }}"
                                   class="text-indigo-600 font-medium hover:underline">
                                    Edit
                                </a>

                                <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 font-medium hover:underline ml-4"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                Belum ada data buku.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

</body>
</html>
