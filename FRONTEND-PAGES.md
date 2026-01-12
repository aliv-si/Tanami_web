# 📄 Dokumentasi Halaman Frontend - TANAMI E-Commerce v2.0

Dokumen ini berisi daftar semua halaman (Blade Views) yang perlu dibuat berdasarkan routes yang sudah didefinisikan di `routes/web.php`.

---

## 📊 Ringkasan

| Kategori      | Jumlah Halaman |
| ------------- | -------------- |
| Public Pages  | 8              |
| Auth Pages    | 2              |
| Pembeli Pages | 5              |
| Petani Pages  | 8              |
| Admin Pages   | 12             |
| **Total**     | **35 halaman** |

---

## 🌐 PUBLIC PAGES

Halaman yang bisa diakses oleh semua pengunjung tanpa perlu login.

| No  | Route             | View File                       | Deskripsi                                                       |
| --- | ----------------- | ------------------------------- | --------------------------------------------------------------- |
| 1   | `/`               | `welcome.blade.php`             | **Landing Page** - Halaman utama saat pertama kali buka website |
| 2   | `/beranda`        | `pages/beranda.blade.php`       | **Beranda** - Homepage dengan highlight produk dan promo        |
| 3   | `/tentang`        | `pages/tentang.blade.php`       | **Tentang Kami** - Informasi tentang TANAMI                     |
| 4   | `/cara-kerja`     | `pages/cara-kerja.blade.php`    | **Cara Kerja** - Penjelasan alur belanja di TANAMI              |
| 5   | `/kontak`         | `pages/kontak.blade.php`        | **Kontak** - Form kontak dan informasi CS                       |
| 6   | `/katalog`        | `pages/katalog.blade.php`       | **Katalog** - Daftar semua produk dengan filter & search        |
| 7   | `/katalog/{slug}` | `pages/kategori.blade.php`      | **Kategori** - Produk berdasarkan kategori tertentu             |
| 8   | `/produk/{slug}`  | `pages/produk-detail.blade.php` | **Detail Produk** - Info lengkap produk, ulasan, add to cart    |

### Fitur di Halaman Public:

-   **Katalog**: Filter kategori, search produk, sorting (terbaru/termurah/terlaris)
-   **Detail Produk**: Galeri foto, deskripsi, harga, stok, ulasan pembeli, tombol add to cart

---

## 🔐 AUTH PAGES

Halaman autentikasi, hanya bisa diakses jika **belum login** (guest).

| No  | Route       | View File                 | Deskripsi                                      |
| --- | ----------- | ------------------------- | ---------------------------------------------- |
| 1   | `/login`    | `auth/login.blade.php`    | **Login** - Form login dengan email & password |
| 2   | `/register` | `auth/register.blade.php` | **Register** - Form pendaftaran akun baru      |

### Fitur di Halaman Auth:

-   **Login**: Email, password, remember me, link ke register & lupa password
-   **Register**: Nama, email, password, konfirmasi password, no HP, alamat

---

## 👤 PEMBELI PAGES

Halaman untuk pembeli yang sudah login.

| No  | Route           | View File                          | Deskripsi                                                    |
| --- | --------------- | ---------------------------------- | ------------------------------------------------------------ |
| 1   | `/profil`       | `pembeli/profil.blade.php`         | **Profil Saya** - Edit data diri dan ubah password           |
| 2   | `/keranjang`    | `pembeli/keranjang.blade.php`      | **Keranjang** - Daftar produk di cart, ubah qty, hapus       |
| 3   | `/checkout`     | `pembeli/checkout.blade.php`       | **Checkout** - Pilih alamat, input kupon, konfirmasi pesanan |
| 4   | `/pesanan`      | `pembeli/pesanan.blade.php`        | **Pesanan Saya** - Daftar semua pesanan dengan status        |
| 5   | `/pesanan/{id}` | `pembeli/pesanan-detail.blade.php` | **Detail Pesanan** - Info lengkap + upload bukti bayar       |

### Fitur di Halaman Pembeli:

-   **Keranjang**: Group by petani, update qty, hapus item, subtotal
-   **Checkout**: Pilih kota tujuan, ongkir otomatis, input kode kupon, ringkasan pembayaran
-   **Detail Pesanan**:
    -   Status pesanan (timeline)
    -   Upload bukti bayar (jika pending)
    -   Konfirmasi terima (jika terkirim)
    -   Request refund (jika ada masalah)
    -   Form ulasan (jika selesai)

---

## 🌾 PETANI PAGES

Halaman dashboard untuk user dengan role **petani**.

| No  | Route                      | View File                         | Deskripsi                                                      |
| --- | -------------------------- | --------------------------------- | -------------------------------------------------------------- |
| 1   | `/petani/dashboard`        | `petani/dashboard.blade.php`      | **Dashboard** - Statistik penjualan, pesanan baru              |
| 2   | `/petani/produk`           | `petani/produk/index.blade.php`   | **Produk Saya** - Daftar produk milik petani                   |
| 3   | `/petani/produk/tambah`    | `petani/produk/form.blade.php`    | **Tambah Produk** - Form input produk baru                     |
| 4   | `/petani/produk/{id}/edit` | `petani/produk/form.blade.php`    | **Edit Produk** - Form edit produk (reuse form)                |
| 5   | `/petani/pesanan`          | `petani/pesanan/index.blade.php`  | **Pesanan Masuk** - Daftar pesanan yang berisi produk petani   |
| 6   | `/petani/pesanan/{id}`     | `petani/pesanan/detail.blade.php` | **Detail Pesanan** - Verifikasi, proses, kirim                 |
| 7   | `/petani/rekening`         | `petani/rekening.blade.php`       | **Rekening Bank** - CRUD data rekening untuk terima pembayaran |
| 8   | `/petani/ulasan`           | `petani/ulasan.blade.php`         | **Ulasan** - Lihat semua ulasan untuk produk petani            |

### Fitur di Halaman Petani:

-   **Dashboard**: Total produk, pesanan pending, total pendapatan, chart penjualan
-   **Produk**: CRUD dengan upload foto, set harga, stok, kategori
-   **Pesanan**:
    -   Verifikasi/tolak pembayaran
    -   Update status: diproses → dikirim → terkirim
    -   Input nomor resi
-   **Rekening**: Tambah/edit/hapus rekening, set rekening utama

---

## 👑 ADMIN PAGES

Halaman dashboard untuk user dengan role **admin**.

| No  | Route                    | View File                         | Deskripsi                                       |
| --- | ------------------------ | --------------------------------- | ----------------------------------------------- |
| 1   | `/admin/dashboard`       | `admin/dashboard.blade.php`       | **Dashboard** - GMV, statistik platform         |
| 2   | `/admin/pengguna`        | `admin/pengguna/index.blade.php`  | **Pengguna** - Daftar semua user                |
| 3   | `/admin/pengguna/petani` | `admin/pengguna/petani.blade.php` | **Petani Pending** - Verifikasi akun petani     |
| 4   | `/admin/pengguna/{id}`   | `admin/pengguna/show.blade.php`   | **Detail Pengguna** - Info lengkap user         |
| 5   | `/admin/kategori`        | `admin/master/kategori.blade.php` | **Master Kategori** - CRUD kategori produk      |
| 6   | `/admin/kota`            | `admin/master/kota.blade.php`     | **Master Kota** - CRUD kota & tarif ongkir      |
| 7   | `/admin/kupon`           | `admin/master/kupon.blade.php`    | **Master Kupon** - CRUD voucher diskon          |
| 8   | `/admin/pesanan`         | `admin/pesanan/index.blade.php`   | **Semua Pesanan** - Monitor pesanan platform    |
| 9   | `/admin/pesanan/{id}`    | `admin/pesanan/detail.blade.php`  | **Detail Pesanan** - Info + histori status      |
| 10  | `/admin/escrow`          | `admin/escrow.blade.php`          | **Escrow** - Monitor dana ditahan platform      |
| 11  | `/admin/refund`          | `admin/refund.blade.php`          | **Refund** - Approve/reject permintaan refund   |
| 12  | `/admin/laporan`         | `admin/laporan.blade.php`         | **Laporan** - Report penjualan, produk terlaris |

### Fitur di Halaman Admin:

-   **Dashboard**: GMV, total transaksi, jumlah user, chart trend
-   **Pengguna**: Filter by role, search, verifikasi petani
-   **Master Data**: CRUD kategori, kota (dengan ongkir), kupon (nominal/persen)
-   **Pesanan**: Monitor semua status, lihat histori perubahan
-   **Escrow**: Dana ditahan, dikirim ke petani, di-refund
-   **Refund**: List request, approve (refund ke pembeli), reject (dana ke petani)
-   **Laporan**: Penjualan harian/mingguan/bulanan, produk terlaris, petani terbaik

---

## 📁 Struktur Folder Views

```
resources/views/
│
├── welcome.blade.php            (Aliv)
│
├── layouts/
│   ├── app.blade.php            (Aliv) # Layout utama (navbar, footer)
│   ├── guest.blade.php          (Adams) # Layout untuk auth pages
│   ├── petani.blade.php         (Imax) # Layout dashboard petani (sidebar)
│   └── admin.blade.php          (Adams) # Layout dashboard admin (sidebar)
│
├── components/
│   ├── navbar.blade.php         (Aliv) # Navigation bar
│   ├── footer.blade.php         (Aliv) # Footer
│   ├── sidebar-petani.blade.php (Ima) 
│   ├── sidebar-admin.blade.php  (Adams) 
│   ├── product-card.blade.php   (Aliv) # Card produk reusable
│   ├── alert.blade.php          (Aliv) # Flash message
│   └── pagination.blade.php     (Aliv) # Custom pagination
│
├── auth/
│   ├── login.blade.php          (Adams) 
│   └── register.blade.php       (Adams) 
│
├── pages/
│   ├── beranda.blade.php        (Aliv) 
│   ├── tentang.blade.php        (Aliv) 
│   ├── cara-kerja.blade.php     (Aliv) 
│   ├── kontak.blade.php         (Aliv) 
│   ├── katalog.blade.php        (Aliv) 
│   ├── kategori.blade.php       (Aliv) 
│   └── produk-detail.blade.php  (Aliv) 
│
├── pembeli/
│   ├── profil.blade.php         (Aliv) 
│   ├── keranjang.blade.php      (Aliv) 
│   ├── checkout.blade.php       (Aliv) 
│   ├── pesanan.blade.php        (Aliv) 
│   └── pesanan-detail.blade.php (Aliv) 
│
├── petani/
│   ├── dashboard.blade.php      (Imax) 
│   ├── produk/
│   │   ├── index.blade.php      (Imax) 
│   │   └── form.blade.php       (Imax) 
│   ├── pesanan/
│   │   ├── index.blade.php      (Imax) 
│   │   └── detail.blade.php     (Imax) 
│   ├── rekening.blade.php       (Imax) 
│   └── ulasan.blade.php         (Imax) 
│
└── admin/
    ├── dashboard.blade.php      (Adams) 
    ├── pengguna/
    │   ├── index.blade.php      (Adams) 
    │   ├── petani.blade.php     (Adams) 
    │   └── show.blade.php       (Adams) 
    ├── master/
    │   ├── kategori.blade.php   (Adams) 
    │   ├── kota.blade.php       (Adams) 
    │   └── kupon.blade.php      (Adams) 
    ├── pesanan/
    │   ├── index.blade.php      (Adams) 
    │   └── detail.blade.php     (Adams) 
    ├── escrow.blade.php         (Adams) 
    ├── refund.blade.php         (Adams) 
    └── laporan.blade.php        (Adams) 
```

---

## 🎨 Rekomendasi Tech Stack Frontend

| Komponen      | Rekomendasi                          |
| ------------- | ------------------------------------ |
| CSS Framework | Tailwind CSS atau Bootstrap 5        |
| Icons         | Heroicons, Font Awesome, atau Lucide |
| Charts        | Chart.js untuk dashboard             |
| DataTables    | Laravel DataTables untuk tabel admin |
| Image Upload  | Filepond atau Dropzone.js            |
| Date Picker   | Flatpickr                            |
| Alerts        | SweetAlert2                          |

---

## 📝 Catatan Implementasi

1. **Layouts**: Buat layout berbeda untuk public, auth, dan dashboard (petani/admin)
2. **Components**: Manfaatkan Blade Components untuk elemen reusable
3. **Responsive**: Pastikan semua halaman mobile-friendly
4. **Flash Messages**: Tampilkan `session('success')` dan `session('error')`
5. **CSRF Token**: Semua form harus include `@csrf`
6. **Method Spoofing**: Untuk PUT/DELETE gunakan `@method('PUT')` atau `@method('DELETE')`
7. **Old Input**: Gunakan `old('field')` untuk form validation
8. **Error Display**: Gunakan `@error('field')` untuk tampilkan error validasi

---

_Dokumen ini dibuat berdasarkan `routes/web.php` TANAMI E-Commerce v2.0_
