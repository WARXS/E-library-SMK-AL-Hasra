
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - Library Al-Hasra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css'])
</head>

<body class="bg-slate-50 text-slate-800">

    <!-- Navbar -->
    <nav class="bg-white border-b px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <x-back-button fallback="{{ route('siswa.dashboard') }}" />
            <a href="{{ route('buku.index') }}" class="font-bold text-xl">Library <span class="text-indigo-600">Al-Hasra</span></a>
        </div>

        <a href="{{ route('buku.index') }}"
           class="text-indigo-600 hover:text-indigo-800">
            Kembali ke Katalog
        </a>
    </nav>

    <!-- Konten -->
    <main class="max-w-7xl mx-auto px-6 py-10">

        <h1 class="text-3xl font-bold mb-2">
            Riwayat Peminjaman
        </h1>

        <p class="text-slate-500 mb-8">
            Lihat status dan informasi peminjaman buku kamu.
        </p>

        <div class="bg-white rounded-xl shadow-sm border overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-slate-100 text-slate-600">
                    <tr>
                        <th class="px-5 py-4">No</th>
                        <th class="px-5 py-4">Judul Buku</th>
                        <th class="px-5 py-4">Tanggal Pinjam</th>
                        <th class="px-5 py-4">Jatuh Tempo</th>
                        <th class="px-5 py-4">Pengembalian Aktual</th>
                        <th class="px-5 py-4">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse ($peminjamans as $peminjaman)

                        <tr class="hover:bg-slate-50">

                            <td class="px-5 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-5 py-4 font-medium">
                                {{ $peminjaman->buku->judul ?? 'Buku tidak ditemukan' }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $peminjaman->tanggal_pinjam }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $peminjaman->tanggal_kembali }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $peminjaman->tanggal_pengembalian_aktual ?? '-' }}
                            </td>

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

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6"
                                class="text-center px-5 py-10 text-slate-500">
                                Kamu belum memiliki riwayat peminjaman buku.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </main>

</body>
</html>
