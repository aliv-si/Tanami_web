# 📋 Backend Development Checklist - TANAMI E-Commerce v2.0

Dokumen ini berisi checklist lengkap untuk pengembangan backend TANAMI E-Commerce berdasarkan spesifikasi [SISTEM-MANAJEMEN-BASIS-DATA-LANJUT-V2.md](file:///c:/laragon/www/web_tanami/SISTEM-MANAJEMEN-BASIS-DATA-LANJUT-V2.md).

---

## 📊 Ringkasan Progress

| Fase | Nama                         | Status          | Progress |
| ---- | ---------------------------- | --------------- | -------- |
| 1    | Database & Migrations        | ✅ Selesai      | 100%     |
| 2    | Models & Relationships       | ✅ Selesai      | 100%     |
| 3    | Business Logic & Controllers | 🔄 Skeleton     | 20%      |
| 4    | Automation (Scheduled Jobs)  | ⏳ Pending      | 0%       |
| 5    | Audit & Logging              | ⏳ Pending      | 0%       |
| 6    | Admin Dashboard              | ⏳ Pending      | 0%       |
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

## **FASE 3: Business Logic & Controllers** 🔄 IN PROGRESS

### 3.1 Authentication

| Task               | Controller       | Method             | Status  |
| ------------------ | ---------------- | ------------------ | ------- |
| Show login form    | `AuthController` | `showLogin()`      | ⏳ TODO |
| Process login      | `AuthController` | `login()`          | ⏳ TODO |
| Show register form | `AuthController` | `showRegister()`   | ⏳ TODO |
| Process register   | `AuthController` | `register()`       | ⏳ TODO |
| Logout             | `AuthController` | `logout()`         | ⏳ TODO |
| Show profile       | `AuthController` | `showProfil()`     | ⏳ TODO |
| Update profile     | `AuthController` | `updateProfil()`   | ⏳ TODO |
| Change password    | `AuthController` | `updatePassword()` | ⏳ TODO |

**Detail Implementasi:**

-   [ ] Validasi email unique
-   [ ] Password min 8 karakter, harus di-hash dengan bcrypt
-   [ ] Session timeout 2 jam
-   [ ] Redirect berdasarkan role setelah login
-   [ ] Email verification (optional)

### 3.2 Katalog & Produk (Public)

| Task                 | Controller         | Method         | Status  |
| -------------------- | ------------------ | -------------- | ------- |
| List produk + filter | `ProdukController` | `katalog()`    | ⏳ TODO |
| Detail produk        | `ProdukController` | `show()`       | ⏳ TODO |
| Produk by kategori   | `ProdukController` | `byKategori()` | ⏳ TODO |

**Detail Implementasi:**

-   [ ] Filter by kategori
-   [ ] Search by nama produk
-   [ ] Sort: terbaru, termurah, termahal, terlaris
-   [ ] Pagination 12 per page
-   [ ] Tampilkan hanya produk aktif dengan stok tersedia
-   [ ] Load ulasan dan rating rata-rata

### 3.3 Keranjang (Shopping Cart)

| Task        | Controller            | Method      | Status  |
| ----------- | --------------------- | ----------- | ------- |
| Show cart   | `KeranjangController` | `index()`   | ⏳ TODO |
| Add to cart | `KeranjangController` | `store()`   | ⏳ TODO |
| Update qty  | `KeranjangController` | `update()`  | ⏳ TODO |
| Remove item | `KeranjangController` | `destroy()` | ⏳ TODO |
| Clear cart  | `KeranjangController` | `clear()`   | ⏳ TODO |

**Detail Implementasi:**

-   [ ] Cek stok tersedia sebelum add/update
-   [ ] Jika produk sudah ada, tambah qty (bukan duplikat)
-   [ ] Group items by petani untuk display
-   [ ] Hitung subtotal per item dan total keseluruhan

### 3.4 Checkout & Order ⭐

| Task             | Controller          | Method       | Status  |
| ---------------- | ------------------- | ------------ | ------- |
| Show checkout    | `PesananController` | `checkout()` | ⏳ TODO |
| Process checkout | `PesananController` | `store()`    | ⏳ TODO |
| List my orders   | `PesananController` | `index()`    | ⏳ TODO |
| Order detail     | `PesananController` | `show()`     | ⏳ TODO |

**Detail Implementasi Checkout:**

-   [ ] Load keranjang, validasi tidak kosong
-   [ ] Pilih kota tujuan → auto hitung ongkir
-   [ ] Input kode kupon → validasi & hitung diskon
-   [ ] Set `batas_bayar` = NOW + 24 JAM
-   [ ] Reserve stock (`stok_direserve`)
-   [ ] Create `pesanan` dengan status `pending`
-   [ ] Create `item_pesanan` untuk setiap item
-   [ ] Record `pemakaian_kupon` jika pakai kupon
-   [ ] Clear keranjang
-   [ ] Redirect ke halaman detail pesanan

### 3.5 Pembayaran & Upload Bukti ⭐

| Task             | Controller          | Method          | Status  |
| ---------------- | ------------------- | --------------- | ------- |
| Upload bukti     | `PesananController` | `uploadBukti()` | ⏳ TODO |
| Cancel order     | `PesananController` | `batal()`       | ⏳ TODO |
| Confirm received | `PesananController` | `konfirmasi()`  | ⏳ TODO |
| Request refund   | `PesananController` | `mintaRefund()` | ⏳ TODO |

**Detail Upload Bukti:**

-   [ ] Validasi: JPG/PNG, max 2MB
-   [ ] Simpan ke `storage/app/public/bukti-bayar/`
-   [ ] Update status → `menunggu_verifikasi`

**Detail Cancel:**

-   [ ] Hanya bisa jika status `pending` atau `menunggu_verifikasi`
-   [ ] Release reserved stock
-   [ ] Set `alasan_batal`, `tgl_dibatalkan`

**Detail Konfirmasi:**

-   [ ] Hanya bisa jika status `terkirim`
-   [ ] Update status → `selesai`
-   [ ] Set `tgl_selesai`, `id_konfirmasi`
-   [ ] Release escrow ke petani

### 3.6 Verifikasi Petani ⭐

| Task           | Controller                 | Method         | Status  |
| -------------- | -------------------------- | -------------- | ------- |
| List orders    | `Petani\PesananController` | `index()`      | ⏳ TODO |
| Order detail   | `Petani\PesananController` | `show()`       | ⏳ TODO |
| Verify payment | `Petani\PesananController` | `verifikasi()` | ⏳ TODO |
| Reject payment | `Petani\PesananController` | `tolak()`      | ⏳ TODO |
| Process order  | `Petani\PesananController` | `proses()`     | ⏳ TODO |
| Ship order     | `Petani\PesananController` | `kirim()`      | ⏳ TODO |

**Detail Verifikasi Payment:**

-   [ ] Hanya order dengan status `menunggu_verifikasi`
-   [ ] Update status → `dibayar`
-   [ ] Set `tgl_verifikasi`, `id_verifikator`
-   [ ] Kurangi stok aktual (produk.stok)
-   [ ] Release reserved stock
-   [ ] Create `escrow` dengan status `ditahan`

**Detail Reject Payment:**

-   [ ] Update status → `dibatalkan`
-   [ ] Set `alasan_tolak`, `tgl_dibatalkan`
-   [ ] Release reserved stock

**Detail Kirim:**

-   [ ] Input nomor resi
-   [ ] Update status → `dikirim`

### 3.7 Produk Management (Petani)

| Task          | Controller                | Method      | Status  |
| ------------- | ------------------------- | ----------- | ------- |
| List produk   | `Petani\ProdukController` | `index()`   | ⏳ TODO |
| Form tambah   | `Petani\ProdukController` | `create()`  | ⏳ TODO |
| Store produk  | `Petani\ProdukController` | `store()`   | ⏳ TODO |
| Form edit     | `Petani\ProdukController` | `edit()`    | ⏳ TODO |
| Update produk | `Petani\ProdukController` | `update()`  | ⏳ TODO |
| Delete produk | `Petani\ProdukController` | `destroy()` | ⏳ TODO |

**Detail Implementasi:**

-   [ ] Generate slug otomatis dari nama
-   [ ] Upload foto: JPG/PNG, max 5MB
-   [ ] Simpan ke `storage/app/public/produk/`
-   [ ] Tidak bisa delete jika ada reserved stock

### 3.8 Admin Features

| Task           | Controller                  | Method      | Status  |
| -------------- | --------------------------- | ----------- | ------- |
| Dashboard      | `Admin\DashboardController` | `index()`   | ⏳ TODO |
| CRUD Kategori  | `Admin\KategoriController`  | \*          | ⏳ TODO |
| CRUD Kota      | `Admin\KotaController`      | \*          | ⏳ TODO |
| CRUD Kupon     | `Admin\KuponController`     | \*          | ⏳ TODO |
| User list      | `Admin\PenggunaController`  | `index()`   | ⏳ TODO |
| Verify petani  | `Admin\PenggunaController`  | `verify()`  | ⏳ TODO |
| Monitor escrow | `Admin\EscrowController`    | `index()`   | ⏳ TODO |
| Approve refund | `Admin\RefundController`    | `approve()` | ⏳ TODO |
| Reject refund  | `Admin\RefundController`    | `reject()`  | ⏳ TODO |

---

## **FASE 4: Automation (Scheduled Jobs)** ⭐ ⏳ PENDING

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

## **FASE 5: Audit & Logging** ⭐ ⏳ PENDING

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
