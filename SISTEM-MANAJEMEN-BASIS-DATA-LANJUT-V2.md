# **SISTEM MANAJEMEN BASIS DATA LANJUT**

![][image1]

Dosen Pengampu:   
Wiwi Widayani, S.Kom., M.Kom

Disusun Oleh:  
**YUDISTIRA AZFA DANI WIBOWO	24.12.3274**  
**MUHAMMAD ADAM SISWANTORO	24.12.3281**  
**WASIMA JUHAINA			24.12.3282**  
**ALIEF FATHIN ADI KUSUMA		24.12.3303**  
**LUQMAN ADIWIDYA			24.12.3280**

**PROGRAM STUDI SISTEM INFORMASI**  
**FAKULTAS ILMU KOMPUTER**  
**UNIVERSITAS AMIKOM YOGYAKARTA**   
**2025**

---

# **📋 UPDATE LOG - Versi 2.0 (29 Desember 2025)**

## **🔥 PERUBAHAN MAJOR SISTEM**

Sistem **TANAMI E-Commerce** telah mengalami **major update** dengan penambahan fitur-fitur modern dan aman seperti marketplace besar (Tokopedia, Shopee, Bukalapak). Berikut ringkasan perubahannya:

### **1. ⏰ Timeout Pembayaran: 30 Menit → 24 JAM**

**Sebelum:**
- ❌ Customer harus upload bukti bayar dalam **30 MENIT**
- ❌ Terlalu ketat, banyak order cancel sia-sia

**Setelah:**
- ✅ Customer punya waktu **24 JAM** untuk upload bukti
- ✅ Lebih fleksibel dan user-friendly
- ✅ Field database: `batas_bayar` = NOW() + 24 JAM

### **2. 💰 Sistem Escrow: Dana Ditahan Platform (BARU)**

**Sebelum:**
- ❌ Dana transfer langsung ke rekening petani
- ❌ Risiko tinggi jika barang tidak sampai/rusak

**Setelah:**
- ✅ Dana **DITAHAN** oleh platform (Escrow)
- ✅ Dana baru dikirim ke petani setelah pembeli konfirmasi
- ✅ Jika ada masalah → dana **AUTO-REFUND** ke pembeli
- ✅ Tabel baru: **`escrow`** dengan status: ditahan, dikirim_ke_petani, direfund_ke_pembeli

### **3. ⏰ Timeout Verifikasi Petani: 48 JAM (BARU)**

**Sebelum:**
- ❌ Petani bisa pending pembayaran berhari-hari

**Setelah:**
- ✅ Petani **WAJIB** verifikasi dalam **48 JAM**
- ✅ Jika lewat → order **AUTO-CANCEL** + **AUTO-REFUND**

### **4. ⚡ Auto-Complete: 3 Hari Setelah Terkirim (BARU)**

**Sebelum:**
- ❌ Menunggu customer konfirmasi selamanya
- ❌ Banyak order pending karena customer lupa

**Setelah:**
- ✅ Jika customer tidak konfirmasi dalam **3 HARI**
- ✅ Order **AUTO-COMPLETE**, dana **AUTO-DIKIRIM** ke petani

### **5. 📝 Audit Log: Histori Status Lengkap (BARU)**

**Sebelum:**
- ❌ Tidak ada log perubahan status

**Setelah:**
- ✅ Setiap perubahan status **TERCATAT OTOMATIS**
- ✅ Tabel baru: **`histori_status`**
- ✅ Trigger database: `trg_log_perubahan_status`

---

# **Deskripsi Sistem**

**TANAMI** merupakan sebuah sistem informasi berbasis web yang menggabungkan fungsi *Company Profile* dan *E-commerce*. Web ini bertujuan untuk memperkenalkan brand TANAMI sebagai penyedia solusi penghijauan (tanaman hias, bibit, pupuk, alat berkebun) sekaligus menjadi platform transaksi jual-beli online yang memudahkan pelanggan mendapatkan produk pertanian urban.

**Fitur Utama Versi 2.0:**
- ✅ Sistem Escrow untuk keamanan transaksi
- ✅ Auto-cancel timeout pembayaran (24 jam)
- ✅ Auto-complete pesanan (3 hari setelah terkirim)
- ✅ Audit log lengkap untuk transparansi
- ✅ Database bahasa Indonesia untuk kemudahan maintenance

---

# **Ruang Lingkup Proses**

## **Manajemen Pengguna**
- Tambah Akun (email, nama, username, password, no telpon, alamat, tanggal lahir)  
- Autentikasi berbasis role (Customer, Farmer, Admin)  
- Manajemen profil dan preferensi pengguna

## **Manajemen Produk dan Inventaris** 
- Pengelolaan data CRUD  
- Upload foto produk dan deskripsi detail
- **Stok management dengan reserved stock** (24 jam)

## **Sistem Pre-Order dan Transaksi**
- Proses pre-order dengan validasi periode dan stok  
- Shopping cart dengan grouping berdasarkan farmer
- **Sistem Escrow untuk keamanan pembayaran** ⭐

## **Manajemen Pengiriman**
- Opsi self-pickup dengan time slot scheduling   
- Opsi delivery dengan kalkulasi ongkir berdasarkan area 

## **Review dan Rating**
- Customer review produk setelah delivery confirmed  
- Rating system untuk farmer dan produk  
- Farmer response mechanism

---

# **Tujuan**

1. Membangun *branding* TANAMI yang profesional dan terpercaya.  
2. Mempermudah proses pemesanan dan pembayaran produk secara digital dengan **sistem escrow yang aman**. ⭐
3. Mengelola stok barang secara *real-time* untuk menghindari kesalahan data.
4. **Otomasi penuh** untuk timeout management dan auto-complete pesanan. ⭐

---

# **Identifikasi Pengguna dan Kebutuhannya**

## **Pembeli (Customer)**

### Kebutuhan Fungsional:  
- Registrasi akun dengan verifikasi email  
- Melihat katalog produk berdasarkan kategori dan pencarian  
- Menambahkan produk ke keranjang belanja (Cart) dengan stok reserved  
- Memilih kota/alamat pengiriman saat checkout agar biaya ongkir muncul otomatis  
- Memasukkan kode voucher (jika ada) dengan validasi realtime  
- **Upload bukti pembayaran dalam 24 JAM** (format: JPG/PNG, max 2MB) ⭐
- Melacak status pesanan (Pending → Menunggu Verifikasi → Dibayar → Dikirim → Terkirim → Selesai)
- Membatalkan pesanan sebelum pembayaran diverifikasi  
- **Konfirmasi penerimaan barang dalam 3 HARI** (jika tidak → auto-complete) ⭐
- Memberikan ulasan (Review) pada item produk yang telah dibeli  
- Menerima notifikasi email saat status order berubah

### Kebutuhan Non-Fungsional:  
- Password terenkripsi (bcrypt/hash)  
- Session timeout 2 jam
- **Dana aman di escrow platform** ⭐

---

## **Petani (Seller)**

### Kebutuhan Fungsional:  
- CRUD data produk milik sendiri (tidak bisa edit produk petani lain)  
- Upload gambar produk (max 5MB, format JPG/PNG)  
- Melihat daftar pesanan masuk (*Incoming Orders*) yang sudah dibayar  
- **Verifikasi/tolak bukti transfer dalam 48 JAM** (jika tidak → auto-cancel) ⭐
- Mengupdate status pesanan menjadi "Dikirim" dengan input nomor resi  
- Melihat dan merespons ulasan dari pembeli  
- Mengelola informasi rekening bank untuk menerima pembayaran  
- Dashboard analitik: total penjualan, produk terlaris, rating rata-rata
- **Menerima dana dari escrow setelah pembeli konfirmasi** ⭐

### Kebutuhan Non-Fungsional:  
- Kontrol akses berbasis peran (RBAC)  
- Audit log untuk perubahan data produk
- **Transparansi alur dana via escrow** ⭐

---

## **Admin (Pemilik Platform)**

### Kebutuhan Fungsional:  
- Mengelola Data Kota & Tarif Ongkir (CRUD Master Data)  
- Mengelola Data Kupon Diskon (Kode, Jumlah/Persentase Potongan, Masa Berlaku, Usage Limit, Min Purchase)  
- **Monitoring semua transaksi escrow** ⭐
- Verifikasi akun petani baru (approval system)  
- Broadcast notifikasi promo ke semua user  
- Dashboard platform: total GMV, jumlah transaksi, user aktif
- **Monitoring auto-cancel dan auto-complete** ⭐

---

# **Rule Bisnis (UPDATE VERSION 2.0)** ⭐

## **1. Logika Timeout Pembayaran (DIPERBARUI)**

**PERUBAHAN: 30 MENIT → 24 JAM**

- Customer harus upload bukti bayar dalam **24 JAM** setelah checkout
- Field database: `batas_bayar` = `NOW() + INTERVAL 24 HOUR`
- Jika lewat 24 jam tanpa bukti → order **AUTO-CANCEL**
- Reserved stock **di-release** kembali ke available stock
- Stored Procedure: `sp_batalkan_pesanan_timeout()` jalan setiap **1 JAM**

**Contoh:**
```
Checkout: Senin 10:00 pagi
Batas upload: Selasa 10:00 pagi (24 jam)
Jika Selasa 10:01 belum upload → AUTO CANCEL
```

---

## **2. Logika Sistem Escrow (BARU)** ⭐

**Dana TIDAK langsung masuk ke rekening petani, tapi DITAHAN oleh platform (Escrow)**

### **Alur Escrow:**

1. **Customer Upload Bukti Bayar**
   - Status: `menunggu_verifikasi`
   - Petani punya **48 JAM** untuk verifikasi

2. **Petani Verifikasi → APPROVE**
   - Status: `dibayar`
   - Dana **DITAHAN** platform (Escrow)
   - Escrow status: `ditahan`
   - Stok aktual dikurangi

3. **Petani Kirim Barang**
   - Status: `dikirim`
   - Input nomor resi
   - Dana masih **DITAHAN** platform

4. **Barang Sampai**
   - Status: `terkirim`
   - Customer punya **3 HARI** untuk konfirmasi

5. **Customer Konfirmasi OK**
   - Status: `selesai`
   - Dana **DIKIRIM** ke rekening petani 💵
   - Escrow status: `dikirim_ke_petani`

6. **Jika Customer Komplain**
   - Status: `minta_refund`
   - Admin review
   - Jika valid → Status: `direfund`
   - Dana **DI-REFUND** ke customer 💵
   - Escrow status: `direfund_ke_pembeli`

### **Database Escrow:**

```sql
CREATE TABLE escrow (
    id_escrow INT PRIMARY KEY AUTO_INCREMENT,
    id_pesanan INT UNIQUE NOT NULL,
    jumlah DECIMAL(10,2) NOT NULL,
    status_escrow ENUM('ditahan','dikirim_ke_petani','direfund_ke_pembeli'),
    tgl_ditahan TIMESTAMP,
    tgl_kirim TIMESTAMP,
    id_penerima INT,  -- ID petani atau customer
    catatan TEXT,
    tgl_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan),
    FOREIGN KEY (id_penerima) REFERENCES pengguna(id_pengguna)
);
```

---

## **3. Logika Timeout Verifikasi Petani (BARU)** ⭐

- Petani **WAJIB** verifikasi pembayaran dalam **48 JAM**
- Dihitung dari `tgl_update` saat status `menunggu_verifikasi`
- Jika lewat 48 jam:
  - Order **AUTO-CANCEL**
  - Dana **AUTO-REFUND** ke customer
  - Reserved stock **di-release**
  - Alasan: "Farmer no response - timeout 48 hours"

**Implementasi:**
```sql
-- Cek via Stored Procedure
IF (NOW() - tgl_update) > 48 JAM AND status = 'menunggu_verifikasi'
THEN
  -- Auto-cancel + refund
END IF
```

---

## **4. Logika Auto-Complete (BARU)** ⭐

- Jika customer **TIDAK** konfirmasi dalam **3 HARI** setelah `terkirim`
- Order **AUTO-COMPLETE**
- Dana **AUTO-DIKIRIM** ke petani
- Field: `tgl_selesai_otomatis` = NOW()
- Stored Procedure: `sp_selesaikan_pesanan_otomatis()` jalan setiap **6 JAM**

**Timeline:**
```
Senin 10:00 → Barang terkirim (status: terkirim)
Kamis 10:01 → AUTO-COMPLETE (3 hari lebih 1 menit)
Dana dikirim ke petani
```

**Manfaat:**
- ✅ Customer punya waktu 3 hari untuk komplain
- ✅ Petani pasti dapat dana (tidak pending selamanya)
- ✅ Win-win solution

---

## **5. Logika Audit Log (BARU)** ⭐

- Setiap perubahan status pesanan **DICATAT OTOMATIS**
- Tabel: `histori_status`
- Fields: status_lama, status_baru, id_pengubah, alasan, tgl_dibuat
- Trigger: `trg_log_perubahan_status` (AFTER UPDATE ON pesanan)

**Implementasi:**
```sql
CREATE TRIGGER trg_log_perubahan_status
AFTER UPDATE ON pesanan
FOR EACH ROW
BEGIN
    IF OLD.status_pesanan != NEW.status_pesanan THEN
        INSERT INTO histori_status (
            id_pesanan, 
            status_lama, 
            status_baru, 
            alasan
        ) VALUES (
            NEW.id_pesanan, 
            OLD.status_pesanan, 
            NEW.status_pesanan, 
            NEW.alasan_batal
        );
    END IF;
END;
```

---

## **6. Logika Stok & Reservasi (TETAP)**

- Stok produk di-reserve saat user klik "Checkout" (belum dikurangi dari stok aktual)
- Reserved stock memiliki timeout **24 JAM** (bukan 30 menit)
- Stok aktual hanya dikurangi saat petani **APPROVE pembayaran** (status: Dibayar)
- Jika pembayaran ditolak atau order dibatalkan, reserved stock di-release kembali

---

## **7. Logika Status Order (UPDATE)** ⭐

**Status order berjalan sequentially:**

1. **Pending** → Order dibuat, menunggu upload bukti bayar (timeout: **24 jam**)
2. **Menunggu Verifikasi** → Bukti bayar di-upload, menunggu verifikasi petani (timeout: **48 jam**)
3. **Dibayar** → Pembayaran diverifikasi petani, **dana ditahan escrow**, stok dikurangi
4. **Diproses** → Petani sedang proses order
5. **Dikirim** → Barang dikirim oleh petani (input nomor resi)
6. **Terkirim** → Barang sampai ke customer (timeout: **3 hari** untuk konfirmasi)
7. **Selesai** → Customer konfirmasi OK **ATAU** auto-complete setelah 3 hari, **dana dikirim ke petani**
8. **Dibatalkan** → Order dibatalkan (oleh user, auto-timeout, atau petani reject)
9. **Minta Refund** → Customer komplain barang rusak/tidak sesuai ⭐
10. **Direfund** → Admin approve refund, **dana di-refund ke customer** ⭐

---

## **Logika Ongkir (TETAP)**

- User wajib memilih kota tujuan saat checkout
- Sistem mengambil tarif ongkir dari tabel `kota` berdasarkan `id_kota` yang dipilih
- Tarif ongkir bersifat flat rate per kota (tidak dipengaruhi berat/jumlah produk)

---

## **Logika Kupon (TETAP)**

Kupon valid jika:
- Kode sesuai (case-insensitive)
- Belum melewati `tgl_selesai` (expired date)
- Status `is_aktif` = true
- Subtotal order ≥ `min_belanja`
- Total penggunaan user < `limit_per_user`
- Total penggunaan global < `limit_total` (jika ada)

Kupon mengurangi subtotal produk, bukan mengurangi ongkir. Setiap penggunaan kupon dicatat di tabel `pemakaian_kupon` untuk tracking.

---

## **Logika Review (TETAP)**

- User hanya bisa memberikan review untuk order dengan status **Selesai**
- User hanya boleh review 1 kali per item dalam 1 transaksi (tidak bisa edit review)
- Review terhubung ke `id_item_pesanan` (bukan `id_produk`)
- Rating: skala 1-5 bintang (integer)

---

## **Logika Otorisasi (TETAP)**

- Petani hanya bisa CRUD produk milik sendiri (`id_petani` = user.id)
- Petani hanya bisa verifikasi order yang berisi produk miliknya
- Admin memiliki akses penuh ke semua fitur (super user)

---

# **Activity Diagram (UPDATE VERSION 2.0)** ⭐

## **Activity Diagram: Flow Order dengan Escrow**

```
[START] Customer Checkout
    ↓
Set batas_bayar = NOW() + 24 JAM
Status: PENDING
Reserved stock = reserved_stock + quantity
    ↓
Customer Upload Bukti Bayar (dalam 24 jam)
    ├── [TIMEOUT 24 JAM] → AUTO-CANCEL → Reserved stock di-release → [END]
    └── [UPLOAD OK] → Status: MENUNGGU_VERIFIKASI
            ↓
        Petani Verifikasi (dalam 48 jam)
            ├── [TIMEOUT 48 JAM] → AUTO-CANCEL + REFUND → [END]
            ├── [REJECT] → Status: DIBATALKAN → Reserved stock di-release → [END]
            └── [APPROVE] → Status: DIBAYAR
                    ↓
                Dana DITAHAN Escrow (status: ditahan)
                Stock = stock - quantity
                Reserved stock = reserved_stock - quantity
                    ↓
                Petani Proses & Kirim
                Status: DIPROSES → DIKIRIM (input no_resi)
                    ↓
                Barang Sampai
                Status: TERKIRIM
                    ↓
                Customer Konfirmasi (dalam 3 hari)
                    ├── [TIMEOUT 3 HARI] → AUTO-COMPLETE → Dana ke Petani → [END]
                    ├── [KONFIRMASI OK] → Status: SELESAI → Dana ke Petani → [END]
                    └── [KOMPLAIN] → Status: MINTA_REFUND
                            ↓
                        Admin Review
                            ├── [APPROVE] → Status: DIREFUND → Dana ke Customer → [END]
                            └── [REJECT] → Status: SELESAI → Dana ke Petani → [END]
```

---

# **ERD (Entity Relationship Diagram) - UPDATE** ⭐

[ERD Link](https://dbdiagram.io/d/tanami_web2-694b539fdbf05578e66c71c5)

## **Perubahan Major:**

### **Tabel BARU:**
1. **`escrow`** - Menampung data escrow transaksi
2. **`histori_status`** - Log audit perubahan status

### **Tabel DIUPDATE:**
- **`pesanan`** - Tambah field:
  - `batas_bayar` (TIMESTAMP) - Timeout 24 jam
  - `tgl_selesai` (TIMESTAMP) - Waktu customer konfirmasi
  - `id_konfirmasi` (INT FK) - ID customer yang konfirmasi
  - `tgl_selesai_otomatis` (TIMESTAMP) - Auto-complete timestamp
  - `alasan_batal` (TEXT) - Alasan cancel
  - `tgl_dibatalkan` (TIMESTAMP) - Waktu cancel

---

# **Struktur Tabel (UPDATE VERSION 2.0)** ⭐

## **TABEL BARU 1: ESCROW**

| Field Name | Data Type | Constraint | Description |
|------------|-----------|------------|-------------|
| id_escrow | INT | PK, AUTO_INCREMENT | Escrow ID unik |
| id_pesanan | INT | **FK→pesanan.id_pesanan (UNIQUE)** | Pesanan (1:1) |
| jumlah | DECIMAL(10,2) | NOT NULL | Total dana ditahan |
| status_escrow | ENUM('ditahan','dikirim_ke_petani','direfund_ke_pembeli') | NOT NULL DEFAULT 'ditahan' | Status dana escrow |
| tgl_ditahan | TIMESTAMP | NULLABLE | Kapan dana ditahan |
| tgl_kirim | TIMESTAMP | NULLABLE | Kapan dana dikirim |
| id_penerima | INT | **FK→pengguna.id_pengguna** | Petani/Customer penerima dana |
| catatan | TEXT | NULLABLE | Keterangan tambahan |
| tgl_dibuat | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu record dibuat |

---

## **TABEL BARU 2: HISTORI_STATUS**

| Field Name | Data Type | Constraint | Description |
|------------|-----------|------------|-------------|
| id_histori | INT | PK, AUTO_INCREMENT | Histori ID unik |
| id_pesanan | INT | **FK→pesanan.id_pesanan** | Pesanan yang diubah |
| status_lama | VARCHAR(50) | NULLABLE | Status sebelumnya |
| status_baru | VARCHAR(50) | NOT NULL | Status baru |
| id_pengubah | INT | **FK→pengguna.id_pengguna** | User yang ubah status |
| alasan | TEXT | NULLABLE | Alasan perubahan |
| tgl_dibuat | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu perubahan |

---

## **TABEL UPDATE: PESANAN**

**Field BARU yang ditambahkan:**

| Field Name | Data Type | Constraint | Description |
|------------|-----------|------------|-------------|
| batas_bayar | TIMESTAMP | NULLABLE | Batas upload bukti (24 jam) ⭐ |
| tgl_selesai | TIMESTAMP | NULLABLE | Waktu pembeli konfirmasi selesai ⭐ |
| id_konfirmasi | INT | **FK→pengguna.id_pengguna** | ID pembeli yang konfirmasi ⭐ |
| tgl_selesai_otomatis | TIMESTAMP | NULLABLE | Auto-complete 3 hari ⭐ |
| alasan_batal | TEXT | NULLABLE | Alasan cancel order ⭐ |
| tgl_dibatalkan | TIMESTAMP | NULLABLE | Waktu order dibatalkan ⭐ |

**Perubahan ENUM status_pesanan:**

```sql
ENUM(
    'pending',
    'menunggu_verifikasi',  -- Dulu: awaiting_payment
    'dibayar',              -- Dulu: paid
    'diproses',             -- Dulu: processing
    'dikirim',              -- Dulu: shipped
    'terkirim',             -- Dulu: delivered
    'selesai',              -- Dulu: completed
    'dibatalkan',           -- Dulu: cancelled
    'minta_refund',         -- BARU ⭐
    'direfund'              -- BARU ⭐
)
```

---

# **Stored Procedures (BARU)** ⭐

## **1. sp_batalkan_pesanan_timeout()**

**Fungsi:** Auto-cancel order yang timeout 24 jam tanpa bukti bayar

```sql
CREATE PROCEDURE sp_batalkan_pesanan_timeout()
BEGIN
    -- Cancel order yang sudah lewat 24 jam tanpa bayar
    UPDATE pesanan 
    SET status_pesanan = 'dibatalkan',
        alasan_batal = 'Timeout pembayaran - Sudah 24 jam tidak ada bukti bayar',
        tgl_dibatalkan = NOW(),
        tgl_update = NOW()
    WHERE status_pesanan = 'pending'
      AND batas_bayar < NOW()
      AND bukti_bayar IS NULL;

    -- Release stok yang di-reserve
    UPDATE produk p
    INNER JOIN item_pesanan ip ON p.id_produk = ip.id_produk
    INNER JOIN pesanan ps ON ip.id_pesanan = ps.id_pesanan
    SET p.stok_direserve = p.stok_direserve - ip.jumlah
    WHERE ps.status_pesanan = 'dibatalkan'
      AND ps.tgl_dibatalkan >= DATE_SUB(NOW(), INTERVAL 1 MINUTE);
END;
```

**Event Scheduler:** Jalan setiap **1 JAM**

```sql
CREATE EVENT evt_batalkan_timeout
ON SCHEDULE EVERY 1 HOUR
DO CALL sp_batalkan_pesanan_timeout();
```

---

## **2. sp_selesaikan_pesanan_otomatis()**

**Fungsi:** Auto-complete order yang sudah 3 hari sejak terkirim

```sql
CREATE PROCEDURE sp_selesaikan_pesanan_otomatis()
BEGIN
    -- Auto-complete order yang sudah 3 hari sejak delivered
    UPDATE pesanan 
    SET status_pesanan = 'selesai',
        tgl_selesai = NOW(),
        tgl_selesai_otomatis = NOW(),
        tgl_update = NOW()
    WHERE status_pesanan = 'terkirim'
      AND tgl_update < DATE_SUB(NOW(), INTERVAL 3 DAY);

    -- Release escrow ke petani
    UPDATE escrow e
    INNER JOIN pesanan ps ON e.id_pesanan = ps.id_pesanan
    INNER JOIN item_pesanan ip ON ps.id_pesanan = ip.id_pesanan
    SET e.status_escrow = 'dikirim_ke_petani',
        e.tgl_kirim = NOW(),
        e.id_penerima = ip.id_petani,
        e.catatan = 'Auto-complete setelah 3 hari'
    WHERE ps.status_pesanan = 'selesai'
      AND ps.tgl_selesai >= DATE_SUB(NOW(), INTERVAL 1 MINUTE)
      AND e.status_escrow = 'ditahan';
END;
```

**Event Scheduler:** Jalan setiap **6 JAM**

```sql
CREATE EVENT evt_selesaikan_otomatis
ON SCHEDULE EVERY 6 HOUR
DO CALL sp_selesaikan_pesanan_otomatis();
```

---

# **Trigger Database (BARU)** ⭐

## **trg_log_perubahan_status**

**Fungsi:** Auto-log setiap perubahan status pesanan

```sql
CREATE TRIGGER trg_log_perubahan_status
AFTER UPDATE ON pesanan
FOR EACH ROW
BEGIN
    IF OLD.status_pesanan != NEW.status_pesanan THEN
        INSERT INTO histori_status (
            id_pesanan, 
            status_lama, 
            status_baru, 
            alasan
        ) VALUES (
            NEW.id_pesanan, 
            OLD.status_pesanan, 
            NEW.status_pesanan, 
            NEW.alasan_batal
        );
    END IF;
END;
```

**Manfaat:**
- ✅ Transparansi penuh
- ✅ Audit trail lengkap
- ✅ Evidence untuk dispute
- ✅ Tracking siapa ubah status kapan

---

# **View Database (UPDATE)** ⭐

## **v_ringkasan_pesanan (BARU)**

**Fungsi:** View ringkasan order dengan info escrow dan flag status

```sql
CREATE VIEW v_ringkasan_pesanan AS
SELECT 
    p.id_pesanan,
    p.status_pesanan,
    p.total_bayar,
    p.tgl_dibuat,
    p.batas_bayar,
    u.nama_lengkap AS nama_pembeli,
    u.email AS email_pembeli,
    e.status_escrow,
    e.jumlah AS jumlah_escrow,
    e.tgl_ditahan,
    CASE 
        WHEN p.status_pesanan = 'pending' AND p.batas_bayar < NOW() 
            THEN 'EXPIRED'
        WHEN p.status_pesanan = 'pending' 
            THEN 'MENUNGGU_BAYAR'
        WHEN p.status_pesanan = 'terkirim' AND p.tgl_update < DATE_SUB(NOW(), INTERVAL 3 DAY) 
            THEN 'SIAP_AUTO_SELESAI'
        ELSE 'AKTIF'
    END AS flag_pesanan
FROM pesanan p
INNER JOIN pengguna u ON p.id_pembeli = u.id_pengguna
LEFT JOIN escrow e ON p.id_pesanan = e.id_pesanan;
```

**Flag Pesanan:**
- `EXPIRED` - Order pending & batas bayar lewat
- `MENUNGGU_BAYAR` - Order pending, belum timeout
- `SIAP_AUTO_SELESAI` - Order terkirim > 3 hari
- `AKTIF` - Status normal

---

# **Sample Data (UPDATE)**

## **Tabel: escrow**

| id_escrow | id_pesanan | jumlah | status_escrow | tgl_ditahan | id_penerima | catatan |
|-----------|------------|--------|---------------|-------------|-------------|---------|
| 1 | 1 | 40000.00 | dikirim_ke_petani | 2025-12-24 04:00:00 | 2 (Pak Tono) | Customer confirmed delivery |
| 2 | 3 | 175000.00 | direfund_ke_pembeli | 2025-12-25 01:00:00 | 6 (Dedi) | Farmer no response - auto refund |
| 3 | 9 | 50000.00 | ditahan | 2025-12-28 04:00:00 | NULL | Payment held - waiting confirmation |

## **Tabel: histori_status**

| id_histori | id_pesanan | status_lama | status_baru | id_pengubah | alasan | tgl_dibuat |
|------------|------------|-------------|-------------|-------------|--------|------------|
| 1 | 1 | NULL | pending | NULL | NULL | 2025-12-24 00:00:00 |
| 2 | 1 | pending | menunggu_verifikasi | 4 (Budi) | NULL | 2025-12-24 02:00:00 |
| 3 | 1 | menunggu_verifikasi | dibayar | 2 (Pak Tono) | NULL | 2025-12-24 04:00:00 |
| 4 | 1 | dibayar | diproses | 2 (Pak Tono) | NULL | 2025-12-24 06:00:00 |
| 5 | 1 | diproses | dikirim | 2 (Pak Tono) | NULL | 2025-12-24 12:00:00 |
| 6 | 1 | dikirim | terkirim | NULL | NULL | 2025-12-26 00:00:00 |
| 7 | 1 | terkirim | selesai | 4 (Budi) | NULL | 2025-12-28 00:00:00 |

---

# **Relasi Tabel (UPDATE)** ⭐

| Parent Table | Child Table | Relationship Description | Foreign Key | Cardinality |
|--------------|-------------|--------------------------|-------------|-------------|
| **pengguna** | **produk** | Petani memiliki banyak produk | id_petani | 1:N |
| **pengguna** | **pesanan** | Customer membuat banyak order | id_pembeli | 1:N |
| **pengguna** | **ulasan** | Customer menulis banyak review | id_pengguna | 1:N |
| **pengguna** | **rekening_petani** | Petani memiliki banyak rekening | id_petani | 1:N |
| **pengguna** | **keranjang** | Customer punya banyak item cart | id_pengguna | 1:N |
| **pengguna** | **pemakaian_kupon** | User gunakan kupon berkali-kali | id_pengguna | 1:N |
| **pengguna** | **pesanan (id_verifikator)** | Admin/Petani verifikasi pembayaran | id_verifikator | 1:N |
| **pengguna** | **pesanan (id_konfirmasi)** | Customer konfirmasi penerimaan ⭐ | id_konfirmasi | 1:N |
| **pengguna** | **escrow (id_penerima)** | Petani/Customer terima dana escrow ⭐ | id_penerima | 1:N |
| **kategori** | **produk** | Kategori punya banyak produk | id_kategori | 1:N |
| **kota** | **pesanan** | Kota untuk banyak order | id_kota_tujuan | 1:N |
| **kupon** | **pemakaian_kupon** | Kupon digunakan berkali-kali | id_kupon | 1:N |
| **pesanan** | **item_pesanan** | Order punya banyak item | id_pesanan | 1:N |
| **pesanan** | **escrow** | Order punya 1 escrow (jika dibayar) ⭐ | id_pesanan | 1:1 (optional) |
| **pesanan** | **histori_status** | Order punya banyak histori perubahan ⭐ | id_pesanan | 1:N |
| **produk** | **item_pesanan** | Produk dijual berkali-kali | id_produk | 1:N |
| **item_pesanan** | **ulasan** | Item bisa punya 1 review max | id_item_pesanan | 1:1 (optional) |

---

# **Automation & Event Scheduler** ⭐

## **Event Scheduler yang Berjalan Otomatis:**

### **1. evt_batalkan_timeout**
- **Schedule:** Setiap **1 JAM**
- **Action:** `CALL sp_batalkan_pesanan_timeout()`
- **Fungsi:** Cancel order yang lewat 24 jam tanpa bayar
- **Impact:**
  - Update status → 'dibatalkan'
  - Release reserved stock
  - Catat alasan timeout

### **2. evt_selesaikan_otomatis**
- **Schedule:** Setiap **6 JAM**
- **Action:** `CALL sp_selesaikan_pesanan_otomatis()`
- **Fungsi:** Auto-complete order 3 hari setelah terkirim
- **Impact:**
  - Update status → 'selesai'
  - Release escrow ke petani
  - Set tgl_selesai_otomatis

**Enable Event Scheduler:**
```sql
SET GLOBAL event_scheduler = ON;
```

---

# **Perbandingan: SEBELUM vs SESUDAH** ⭐

## **Aspek Keamanan**

| SEBELUM | SESUDAH |
|---------|---------|
| ❌ Dana transfer langsung ke petani | ✅ Dana ditahan escrow platform |
| ❌ Tidak ada perlindungan pembeli | ✅ Perlindungan pembeli & petani |
| ❌ Sulit refund jika ada masalah | ✅ Refund otomatis jika ada masalah |
| ❌ Risiko penipuan tinggi | ✅ Risiko penipuan minimal |

## **Aspek User Experience**

| SEBELUM | SESUDAH |
|---------|---------|
| ❌ Timeout 30 menit → terlalu ketat | ✅ Timeout 24 jam → lebih fleksibel |
| ❌ Customer stress harus cepat upload | ✅ Customer lebih santai |
| ❌ Banyak order cancel sia-sia | ✅ Mengurangi cancel yang tidak perlu |
| ❌ Pending selamanya jika lupa konfirmasi | ✅ Auto-complete mencegah pending |

## **Aspek Otomasi**

| SEBELUM | SESUDAH |
|---------|---------|
| ❌ Auto-cancel hanya 30 menit | ✅ Auto-cancel 24 jam |
| ❌ Tidak ada auto-complete | ✅ Auto-complete setelah 3 hari |
| ❌ Petani bisa lambat tanpa sanksi | ✅ Auto-cancel jika petani lambat 48 jam |
| ❌ Tidak ada audit log otomatis | ✅ Audit log otomatis via trigger |

## **Aspek Transparansi**

| SEBELUM | SESUDAH |
|---------|---------|
| ❌ Tidak ada log perubahan status | ✅ Histori status lengkap |
| ❌ Sulit tracking siapa ubah apa | ✅ Tracking user + waktu |
| ❌ Tidak ada bukti untuk dispute | ✅ Audit trail untuk dispute |
| ❌ Tidak ada view monitoring | ✅ View dashboard monitoring |

---

# **Keuntungan Sistem Baru** ⭐

## **Untuk Pembeli:**
✅ Dana **AMAN** di escrow (tidak langsung ke petani)  
✅ Punya **24 jam** untuk upload bukti (bukan 30 menit)  
✅ Punya **3 hari** untuk komplain setelah barang sampai  
✅ **Auto-refund** jika petani tidak responsif  
✅ Jaminan uang kembali jika ada masalah  

## **Untuk Petani:**
✅ Dana **PASTI cair** (max 3 hari setelah kirim)  
✅ Tidak perlu tunggu konfirmasi pembeli selamanya  
✅ **Auto-complete** melindungi dari pembeli nakal  
✅ Escrow mencegah chargeback bank  
✅ Sistem lebih profesional & terpercaya  

## **Untuk Platform:**
✅ Seperti marketplace modern (Tokopedia, Shopee, dll)  
✅ Mengurangi dispute pembeli vs petani  
✅ **Otomasi penuh** → hemat operasional  
✅ **Audit trail** lengkap untuk compliance  
✅ Database **terstruktur** & scalable  

---

# **Kesimpulan**

Sistem **TANAMI E-Commerce versi 2.0** telah mengalami **transformasi major** menjadi platform marketplace modern dengan fitur:

1. ⏰ **Timeout 24 Jam** - Lebih fleksibel untuk customer
2. 💰 **Sistem Escrow** - Dana aman di platform
3. ⏰ **Timeout Verifikasi 48 Jam** - Melindungi customer
4. ⚡ **Auto-Complete 3 Hari** - Petani pasti dapat dana
5. 📝 **Audit Log Lengkap** - Transparansi penuh

Dengan perubahan ini, **TANAMI** setara dengan marketplace besar Indonesia seperti **Tokopedia, Shopee, dan Bukalapak** dalam hal keamanan transaksi dan user experience.

---

**[Sisanya tetap sama seperti dokumen asli...]**

[image1]: <data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAP0AAAD9CAIAAAD4V+arAACAAElEQVR4XuydB3xc1ZX/73tvmkbVcqUYTIckSwIJBDZ0CDhgG2zLsq2u6b1ppFF1kY0xpGchm93/ZkMKzQVCCKEZbFxV3SA9oRc32WrTXrv/c+6TbKMRsUKwsVlfzkeMxrY0M+/7zv2dc889l9DT4yQYKlWSNKWqKpUoVWhKTA5KA/20TxRFeoh+Z/Z/zDWVFulKXfneWbq7f7f0OdpP+3sH3u/7UFEUKoOl0RRVVeDLyB9+emQOMvKJ0+OzGMCqRFWZKhKV48lBYF+RZJqm9AD9Vs4dd5O77WZnKSm1GG2V2VVFeUXem/y0jyb64rIK5EuKmgJTVRmgP839WMZp7k+OoVI1RRM01UcP9Uo9Yk+SDtC5+TPc51idZqudWPyCy8c7qvmKeWRebX5tGVfhOMf5+7W7qQi3CHxJp2lKoiJz/qfBP/Y4zf3JMZjDH0gNpmgqlYzT9+l3Sr5daiyr1FdaOZuDOFzE4SBWi1Dp4h1BEvQQn9PkmJEzffD3gzRJqYw/I5kelJQUePyRP/z0yBinuT9ZhphWlYQKbp6+Se8SZpYZyqvRwTssaDYLb0UTqh28zcO5AnzQTux2k7U8Z8Gd+tvoW5TGKU3h/SMrqZE/+vTIGKe5PykGKPsBNQGS/afhX8zliueRhRWk2kHA01vtXLWdr3RwlS5SaeWtlbrqCkN5ma7UYbR7iLeZq/UTy1zDLPvVNuC+d/8hFVTP6XGscZr7z2jImLeBIFSWRdTn8HgfrbjYWppX4RQcbuJ0IfQOhv4RA82jmY23OzkncF/LBWr4gFvvqsyuXnLncvghOGOooigl4DeIbA5Ijvzdp8dp7j+jAQEoC0NFkPXxtwZe+s+X552xsLzAUqUHWeNxg6bnKhn3HzE7Z7MPyX2Xm3j9XCDIe8OcP8gH/Tq/rcCxcFLpH9f8GQLk/p5Bkcop/BWnBf8o4zT3n8EAElM0maRx5H6QDmyKzxtXcgeZUUQWBnJqNO5R22RwrxnEuF7i8RGGO+8J8v4wF4zwEb/RazdV32O85+DWFHp9DJWTKHtOpzYzxmnuT+iQJEmW5VQqFU/2J+IDEIxOH3entcAVzKqz6VxO3uMhPg9xg6y3cRWZxDsJaBu3n4CPD4NFSASgB4uQcC2JxLiaGBeOCkGfyVNauBDRl8H1ywfigwobI1/N/+FxmvsTN9LpNMUVKVyTUvqUgb8OFF9cYpvsdoCfJl4n73Ixc3J2DGeJZST0KOjdAeILkQCAHiURMPD06Ozx23CMRBtItJFEm/gat842d2IR/Qvt2ZvE33p6fHSc5v6EDvD3+D+ZPvfDF+8pnOc0hfz6qCcrZMmyW/lqzWzEAkGtm9hHQO8W3CBsGOXBOi4KlMdIHaAP0DP3H