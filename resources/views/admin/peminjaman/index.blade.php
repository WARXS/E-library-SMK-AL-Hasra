
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Peminjaman - Library Al-Hasra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css'])
</head>

<body class="bg-slate-50 text-slate-800">

    <!-- Navbar -->
    <nav class="bg-white border-b px-6 py-4 flex justify-between">
        <div class="flex items-center gap-3">
            <x-back-button fallback="{{ route('admin.dashboard') }}" />
            <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl">Library <span class="text-indigo-600">Al-Hasra</span></a>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="text-indigo-600">
            Dashboard Admin
        </a>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-10">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    Pengajuan Peminjaman
                </h1>

                <p class="text-slate-500">
                    Kelola permintaan peminjaman dan pengembalian buku dari siswa.
                </p>
            </div>

            <!-- Tombol Peminjaman Offline -->
            <a href="{{ route('admin.peminjaman.create') }}"
               class="bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700 text-center">
                + Tambah Peminjaman Offline
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

        <!-- Tabel Peminjaman -->
        <div class="bg-white rounded-xl shadow-sm border overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-slate-100 text-slate-600">
                    <tr>
                        <th class="px-5 py-4">No</th>
                        <th class="px-5 py-4">Nama Siswa</th>
                        <th class="px-5 py-4">Judul Buku</th>
                        <th class="px-5 py-4">Tanggal Pinjam</th>
                        <th class="px-5 py-4">Jatuh Tempo</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse ($peminjamans as $peminjaman)

                        <tr class="hover:bg-slate-50">

                            <td class="px-5 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-5 py-4 font-medium">
                                {{ $peminjaman->user->name ?? 'User tidak ditemukan' }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $peminjaman->buku->judul ?? 'Buku tidak ditemukan' }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $peminjaman->tanggal_pinjam }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $peminjaman->tanggal_kembali }}
                            </td>

                            <!-- Status -->
                            <td class="px-5 py-4">

                                @if($peminjaman->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
                                        Menunggu
                                    </span>

                                @elseif($peminjaman->status === 'dipinjam')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                                        Dipinjam
                                    </span>

                                @elseif($peminjaman->status === 'dikembalikan')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                        Dikembalikan
                                    </span>

                                @elseif($peminjaman->status === 'ditolak')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                                        Ditolak
                                    </span>
                                @endif

                            </td>

                            <!-- Aksi -->
                            <td class="px-5 py-4">

                                @if($peminjaman->status === 'pending')

                                    <div class="flex items-center gap-2">

                                        <form action="{{ route('admin.peminjaman.approve', $peminjaman->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menyetujui peminjaman ini?')">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700">
                                                Setujui
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.peminjaman.reject', $peminjaman->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700">
                                                Tolak
                                            </button>
                                        </form>

                                    </div>

                                @elseif($peminjaman->status === 'dipinjam')

                                    <form action="{{ route('admin.peminjaman.return', $peminjaman->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin mencatat buku ini sudah dikembalikan?')">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                            class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700">
                                            Kembalikan Buku
                                        </button>
                                    </form>

                                @else

                                    <span class="text-slate-400">
                                        Sudah diproses
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center px-5 py-8 text-slate-500">
                                Belum ada pengajuan peminjaman.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </main>

</body>
</html>
