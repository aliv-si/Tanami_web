# 📋 Backend Development Checklist - TANAMI E-Commerce v2.0

Dokumen ini berisi checklist lengkap untuk pengembangan backend TANAMI E-Commerce berdasarkan spesifikasi [SISTEM-MANAJEMEN-BASIS-DATA-LANJUT-V2.md](file:///c:/laragon/www/web_tanami/SISTEM-MANAJEMEN-BASIS-DATA-LANJUT-V2.md).

---

## 📊 Ringkasan Progress

| Fase | Nama                         | Status          | Progress |
| ---- | ---------------------------- | --------------- | -------- |
| 1    | Database & Migrations        | ✅ Selesai      | 100%     |
| 2    | Models & Relationships       | ✅ Selesai      | 100%     |
| 3    | Business Logic & Controllers | ✅ Selesai      | 100%     |
| 4    | Automation (Scheduled Jobs)  | ✅ Selesai      | 100%     |
| 5    | Audit & Logging              | ✅ Selesai      | 100%     |
| 6    | Admin Dashboard              | ✅ Selesai      | 100%     |
| 7    | API Endpoints                | ✅ Routes Ready | 30%      |
| 8    | Notifikasi                   | ⏳ Pending      | 0%       |

---

## **FASE 1: Database & Migrations** ✅ SELESAI

### 1.1 Tabel Master Data

| Tabel      | File Migration                                | Status | Deskripsi                                |
| ---------- | --------------------------------------------- | ------ | ---------------------------------------- |
| `pengguna` | `0001_01_01_000000_create_pengguna_table.php` | ✅     | User dengan role: admin, petani, pembeli |
| `kategori` | `2026_01_08_000001_create_kategori_table.php` | ✅     | Kategori produk dengan slug              |
| `kota`     | `2026_01_08_000002_create_kota_table.php`     | ✅     | Master kota + tarif ongkir               |
| `kupon`    | `2026_01_08_000003_create_kupon_table.php`    | ✅     | Voucher diskon (nominal/persen)          |

### 1.2 Tabel Produk

| Tabel             | File Migration                                       | Status | Deskripsi                                 |
| ----------------- | ---------------------------------------------------- | ------ | ----------------------------------------- |
| `produk`          | `2026_01_08_000004_create_produk_table.php`          | ✅     | Produk dengan `stok` dan `stok_direserve` |
| `keranjang`       | `2026_01_08_000005_create_keranjang_table.php`       | ✅     | Shopping cart per user                    |
| `rekening_petani` | `2026_01_08_000006_create_rekening_petani_table.php` | ✅     | Data rekening bank petani                 |

### 1.3 Tabel Transaksi

| Tabel             | File Migration                                       | Status | Deskripsi                |
| ----------------- | ---------------------------------------------------- | ------ | ------------------------ |
| `pesanan`         | `2026_01_08_000007_create_pesanan_table.php`         | ✅     | Order dengan 10 status   |
| `item_pesanan`    | `2026_01_08_000008_create_item_pesanan_table.php`    | ✅     | Detail item per order    |
| `escrow`          | `2026_01_08_000009_create_escrow_table.php`          | ✅     | Dana ditahan platform ⭐ |
| `histori_status`  | `2026_01_08_000010_create_histori_status_table.php`  | ✅     | Audit log status ⭐      |
| `pemakaian_kupon` | `2026_01_08_000011_create_pemakaian_kupon_table.php` | ✅     | Tracking kupon           |
| `ulasan`          | `2026_01_08_000012_create_ulasan_table.php`          | ✅     | Review produk            |

### 1.4 Seeders

| Seeder                 | Status | Data                                |
| ---------------------- | ------ | ----------------------------------- |
| `PenggunaSeeder`       | ✅     | Admin, 2 Petani, 2 Pembeli          |
| `KategoriSeeder`       | ✅     | Sayuran, Buah, Bumbu, Beras, dll    |
| `KotaSeeder`           | ✅     | Jakarta, Surabaya, Bandung + ongkir |
| `KuponSeeder`          | ✅     | Sample kupon aktif                  |
| `ProdukSeeder`         | ✅     | Sample produk dari petani           |
| `RekeningPetaniSeeder` | ✅     | Data rekening bank                  |

---

## **FASE 2: Models & Relationships** ✅ SELESAI

### 2.1 Daftar Models

| Model            | File                            | Status | Relasi Utama                                |
| ---------------- | ------------------------------- | ------ | ------------------------------------------- |
| `Pengguna`       | `app/Models/Pengguna.php`       | ✅     | hasMany: produk, pesanan, ulasan, keranjang |
| `Kategori`       | `app/Models/Kategori.php`       | ✅     | hasMany: produk                             |
| `Kota`           | `app/Models/Kota.php`           | ✅     | hasMany: pesanan                            |
| `Kupon`          | `app/Models/Kupon.php`          | ✅     | hasMany: pemakaian                          |
| `Produk`         | `app/Models/Produk.php`         | ✅     | belongsTo: petani, kategori                 |
| `Keranjang`      | `app/Models/Keranjang.php`      | ✅     | belongsTo: pengguna, produk                 |
| `RekeningPetani` | `app/Models/RekeningPetani.php` | ✅     | belongsTo: petani                           |
| `Pesanan`        | `app/Models/Pesanan.php`        | ✅     | hasMany: items, historiStatus               |
| `ItemPesanan`    | `app/Models/ItemPesanan.php`    | ✅     | belongsTo: pesanan, produk                  |
| `Escrow`         | `app/Models/Escrow.php`         | ✅     | belongsTo: pesanan, penerima                |
| `HistoriStatus`  | `app/Models/HistoriStatus.php`  | ✅     | belongsTo: pesanan, pengubah                |
| `PemakaianKupon` | `app/Models/PemakaianKupon.php` | ✅     | belongsTo: kupon, pesanan                   |
| `Ulasan`         | `app/Models/Ulasan.php`         | ✅     | belongsTo: produk, pengguna                 |

### 2.2 Helper Methods di Model

| Model      | Method                                   | Fungsi                     |
| ---------- | ---------------------------------------- | -------------------------- |
| `Pengguna` | `isAdmin()`, `isPetani()`, `isPembeli()` | Cek role user              |
| `Produk`   | `stokTersedia()`                         | Hitung stok available      |
| `Produk`   | `reserveStok($qty)`                      | Reserve stok saat checkout |
| `Produk`   | `releaseStok($qty)`                      | Release stok saat cancel   |
| `Produk`   | `kurangiStok($qty)`                      | Kurangi stok aktual        |
| `Kupon`    | `isValid()`                              | Cek validitas kupon        |
| `Kupon`    | `hitungDiskon($subtotal)`                | Hitung nominal diskon      |
| `Pesanan`  | `isTimeout()`                            | Cek apakah sudah timeout   |
| `Pesanan`  | `bisaDibatalkan()`                       | Cek bisa cancel            |
| `Pesanan`  | `bisaUploadBukti()`                      | Cek bisa upload            |
| `Pesanan`  | `bisaDiverifikasi()`                     | Cek bisa verifikasi        |
| `Pesanan`  | `bisaDikonfirmasi()`                     | Cek bisa konfirmasi        |
| `Escrow`   | `kirimKePetani($id)`                     | Release ke petani          |
| `Escrow`   | `refundKePembeli($id)`                   | Refund ke pembeli          |

---

## **FASE 3: Business Logic & Controllers** ✅ SELESAI

### 3.1 Authentication

| Task               | Controller       | Method             | Status  |
| ------------------ | ---------------- | ------------------ | ------- |
| Show login form    | `AuthController` | `showLogin()`      | ✅ DONE |
| Process login      | `AuthController` | `login()`          | ✅ DONE |
| Show register form | `AuthController` | `showRegister()`   | ✅ DONE |
| Process register   | `AuthController` | `register()`       | ✅ DONE |
| Logout             | `AuthController` | `logout()`         | ✅ DONE |
| Show profile       | `AuthController` | `showProfil()`     | ✅ DONE |
| Update profile     | `AuthController` | `updateProfil()`   | ✅ DONE |
| Change password    | `AuthController` | `updatePassword()` | ✅ DONE |

**Detail Implementasi:**

-   [x] Validasi email unique
-   [x] Password min 8 karakter, harus di-hash dengan bcrypt
-   [x] Session timeout 2 jam
-   [x] Redirect berdasarkan role setelah login
-   [ ] Email verification (optional)

### 3.2 Katalog & Produk (Public)

| Task                 | Controller         | Method         | Status  |
| -------------------- | ------------------ | -------------- | ------- |
| List produk + filter | `ProdukController` | `katalog()`    | ✅ DONE |
| Detail produk        | `ProdukController` | `show()`       | ✅ DONE |
| Produk by kategori   | `ProdukController` | `byKategori()` | ✅ DONE |

**Detail Implementasi:**

-   [x] Filter by kategori
-   [x] Search by nama produk
-   [x] Sort: terbaru, termurah, termahal, terlaris
-   [x] Pagination 12 per page
-   [x] Tampilkan hanya produk aktif dengan stok tersedia
-   [x] Load ulasan dan rating rata-rata

### 3.3 Keranjang (Shopping Cart)

| Task        | Controller            | Method      | Status  |
| ----------- | --------------------- | ----------- | ------- |
| Show cart   | `KeranjangController` | `index()`   | ✅ DONE |
| Add to cart | `KeranjangController` | `store()`   | ✅ DONE |
| Update qty  | `KeranjangController` | `update()`  | ✅ DONE |
| Remove item | `KeranjangController` | `destroy()` | ✅ DONE |
| Clear cart  | `KeranjangController` | `clear()`   | ✅ DONE |

**Detail Implementasi:**

-   [x] Cek stok tersedia sebelum add/update
-   [x] Jika produk sudah ada, tambah qty (bukan duplikat)
-   [x] Group items by petani untuk display
-   [x] Hitung subtotal per item dan total keseluruhan

### 3.4 Checkout & Order ⭐

| Task             | Controller          | Method       | Status  |
| ---------------- | ------------------- | ------------ | ------- |
| Show checkout    | `PesananController` | `checkout()` | ✅ DONE |
| Process checkout | `PesananController` | `store()`    | ✅ DONE |
| List my orders   | `PesananController` | `index()`    | ✅ DONE |
| Order detail     | `PesananController` | `show()`     | ✅ DONE |

**Detail Implementasi Checkout:**

-   [x] Load keranjang, validasi tidak kosong
-   [x] Pilih kota tujuan → auto hitung ongkir
-   [x] Input kode kupon → validasi & hitung diskon
-   [x] Set `batas_bayar` = NOW + 24 JAM
-   [x] Reserve stock (`stok_direserve`)
-   [x] Create `pesanan` dengan status `pending`
-   [x] Create `item_pesanan` untuk setiap item
-   [x] Record `pemakaian_kupon` jika pakai kupon
-   [x] Clear keranjang
-   [x] Redirect ke halaman detail pesanan

### 3.5 Pembayaran & Upload Bukti ⭐

| Task             | Controller          | Method          | Status  |
| ---------------- | ------------------- | --------------- | ------- |
| Upload bukti     | `PesananController` | `uploadBukti()` | ✅ DONE |
| Cancel order     | `PesananController` | `batal()`       | ✅ DONE |
| Confirm received | `PesananController` | `konfirmasi()`  | ✅ DONE |
| Request refund   | `PesananController` | `mintaRefund()` | ✅ DONE |

**Detail Upload Bukti:**

-   [x] Validasi: JPG/PNG, max 2MB
-   [x] Simpan ke `storage/app/public/bukti-bayar/`
-   [x] Update status → `menunggu_verifikasi`

**Detail Cancel:**

-   [x] Hanya bisa jika status `pending` atau `menunggu_verifikasi`
-   [x] Release reserved stock
-   [x] Set `alasan_batal`, `tgl_dibatalkan`

**Detail Konfirmasi:**

-   [x] Hanya bisa jika status `terkirim`
-   [x] Update status → `selesai`
-   [x] Set `tgl_selesai`, `id_konfirmasi`
-   [x] Release escrow ke petani

### 3.6 Verifikasi Petani ⭐

| Task           | Controller                 | Method         | Status  |
| -------------- | -------------------------- | -------------- | ------- |
| List orders    | `Petani\PesananController` | `index()`      | ✅ DONE |
| Order detail   | `Petani\PesananController` | `show()`       | ✅ DONE |
| Verify payment | `Petani\PesananController` | `verifikasi()` | ✅ DONE |
| Reject payment | `Petani\PesananController` | `tolak()`      | ✅ DONE |
| Process order  | `Petani\PesananController` | `proses()`     | ✅ DONE |
| Ship order     | `Petani\PesananController` | `kirim()`      | ✅ DONE |

**Detail Verifikasi Payment:**

-   [x] Hanya order dengan status `menunggu_verifikasi`
-   [x] Update status → `dibayar`
-   [x] Set `tgl_verifikasi`, `id_verifikator`
-   [x] Kurangi stok aktual (produk.stok)
-   [x] Release reserved stock
-   [x] Create `escrow` dengan status `ditahan`

**Detail Reject Payment:**

-   [x] Update status → `dibatalkan`
-   [x] Set `alasan_tolak`, `tgl_dibatalkan`
-   [x] Release reserved stock

**Detail Kirim:**

-   [x] Input nomor resi
-   [x] Update status → `dikirim`

### 3.7 Produk Management (Petani)

| Task          | Controller                | Method      | Status  |
| ------------- | ------------------------- | ----------- | ------- |
| List produk   | `Petani\ProdukController` | `index()`   | ✅ DONE |
| Form tambah   | `Petani\ProdukController` | `create()`  | ✅ DONE |
| Store produk  | `Petani\ProdukController` | `store()`   | ✅ DONE |
| Form edit     | `Petani\ProdukController` | `edit()`    | ✅ DONE |
| Update produk | `Petani\ProdukController` | `update()`  | ✅ DONE |
| Delete produk | `Petani\ProdukController` | `destroy()` | ✅ DONE |

**Detail Implementasi:**

-   [x] Generate slug otomatis dari nama
-   [x] Upload foto: JPG/PNG, max 5MB
-   [x] Simpan ke `storage/app/public/produk/`
-   [x] Tidak bisa delete jika ada reserved stock

### 3.8 Admin Features

| Task           | Controller                  | Method      | Status  |
| -------------- | --------------------------- | ----------- | ------- |
| Dashboard      | `Admin\DashboardController` | `index()`   | ✅ DONE |
| CRUD Kategori  | `Admin\KategoriController`  | \*          | ✅ DONE |
| CRUD Kota      | `Admin\KotaController`      | \*          | ✅ DONE |
| CRUD Kupon     | `Admin\KuponController`     | \*          | ✅ DONE |
| User list      | `Admin\PenggunaController`  | `index()`   | ✅ DONE |
| Verify petani  | `Admin\PenggunaController`  | `verify()`  | ✅ DONE |
| Monitor escrow | `Admin\EscrowController`    | `index()`   | ✅ DONE |
| Approve refund | `Admin\RefundController`    | `approve()` | ✅ DONE |
| Reject refund  | `Admin\RefundController`    | `reject()`  | ✅ DONE |

### 3.9 Petani Dashboard ✅ DONE

| Task            | Controller                   | Method    | Status  |
| --------------- | ---------------------------- | --------- | ------- |
| Dashboard stats | `Petani\DashboardController` | `index()` | ✅ DONE |

**Data yang Dibutuhkan (dari Blade):**

-   [x] `totalProducts` - COUNT produk milik petani
-   [x] `productGrowth` - Persentase pertumbuhan produk (opsional)
-   [x] `activeOrders` - COUNT pesanan aktif (dibayar, diproses, dikirim)
-   [x] `totalSales` - SUM total_bayar dari pesanan selesai
-   [x] `salesGrowth` - Persentase pertumbuhan sales (opsional)
-   [x] `availableBalance` - SUM escrow status dikirim ke petani ini
-   [x] `recentOrders` - 5 pesanan terbaru
-   [x] `rating.score` - AVG rating dari ulasan produk petani
-   [x] `rating.totalReviews` - COUNT ulasan produk petani
-   [x] `rating.productQuality` - Persentase kualitas (opsional)
-   [x] `rating.deliverySpeed` - Persentase kecepatan (opsional)

### 3.10 Ulasan / Review ✅ DONE

| Task               | Controller                | Method    | Status  |
| ------------------ | ------------------------- | --------- | ------- |
| List ulasan petani | `Petani\UlasanController` | `index()` | ✅ DONE |
| Buat ulasan        | `UlasanController`        | `store()` | ✅ DONE |

**Data Petani Ulasan (dari Blade):**

-   [x] `ratingStats.average` - AVG rating semua produk petani
-   [x] `ratingStats.totalReviews` - COUNT total ulasan
-   [x] `ratingStats.distribution` - COUNT per rating (1-5 bintang)
-   [x] `reviews[]` - List ulasan dengan: customerName, rating, date, product, comment, reply

**Fitur Buat Ulasan (Pembeli):**

-   [x] Validasi: hanya bisa review jika pesanan selesai
-   [x] Rating 1-5 bintang (required)
-   [x] Komentar (opsional)
-   [x] Satu ulasan per produk per pesanan

---

## **FASE 4: Automation (Scheduled Jobs)** ⭐ ✅ SELESAI

### 4.1 Auto-Cancel Timeout Pembayaran (24 Jam)

| Item          | Detail                                                            |
| ------------- | ----------------------------------------------------------------- |
| **Job Class** | `App\Console\Commands\CancelTimeoutPayment`                       |
| **Schedule**  | Setiap 1 jam                                                      |
| **Kondisi**   | Status `pending` DAN `batas_bayar < NOW` DAN `bukti_bayar = NULL` |
| **Action**    | Status → `dibatalkan`, release reserved stock                     |
| **Alasan**    | "Timeout pembayaran - 24 jam"                                     |

### 4.2 Auto-Cancel Timeout Verifikasi Petani (48 Jam)

| Item          | Detail                                                            |
| ------------- | ----------------------------------------------------------------- |
| **Job Class** | `App\Console\Commands\CancelTimeoutVerification`                  |
| **Schedule**  | Setiap 1 jam                                                      |
| **Kondisi**   | Status `menunggu_verifikasi` DAN `tgl_update + 48 jam < NOW`      |
| **Action**    | Status → `dibatalkan`, release stock, auto-refund jika ada escrow |
| **Alasan**    | "Farmer no response - timeout 48 hours"                           |

### 4.3 Auto-Complete Order (3 Hari)

| Item          | Detail                                                                       |
| ------------- | ---------------------------------------------------------------------------- |
| **Job Class** | `App\Console\Commands\AutoCompleteOrder`                                     |
| **Schedule**  | Setiap 6 jam                                                                 |
| **Kondisi**   | Status `terkirim` DAN `tgl_update + 3 hari < NOW`                            |
| **Action**    | Status → `selesai`, escrow → `dikirim_ke_petani`, set `tgl_selesai_otomatis` |

### 4.4 Reminder Payment (Opsional)

| Item          | Detail                                           |
| ------------- | ------------------------------------------------ |
| **Job Class** | `App\Console\Commands\SendPaymentReminder`       |
| **Schedule**  | Setiap 6 jam                                     |
| **Kondisi**   | Status `pending` DAN `batas_bayar - 6 jam < NOW` |
| **Action**    | Kirim email reminder                             |

---

## **FASE 5: Audit & Logging** ⭐ ✅ SELESAI

### 5.1 Observer untuk Pesanan

| Item               | Detail                          |
| ------------------ | ------------------------------- |
| **Observer Class** | `App\Observers\PesananObserver` |
| **Event**          | `updated`                       |
| **Kondisi**        | `status_pesanan` berubah        |
| **Action**         | Insert ke `histori_status`      |

### 5.2 Data yang Di-log

| Field         | Value                                         |
| ------------- | --------------------------------------------- |
| `id_pesanan`  | ID pesanan yang berubah                       |
| `status_lama` | Status sebelum berubah                        |
| `status_baru` | Status setelah berubah                        |
| `id_pengubah` | ID user yang mengubah (atau NULL jika system) |
| `alasan`      | Alasan perubahan (opsional)                   |
| `tgl_dibuat`  | Timestamp                                     |

---

## **FASE 6: Admin Dashboard** ⏳ PENDING

### 6.1 Dashboard Statistics

| Metric                        | Query                                |
| ----------------------------- | ------------------------------------ |
| GMV (Gross Merchandise Value) | SUM total_bayar dari pesanan selesai |
| Total Transaksi               | COUNT pesanan (bukan pending/cancel) |
| Total Pembeli                 | COUNT user role pembeli              |
| Total Petani                  | COUNT user role petani               |
| Petani Pending Verifikasi     | COUNT petani is_verified = false     |
| Escrow Ditahan                | SUM escrow status ditahan            |
| Pending Refund                | COUNT pesanan status minta_refund    |

### 6.2 Master Data Management

-   [ ] CRUD Kategori (nama, slug, deskripsi)
-   [ ] CRUD Kota (nama, provinsi, ongkir, is_aktif)
-   [ ] CRUD Kupon (kode, tipe, nominal/persen, min_belanja, limit, periode)

### 6.3 User Management

-   [ ] List semua user dengan filter role
-   [ ] Detail user dengan history pesanan/produk
-   [ ] Verifikasi akun petani baru
-   [ ] Deaktivasi akun (soft delete)

### 6.4 Transaction Monitoring

-   [ ] List semua pesanan dengan filter status
-   [ ] Detail pesanan dengan histori status
-   [ ] Monitor escrow (ditahan, dikirim, direfund)
-   [ ] Handle refund request (approve/reject)

---

## **FASE 7: API Endpoints** ✅ ROUTES READY

API endpoints sudah didefinisikan di `routes/api.php` dengan prefix `/api/v1/`.

### Public Endpoints

| Method | Endpoint              | Deskripsi           |
| ------ | --------------------- | ------------------- |
| POST   | `/auth/register`      | Register user baru  |
| POST   | `/auth/login`         | Login               |
| GET    | `/produk`             | List produk         |
| GET    | `/produk/{slug}`      | Detail produk       |
| GET    | `/produk/{id}/ulasan` | Ulasan produk       |
| GET    | `/kategori`           | List kategori       |
| GET    | `/kota`               | List kota + ongkir  |
| POST   | `/kupon/validasi`     | Validasi kode kupon |

### Protected Endpoints (Auth Required)

| Method | Endpoint                     | Deskripsi        |
| ------ | ---------------------------- | ---------------- |
| POST   | `/auth/logout`               | Logout           |
| GET    | `/auth/me`                   | Get current user |
| GET    | `/keranjang`                 | Get cart         |
| POST   | `/keranjang`                 | Add to cart      |
| POST   | `/checkout`                  | Create order     |
| GET    | `/pesanan`                   | List orders      |
| POST   | `/pesanan/{id}/upload-bukti` | Upload bukti     |
| POST   | `/ulasan`                    | Create review    |

### Petani Endpoints

| Method | Endpoint                          | Deskripsi       |
| ------ | --------------------------------- | --------------- |
| GET    | `/petani/dashboard`               | Dashboard stats |
| CRUD   | `/petani/produk/*`                | Manage produk   |
| GET    | `/petani/pesanan`                 | Incoming orders |
| POST   | `/petani/pesanan/{id}/verifikasi` | Verify payment  |

### Admin Endpoints

| Method | Endpoint                     | Deskripsi       |
| ------ | ---------------------------- | --------------- |
| GET    | `/admin/dashboard`           | Admin stats     |
| CRUD   | `/admin/kategori/*`          | Manage kategori |
| CRUD   | `/admin/kota/*`              | Manage kota     |
| CRUD   | `/admin/kupon/*`             | Manage kupon    |
| GET    | `/admin/escrow`              | Monitor escrow  |
| POST   | `/admin/refund/{id}/approve` | Approve refund  |

---

## **FASE 8: Notifikasi** ⏳ PENDING

### 8.1 Email Notifications

| Event                   | Recipient        | Template           |
| ----------------------- | ---------------- | ------------------ |
| Registrasi berhasil     | User             | `welcome`          |
| Pesanan dibuat          | Pembeli + Petani | `order-created`    |
| Bukti bayar diupload    | Petani           | `payment-uploaded` |
| Pembayaran diverifikasi | Pembeli          | `payment-verified` |
| Pesanan dikirim         | Pembeli          | `order-shipped`    |
| Pesanan selesai         | Pembeli + Petani | `order-completed`  |
| Request refund          | Admin            | `refund-requested` |
| Refund approved         | Pembeli          | `refund-approved`  |
| Reminder bayar (6 jam)  | Pembeli          | `payment-reminder` |

### 8.2 Implementation

-   [ ] Buat Mailable class untuk setiap template
-   [ ] Gunakan Queue untuk async email
-   [ ] Setup SMTP di `.env`

---

## **Urutan Implementasi (Rekomendasi)**

```
1. ✅ Database & Migrations
2. ✅ Models & Relationships
3. ✅ Routes (web.php + api.php)
4. ✅ Controller Skeletons
5. ⏳ Authentication (Login, Register, Logout)
6. ⏳ Katalog & Produk Public
7. ⏳ Keranjang & Checkout
8. ⏳ Order Flow (upload bukti, verifikasi, kirim)
9. ⏳ Escrow System
10. ⏳ Refund Flow
11. ⏳ Petani Features (CRUD produk, rekening)
12. ⏳ Admin Features (master data, monitoring)
13. ⏳ Scheduled Jobs (auto-cancel, auto-complete)
14. ⏳ Audit Logging
15. ⏳ Email Notifications
16. ⏳ Testing & Bug Fixes
```

---

## **Tech Stack**

| Layer        | Technology              |
| ------------ | ----------------------- |
| Framework    | Laravel 11              |
| Database     | MySQL 8.0               |
| Auth         | Laravel Session-based   |
| File Storage | Laravel Storage (local) |
| Email        | Laravel Mail + Queue    |
| Scheduler    | Laravel Task Scheduling |
| Frontend     | Blade Templates         |

---

## **Catatan Penting**

1. **Bahasa Indonesia**: Semua nama tabel dan field menggunakan bahasa Indonesia sesuai spesifikasi
2. **Status Flow**: Perhatikan urutan status yang valid untuk setiap transisi
3. **Stok Management**: Selalu gunakan `stok_direserve` untuk mencegah overselling
4. **Escrow**: Dana harus ditahan di escrow sampai pembeli konfirmasi atau timeout
5. **Audit Trail**: Semua perubahan status harus di-log ke `histori_status`

---

_Dokumen ini dibuat untuk tim development TANAMI E-Commerce v2.0_
