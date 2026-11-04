# Audit Project — Library Al-Hasra

**Tanggal audit:** 2 November 2026  
**Ruang lingkup:** pemeriksaan statis atas struktur dan kode yang tersedia di workspace.

> Audit ini tidak menjalankan aplikasi maupun test, tidak menjalankan migration, dan tidak membaca atau mengubah database. Karena itu, keterangan “tersedia/diimplementasikan” berarti alurnya tampak ada pada kode; keberhasilan runtime dan kondisi data aktual belum diverifikasi.

## Ringkasan

Project memiliki fondasi Laravel 12 dengan autentikasi berbasis satu tabel `users` dan pemisahan admin/siswa melalui kolom `role`. Fitur utama perpustakaan yang telah diimplementasikan mencakup katalog, pengajuan online, keputusan admin, pengembalian, CRUD buku dasar, dan pencatatan peminjaman langsung oleh admin.

Temuan prioritas:

1. `DatabaseSeeder` menggunakan `Hash::make()` tanpa import facade `Hash`, sehingga seeding admin berpotensi gagal.
2. Alur setelah registrasi dan tautan dashboard umum mengarah ke dashboard generik, bukan dashboard berdasarkan role.
3. Foreign key transaksi memakai `ON DELETE CASCADE`; menghapus akun atau buku dapat menghapus histori peminjaman.
4. Stok dapat diedit manual tanpa rekonsiliasi dengan peminjaman aktif; pengajuan online juga tidak mencadangkan stok sampai disetujui.
5. Belum terlihat test yang menguji aturan bisnis perpustakaan.

## 1. Struktur folder dan file penting

Daftar berikut merangkum struktur aplikasi yang relevan. Direktori dependency dan metadata Git tidak dirinci satu per satu.

| Lokasi | Isi/peran |
|---|---|
| `app/Http/Controllers/` | Controller autentikasi Breeze, profil, katalog, peminjaman, serta dashboard admin/siswa. |
| `app/Http/Controllers/Admin/` | Dashboard admin, manajemen buku, dan manajemen transaksi peminjaman. |
| `app/Http/Controllers/Siswa/` | Dashboard siswa. |
| `app/Http/Middleware/` | `AdminMiddleware` dan `SiswaMiddleware` untuk pemeriksaan role. |
| `app/Http/Requests/` | Validasi request login dan pembaruan profil. |
| `app/Models/` | `User`, `Buku`, dan `Peminjaman` serta relasi Eloquent. |
| `app/Providers/` | Provider aplikasi. |
| `app/View/Components/` | Komponen layout Breeze (`AppLayout`, `GuestLayout`). |
| `bootstrap/` | Bootstrap Laravel dan registrasi alias middleware. |
| `config/` | Konfigurasi autentikasi, database, cache, mail, queue, session, dan layanan lainnya. |
| `database/migrations/` | Skema users, cache, queue, buku, peminjaman, role/NIS, dan tanggal pengembalian aktual. |
| `database/seeders/` | `DatabaseSeeder` dan `BukuSeeder`. |
| `database/factories/` | Factory user. |
| `routes/web.php` | Halaman umum, dashboard, katalog, serta endpoint siswa/admin. |
| `routes/auth.php` | Route register/login/logout, reset password, verifikasi email, dan konfirmasi password. |
| `routes/console.php` | Route console Laravel. |
| `resources/views/admin/` | Dashboard admin, CRUD buku, daftar peminjaman, form offline, dan view riwayat. |
| `resources/views/siswa/` | Dashboard siswa. |
| `resources/views/buku/` | Katalog publik. |
| `resources/views/auth/`, `profile/`, `layouts/`, `components/` | Halaman dan komponen autentikasi, profil, layout, dan UI Breeze. |
| `resources/css/`, `resources/js/` | Asset frontend Vite. |
| `public/` | Entry point web dan asset publik. |
| `storage/` | Lokasi penyimpanan, cache/view/session sesuai konfigurasi. |
| `tests/` | Test contoh dan test autentikasi/profil dari scaffolding; belum tampak test alur perpustakaan. |
| Root | Konfigurasi Composer/NPM, Vite, Tailwind, PHPUnit, README, `.env`, serta dua arsip ZIP. Isi arsip ZIP tidak diperiksa. |

## 2. Controller, Model, View, dan Route

### Controller

| Controller | Tanggung jawab |
|---|---|
| `Auth/RegisteredUserController` | Form dan penyimpanan registrasi siswa; role disetel menjadi `siswa`. |
| `Auth/AuthenticatedSessionController` | Login, redirect berdasarkan role, logout dan invalidasi session. |
| Controller di `Auth/` lainnya | Reset password, konfirmasi password, serta verifikasi dan pengiriman email. |
| `ProfileController` | Edit, update, dan hapus akun yang sedang login. |
| `BukuController` | Menampilkan katalog buku. |
| `PeminjamanController` | Pengajuan online dan riwayat peminjaman milik siswa. |
| `Admin/DashboardController` | Menghitung ringkasan jumlah buku, siswa, transaksi, dan pengajuan pending. |
| `Admin/BukuController` | Daftar, tambah, edit, dan hapus buku. Method `show()` masih kosong dan tidak ada route detail. |
| `Admin/PeminjamanController` | Daftar transaksi, form dan simpan peminjaman offline, approval, rejection, dan pengembalian. |
| `Siswa/DashboardController` | Menghitung transaksi pending, sedang dipinjam, dan dikembalikan untuk siswa aktif. |

### Model dan relasi

| Model | Relasi/atribut penting |
|---|---|
| `User` | Memiliki banyak `Peminjaman`; fillable mencakup `name`, `email`, `password`, `role`, `nis`, dan `kelas`. Password di-cast hashed. |
| `Buku` | Memiliki banyak `Peminjaman`; fillable mencakup judul, penulis, penerbit, tahun, stok, dan cover. |
| `Peminjaman` | Tabel ditetapkan eksplisit sebagai `peminjamen`; belongsTo `User` dan `Buku`; status dikelola sebagai string dari enum database. |

Relasi ringkas:

```text
User 1 ─── * Peminjaman * ─── 1 Buku
```

### View utama

- **Publik/siswa:** `welcome.blade.php`, `buku/index.blade.php`, `siswa/dashboard.blade.php`, dan view riwayat di `admin/peminjaman/riwayat.blade.php`.
- **Admin:** `admin/dashboard.blade.php`, `admin/buku/{index,create,edit}.blade.php`, `admin/peminjaman/{index,create}.blade.php`.
- **Autentikasi/profil:** view Breeze di `auth/` dan `profile/`, dengan layout dan komponen di `layouts/` dan `components/`.
- View riwayat siswa ditempatkan dalam folder bernama `admin`, walaupun endpoint dan datanya ditujukan kepada siswa. Nama lokasi ini berpotensi membingungkan pemeliharaan.

### Route dan akses

- `/` menampilkan halaman welcome.
- `/katalog` menampilkan katalog dan terbuka untuk umum.
- `/login`, `/register`, route password, verifikasi, dan logout didefinisikan di `routes/auth.php`.
- `/admin/dashboard` menggunakan `auth` + `admin`.
- `/siswa/dashboard`, POST `/peminjaman`, dan GET `/riwayat-peminjaman` menggunakan `auth` + `siswa`.
- `/dashboard` menggunakan `auth` + `verified`, dan menampilkan dashboard generik.
- Grup `/admin/*` menggunakan `auth` + `admin`: CRUD buku, daftar transaksi, pembuatan peminjaman offline, approval, rejection, dan pengembalian.
- Alias middleware `admin` dan `siswa` didaftarkan di `bootstrap/app.php`; middleware membandingkan `user()->role` dengan string role terkait.

## 3. Fitur yang sudah diimplementasikan

Berikut fitur yang tampak lengkap sebagai alur kode utama. Semuanya belum diuji saat runtime dalam audit ini.

- Registrasi publik yang menetapkan role `siswa`, login dengan throttling, logout, dan pembatasan route berdasarkan role.
- Dashboard admin dengan ringkasan buku, siswa, transaksi, dan pengajuan pending.
- Dashboard siswa dengan hitungan transaksi berdasarkan status.
- Katalog yang menampilkan judul, penulis, penerbit, tahun, dan stok.
- Pengajuan peminjaman online dengan validasi keberadaan buku dan pemeriksaan stok saat pengajuan.
- Daftar transaksi admin serta tombol untuk menyetujui, menolak, atau mencatat pengembalian.
- Approval dengan pemeriksaan status dan stok di dalam transaksi database serta pengurangan stok.
- Pengembalian dengan pemeriksaan status di dalam transaksi, penambahan stok, dan pencatatan tanggal aktual.
- Peminjaman offline oleh admin: validasi siswa, buku dan tanggal; transaksi mengunci buku, membuat status `dipinjam`, dan mengurangi stok.
- CRUD dasar buku (buat, lihat daftar, edit, hapus) dengan validasi input di controller.
- Riwayat siswa difilter berdasarkan `user_id` pengguna yang sedang login.
- Proteksi CSRF tersedia pada form Blade yang diperiksa.

## 4. Fitur belum selesai atau belum tampak

- Halaman detail buku belum tersedia; `Admin/BukuController::show()` kosong dan tidak didaftarkan sebagai route.
- Kolom `cover` tersedia di model dan migration, tetapi form admin tidak mengunggah cover dan view katalog tidak menampilkan cover.
- Belum tampak pengelolaan anggota/siswa oleh admin, selain memilih akun siswa pada form peminjaman offline.
- Belum tampak fitur pencarian, filter status, pagination, ekspor laporan, notifikasi keputusan, denda keterlambatan, atau audit log admin.
- Tidak tampak batas jumlah buku aktif per siswa atau aturan pengajuan pinjaman berulang.
- Dashboard generik masih dipakai sebagai tujuan registrasi dan tautan dashboard dari halaman welcome; belum terintegrasi dengan dashboard role khusus.
- Test fitur khusus peminjaman, stok, otorisasi admin/siswa, CRUD buku, dan transisi status belum terlihat.
- Kelengkapan produksi seperti konfigurasi email, deployment, backup, dan hardening belum dinilai dalam audit ini.

## 5. Kondisi skema database dan relasi

**Skema pada file migration (bukan kondisi database aktual):**

| Tabel | Kolom utama | Catatan |
|---|---|---|
| `users` | `id`, `name`, `email` unik, `email_verified_at`, `password`, timestamps; migration tambahan `role` default `siswa`, `nis` nullable, `kelas` nullable | Tidak ada constraint unik pada NIS atau enum/check role. |
| `bukus` | `id`, `judul`, `penulis`, `penerbit` nullable, `tahun_terbit` year nullable, `stok` default 1, `cover` nullable, timestamps | Stok integer biasa tanpa constraint non-negatif di skema; validasi controller saat create/update meminta minimum 0. |
| `peminjamen` | `id`, `user_id`, `buku_id`, `tanggal_pinjam`, `tanggal_kembali`, `status`, timestamps; migration tambahan `tanggal_pengembalian_aktual` nullable | Status enum: `pending`, `dipinjam`, `dikembalikan`, `ditolak`. Kedua FK memakai cascade saat parent dihapus. |
| `password_reset_tokens`, `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs` | Tabel dukungan Laravel | Ditambahkan oleh migration scaffolding. |

File konfigurasi database menyediakan koneksi SQLite, MySQL/MariaDB, PostgreSQL, dan SQL Server; default di config adalah SQLite. `.env` tidak dicetak atau diperiksa nilainya. Tidak ada pemeriksaan koneksi, isi tabel, status migration, ataupun data aktual.

### Perilaku stok saat ini

- Pengajuan online berstatus `pending` **tidak** mengurangi stok.
- Approval memeriksa stok kembali, mengurangi satu unit, lalu menetapkan status `dipinjam`.
- Peminjaman offline langsung mengurangi stok saat transaksi dicatat.
- Pengembalian menambah stok dan mengubah status menjadi `dikembalikan`.
- Penolakan tidak memengaruhi stok karena pengajuan pending belum mengambil stok.

## 6. Bug, error, dan potensi masalah keamanan/operasional

### Prioritas tinggi

1. **Seeder berpotensi error:** `database/seeders/DatabaseSeeder.php` memanggil `Hash::make()` tanpa `use Illuminate\Support\Facades\Hash;`. Seeder admin bisa gagal dengan class tidak ditemukan.
2. **Histori dihapus oleh cascade:** migration peminjaman memakai cascade untuk FK user dan buku. Hapus akun melalui profil atau hapus buku di admin dapat menghilangkan baris histori transaksi terkait. Ini mengurangi keterlacakan data.
3. **Stok dapat tidak sesuai transaksi aktif:** form edit buku menerima stok manual tanpa menghitung buku yang sedang dipinjam. Admin bisa mengatur stok ke nilai yang secara operasional tidak benar.
4. **Rollback migration role tidak lengkap:** `down()` migration role/NIS tidak menghapus kolom yang ditambahkannya. Rollback tidak sepenuhnya membalik perubahan skema.

### Prioritas menengah

5. **Tujuan dashboard tidak konsisten:** controller login mengirim role admin ke dashboard admin dan semua role selain admin ke dashboard siswa. Registrasi mengirim siswa ke dashboard generik `/dashboard`; halaman welcome juga menggunakan `/dashboard`. Navigasi sesudah registrasi/login dapat berbeda.
6. **Role tak dikenal dianggap siswa saat login:** setiap role selain `admin` diarahkan ke dashboard siswa, lalu middleware akan menolak role selain `siswa` dengan 403. Perilaku lebih jelas bila role yang tidak dikenal ditangani eksplisit.
7. **Pengajuan online dapat menumpuk:** stok tidak dicadangkan saat status pending, sehingga jumlah pending bisa melebihi stok. Lock saat approval mencegah stok dikurangi tanpa pemeriksaan, tetapi admin dapat mengalami penolakan karena stok habis setelah menunggu.
8. **Rejection tidak mengunci transaksi:** pemeriksaan dan perubahan status rejection tidak dibungkus transaksi/row lock; dua permintaan bersamaan berpotensi memproses status yang sama. Dampak stok terbatas karena pending belum mengurangi stok.
9. **Akses katalog tanpa login membingungkan:** katalog publik menampilkan tombol pengajuan, tetapi endpoint pengajuan memerlukan login dan role siswa. Alur setelah login tidak mengembalikan pengguna secara eksplisit ke pengajuan yang tertunda.
10. **Registrasi terbuka:** route register publik dan tidak meminta NIS/kelas atau verifikasi keanggotaan sekolah. Role tetap disetel server-side ke `siswa`, jadi form tidak memberi pengguna pilihan menjadi admin; namun siapa pun dapat membuat akun siswa.
11. **Penghapusan profil siswa memutus histori:** profile controller memungkinkan pengguna menghapus akun setelah konfirmasi password; karena cascade, peminjaman terkait juga dihapus. Ini merupakan konsekuensi langsung dari skema.
12. **Validasi tanggal offline terbatas:** tanggal jatuh tempo harus sesudah/sama dengan tanggal pinjam, tetapi tidak dibatasi terhadap hari ini; tanggal historis atau masa depan sama-sama dapat dimasukkan.
13. **Skala daftar belum ditangani:** daftar buku dan transaksi menggunakan `get()`/`all()` tanpa pagination. Performa dapat menurun saat data membesar.
14. **View riwayat siswa tersimpan dalam direktori admin:** tidak tampak sebagai celah akses langsung, karena endpoint memakai middleware siswa, tetapi struktur dapat membingungkan saat pengembangan.
15. **Seed data bersifat tetap:** audit awal menemukan seeder admin memakai kredensial bawaan (`[EMAIL_ADMIN]` / `[PASSWORD_ADMIN]`). Jika seed digunakan pada lingkungan yang dapat diakses publik, kredensial tersebut harus dianggap tidak aman dan dikelola sesuai lingkungan.

### Catatan keamanan

- Middleware role dan CSRF pada form sudah menjadi kontrol dasar yang baik.
- Registrasi menetapkan role di server, bukan mengambil role dari input request.
- Password login memakai throttling; password model dicast hashed.
- Audit statis ini tidak mencakup penetration test, konfigurasi server, permission filesystem, nilai rahasia `.env`, atau penilaian kerentanan dependency.

## 7. Rekomendasi urutan pengerjaan berikutnya

1. **Perbaiki blocker setup:** tambahkan import facade Hash pada seeder dan pastikan strategi credential admin tidak memakai password tetap pada lingkungan nyata.
2. **Konsolidasikan alur autentikasi:** arahkan hasil registrasi, login, dan tautan dashboard ke satu tujuan yang sesuai role; putuskan apakah katalog memang boleh diakses publik dan bagaimana kembali ke halaman asal setelah login.
3. **Tetapkan kebijakan data/histori:** tentukan apakah transaksi harus dipertahankan ketika user/buku dihapus; gunakan kebijakan arsip/soft delete atau pembatasan penghapusan sesuai kebutuhan bisnis.
4. **Tentukan aturan stok dan peminjaman:** putuskan kapan stok direservasi, cegah permintaan berulang bila diperlukan, tetapkan batas pinjaman aktif, dan cegah edit stok yang bertentangan dengan transaksi berjalan.
5. **Tambahkan validasi serta batas transaksi:** tinjau validasi tanggal, konsistensi status, dan perlindungan concurrency pada semua transisi status.
6. **Lengkapi test bisnis:** uji role access, registrasi/login, stok habis, dua approval bersamaan, rejection, pengembalian ganda, peminjaman offline, delete behavior, dan validasi tanggal.
7. **Rapikan struktur dan UI:** pindahkan view riwayat ke area siswa, putuskan kebutuhan detail dan cover buku, lalu tambahkan pagination/filter bila volume data memerlukannya.
8. **Lanjutkan pemeriksaan runtime setelah persetujuan terpisah:** cek status migration dan jalankan aplikasi/test di lingkungan aman sebelum perubahan skema atau data apa pun.

## Batas audit

Audit ini didasarkan pada source file yang terlihat dalam workspace saat pemeriksaan. Tidak ada command test atau artisan yang dijalankan. Kondisi runtime, hasil query, database aktual, isi file `.env`, dan isi arsip ZIP tidak diverifikasi. Workspace sudah memiliki perubahan Git yang belum dikomit pada sejumlah file sebelum laporan ini dibuat; laporan ini tidak mengubah file-file tersebut.
