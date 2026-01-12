---
description: Flow implementasi fitur Pembayaran & Verifikasi (Point 3.5 + 3.6 dari BACKEND-CHECKLIST.md)
---

# 🔄 Flow Pembayaran & Verifikasi

Workflow ini mencakup implementasi lengkap fitur pembayaran dan verifikasi untuk TANAMI E-Commerce, yaitu:

-   **3.5** Pembayaran & Upload Bukti (Pembeli)
-   **3.6** Verifikasi Petani (Petani)

---

## 📋 Prerequisites

Sebelum memulai, pastikan hal-hal berikut sudah selesai:

-   [ ] Fase 1 & 2 (Database & Models) sudah complete
-   [ ] Middleware `auth` dan `role` sudah berfungsi
-   [ ] Routes di `web.php` sudah terdaftar
-   [ ] Login/Register sudah berfungsi untuk testing

---

## 🏗️ Struktur File yang Akan Dimodifikasi

```
app/Http/Controllers/
├── PesananController.php          # Pembeli: upload, batal, konfirmasi, refund
└── Petani/PesananController.php   # Petani: verifikasi, tolak, proses, kirim

resources/views/
├── pembeli/
│   ├── pesanan.blade.php          # List pesanan pembeli
│   └── pesanan-detail.blade.php   # Detail pesanan + aksi
└── petani/pesanan/
    ├── index.blade.php            # List pesanan masuk
    └── detail.blade.php           # Detail + bukti bayar + aksi

storage/app/public/
└── bukti-bayar/                   # Folder upload bukti bayar
```

---

## 📌 STEP 1: Persiapan Storage Link

// turbo

```bash
php artisan storage:link
```

Pastikan folder `storage/app/public/bukti-bayar` sudah ada:
// turbo

```bash
mkdir storage\app\public\bukti-bayar
```

---

## 📌 STEP 2: Implementasi PesananController (Pembeli)

### 2.1 Method `uploadBukti()` - Upload Bukti Pembayaran

**File:** `app/Http/Controllers/PesananController.php`

**Logic:**

1. Validasi file: `mimes:jpg,jpeg,png`, `max:2048`
2. Cek ownership: pesanan milik user yang login
3. Cek status: hanya bisa jika `bisaUploadBukti()` = true
4. Simpan file ke `storage/app/public/bukti-bayar/`
5. Update field `bukti_bayar` dengan path file
6. Update `status_pesanan` → `menunggu_verifikasi`
7. Redirect dengan flash message sukses

**Code Pattern:**

```php
public function uploadBukti(Request $request, int $id): RedirectResponse
{
    $request->validate([
        'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $pesanan = Pesanan::where('id_pembeli', auth()->id())
        ->findOrFail($id);

    if (!$pesanan->bisaUploadBukti()) {
        return back()->withErrors(['error' => 'Pesanan tidak bisa diupload bukti bayar']);
    }

    $file = $request->file('bukti_bayar');
    $filename = 'bukti_' . $pesanan->id_pesanan . '_' . time() . '.' . $file->getClientOriginalExtension();
    $file->storeAs('public/bukti-bayar', $filename);

    $pesanan->update([
        'bukti_bayar' => 'bukti-bayar/' . $filename,
        'status_pesanan' => Pesanan::STATUS_MENUNGGU_VERIFIKASI,
    ]);

    return back()->with('success', 'Bukti pembayaran berhasil diupload');
}
```

### 2.2 Method `batal()` - Batalkan Pesanan

**Logic:**

1. Cek ownership: pesanan milik user yang login atau petani terkait
2. Cek status: hanya bisa jika `bisaDibatalkan()` = true
3. Release reserved stock untuk semua item pesanan
4. Update `status_pesanan` → `dibatalkan`
5. Set `alasan_batal`, `tgl_dibatalkan`

**Code Pattern:**

```php
public function batal(Request $request, int $id): RedirectResponse
{
    $pesanan = Pesanan::with('items.produk')
        ->where('id_pembeli', auth()->id())
        ->findOrFail($id);

    if (!$pesanan->bisaDibatalkan()) {
        return back()->withErrors(['error' => 'Pesanan tidak bisa dibatalkan']);
    }

    DB::transaction(function () use ($pesanan, $request) {
        // Release reserved stock
        foreach ($pesanan->items as $item) {
            $item->produk->releaseStok($item->jumlah);
        }

        $pesanan->update([
            'status_pesanan' => Pesanan::STATUS_DIBATALKAN,
            'alasan_batal' => $request->input('alasan', 'Dibatalkan oleh pembeli'),
            'tgl_dibatalkan' => now(),
        ]);
    });

    return redirect()->route('pesanan')->with('success', 'Pesanan berhasil dibatalkan');
}
```

### 2.3 Method `konfirmasi()` - Konfirmasi Penerimaan

**Logic:**

1. Cek ownership: pesanan milik user yang login
2. Cek status: hanya bisa jika `bisaDikonfirmasi()` = true (status `terkirim`)
3. Update `status_pesanan` → `selesai`
4. Set `tgl_selesai`, `id_konfirmasi`
5. Release escrow ke petani

**Code Pattern:**

```php
public function konfirmasi(int $id): RedirectResponse
{
    $pesanan = Pesanan::with(['escrow', 'items.produk'])
        ->where('id_pembeli', auth()->id())
        ->findOrFail($id);

    if (!$pesanan->bisaDikonfirmasi()) {
        return back()->withErrors(['error' => 'Pesanan tidak bisa dikonfirmasi']);
    }

    DB::transaction(function () use ($pesanan) {
        $pesanan->update([
            'status_pesanan' => Pesanan::STATUS_SELESAI,
            'tgl_selesai' => now(),
            'id_konfirmasi' => auth()->id(),
        ]);

        // Get petani ID from first item
        $idPetani = $pesanan->items->first()->produk->id_petani;

        // Release escrow to petani
        if ($pesanan->escrow) {
            $pesanan->escrow->kirimKePetani($idPetani, 'Dikonfirmasi oleh pembeli');
        }
    });

    return redirect()->route('pesanan.detail', $id)
        ->with('success', 'Terima kasih! Pesanan telah dikonfirmasi selesai.');
}
```

### 2.4 Method `mintaRefund()` - Request Refund

**Logic:**

1. Cek ownership: pesanan milik user yang login
2. Cek status: hanya bisa jika `bisaRefund()` = true (status `terkirim`)
3. Validasi alasan refund (required)
4. Update `status_pesanan` → `minta_refund`

**Code Pattern:**

```php
public function mintaRefund(Request $request, int $id): RedirectResponse
{
    $request->validate([
        'alasan_refund' => 'required|string|max:500',
    ]);

    $pesanan = Pesanan::where('id_pembeli', auth()->id())
        ->findOrFail($id);

    if (!$pesanan->bisaRefund()) {
        return back()->withErrors(['error' => 'Pesanan tidak bisa direfund']);
    }

    $pesanan->update([
        'status_pesanan' => Pesanan::STATUS_MINTA_REFUND,
        'alasan_refund' => $request->alasan_refund,
    ]);

    return back()->with('success', 'Permintaan refund berhasil dikirim ke admin');
}
```

---

## 📌 STEP 3: Implementasi Petani\PesananController

### 3.1 Method `index()` - List Pesanan Masuk

**File:** `app/Http/Controllers/Petani/PesananController.php`

**Logic:**

1. Query pesanan yang mengandung produk milik petani yang login
2. Filter by status (optional query param)
3. Eager load: items.produk, pembeli, kota
4. Order by tgl_dibuat DESC

**Code Pattern:**

```php
public function index(Request $request): View
{
    $query = Pesanan::whereHas('items.produk', function ($q) {
            $q->where('id_petani', auth()->id());
        })
        ->with(['items.produk', 'pembeli', 'kota'])
        ->orderByDesc('tgl_dibuat');

    if ($request->filled('status')) {
        $query->where('status_pesanan', $request->status);
    }

    $pesanan = $query->paginate(10);

    return view('petani.pesanan.index', compact('pesanan'));
}
```

### 3.2 Method `show()` - Detail Pesanan

**Logic:**

1. Load pesanan dengan relasi lengkap
2. Pastikan pesanan mengandung produk milik petani
3. Load bukti bayar jika ada

### 3.3 Method `verifikasi()` - Verifikasi Pembayaran ⭐

**Logic PENTING:**

1. Cek: hanya pesanan dengan status `menunggu_verifikasi`
2. Update `status_pesanan` → `dibayar`
3. Set `tgl_verifikasi`, `id_verifikator`
4. **Kurangi stok aktual** (`produk.stok -= qty`)
5. **Release reserved stock** (`produk.stok_direserve -= qty`)
6. **Create escrow** dengan status `ditahan`

**Code Pattern:**

```php
public function verifikasi(int $id): RedirectResponse
{
    $pesanan = Pesanan::with('items.produk')
        ->whereHas('items.produk', fn($q) => $q->where('id_petani', auth()->id()))
        ->findOrFail($id);

    if (!$pesanan->bisaDiverifikasi()) {
        return back()->withErrors(['error' => 'Pesanan tidak bisa diverifikasi']);
    }

    DB::transaction(function () use ($pesanan) {
        // Update status
        $pesanan->update([
            'status_pesanan' => Pesanan::STATUS_DIBAYAR,
            'tgl_verifikasi' => now(),
            'id_verifikator' => auth()->id(),
        ]);

        // Process stock for each item
        foreach ($pesanan->items as $item) {
            $item->produk->kurangiStok($item->jumlah);
            $item->produk->releaseStok($item->jumlah);
        }

        // Create escrow
        Escrow::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'jumlah' => $pesanan->total_bayar,
            'status_escrow' => Escrow::STATUS_DITAHAN,
            'tgl_ditahan' => now(),
        ]);
    });

    return back()->with('success', 'Pembayaran berhasil diverifikasi');
}
```

### 3.4 Method `tolak()` - Tolak Pembayaran

**Logic:**

1. Cek: hanya pesanan dengan status `menunggu_verifikasi`
2. Validasi alasan penolakan (required)
3. Update `status_pesanan` → `dibatalkan`
4. Set `alasan_tolak`, `tgl_dibatalkan`
5. **Release reserved stock**

**Code Pattern:**

```php
public function tolak(Request $request, int $id): RedirectResponse
{
    $request->validate([
        'alasan_tolak' => 'required|string|max:500',
    ]);

    $pesanan = Pesanan::with('items.produk')
        ->whereHas('items.produk', fn($q) => $q->where('id_petani', auth()->id()))
        ->findOrFail($id);

    if (!$pesanan->bisaDiverifikasi()) {
        return back()->withErrors(['error' => 'Pesanan tidak bisa ditolak']);
    }

    DB::transaction(function () use ($pesanan, $request) {
        // Release reserved stock
        foreach ($pesanan->items as $item) {
            $item->produk->releaseStok($item->jumlah);
        }

        $pesanan->update([
            'status_pesanan' => Pesanan::STATUS_DIBATALKAN,
            'alasan_tolak' => $request->alasan_tolak,
            'tgl_dibatalkan' => now(),
        ]);
    });

    return back()->with('success', 'Pesanan berhasil ditolak');
}
```

### 3.5 Method `proses()` - Tandai Diproses

**Logic:**

1. Cek: hanya pesanan dengan status `dibayar`
2. Update `status_pesanan` → `diproses`

### 3.6 Method `kirim()` - Kirim Pesanan

**Logic:**

1. Cek: hanya pesanan dengan status `diproses`
2. Validasi nomor resi (required)
3. Update `status_pesanan` → `dikirim`
4. Set `no_resi`

---

## 📌 STEP 4: Buat Blade Views

### 4.1 View Pembeli: Detail Pesanan

**File:** `resources/views/pembeli/pesanan-detail.blade.php`

**Komponen UI:**

-   Info pesanan (ID, tanggal, status badge)
-   List items dengan foto, nama, qty, harga
-   Summary: subtotal, ongkir, diskon, total
-   Countdown timer jika status `pending` (sampai `batas_bayar`)
-   Form upload bukti bayar (jika `bisaUploadBukti()`)
-   Preview bukti bayar (jika sudah upload)
-   Tombol Batal (jika `bisaDibatalkan()`)
-   Tombol Konfirmasi Terima (jika `bisaDikonfirmasi()`)
-   Tombol Minta Refund (jika `bisaRefund()`)
-   Info resi (jika sudah dikirim)
-   Histori status pesanan

### 4.2 View Petani: List Pesanan

**File:** `resources/views/petani/pesanan/index.blade.php`

**Komponen UI:**

-   Filter by status (tabs atau dropdown)
-   Tabel pesanan: ID, pembeli, tanggal, total, status, aksi
-   Badge warna sesuai status
-   Link ke detail

### 4.3 View Petani: Detail Pesanan

**File:** `resources/views/petani/pesanan/detail.blade.php`

**Komponen UI:**

-   Info pembeli dan alamat kirim
-   List items pesanan
-   Preview bukti bayar (image clickable/modal)
-   Tombol Verifikasi + Tolak (jika `menunggu_verifikasi`)
-   Tombol Proses (jika `dibayar`)
-   Form input resi + Tombol Kirim (jika `diproses`)
-   Histori status

---

## 📌 STEP 5: Testing Flow

### Test Case 1: Upload Bukti Bayar

1. Login sebagai pembeli
2. Buat pesanan (checkout)
3. Di halaman detail pesanan, upload bukti bayar (jpg/png < 2MB)
4. Verifikasi: status berubah ke `menunggu_verifikasi`
5. Verifikasi: file tersimpan di `storage/app/public/bukti-bayar/`

### Test Case 2: Verifikasi Petani

1. Login sebagai petani
2. Buka list pesanan → filter status `menunggu_verifikasi`
3. Lihat detail, preview bukti bayar
4. Klik tombol Verifikasi
5. Verifikasi: status → `dibayar`, stok berkurang, escrow dibuat

### Test Case 3: Tolak Pembayaran

1. Sebagai petani, buka pesanan `menunggu_verifikasi`
2. Isi alasan tolak, klik Tolak
3. Verifikasi: status → `dibatalkan`, reserved stock di-release

### Test Case 4: Full Flow Sampai Selesai

1. Pembeli checkout → Upload bukti
2. Petani verifikasi → Proses → Input resi → Kirim
3. Pembeli konfirmasi terima
4. Verifikasi: status → `selesai`, escrow → `dikirim_ke_petani`

### Test Case 5: Cancel Order

1. Sebagai pembeli, buat pesanan baru
2. Sebelum upload bukti, klik Batal
3. Verifikasi: status → `dibatalkan`, reserved stock di-release

### Test Case 6: Request Refund

1. Ikuti flow sampai status `terkirim`
2. Sebagai pembeli, klik Minta Refund dengan alasan
3. Verifikasi: status → `minta_refund`

---

## 📌 STEP 6: Cek histori_status Observer (Opsional)

Jika sudah implement observer:

1. Setelah setiap perubahan status, cek tabel `histori_status`
2. Pastikan `status_lama`, `status_baru`, `id_pengubah` tercatat

---

## 🎯 Checklist Implementasi

### Controller Pembeli (PesananController)

-   [ ] `uploadBukti()` - validasi, simpan file, update status
-   [ ] `batal()` - release stock, update status
-   [ ] `konfirmasi()` - update status, release escrow
-   [ ] `mintaRefund()` - validasi, update status

### Controller Petani (Petani\PesananController)

-   [ ] `index()` - query pesanan petani
-   [ ] `show()` - detail dengan bukti bayar
-   [ ] `verifikasi()` - update status, kurangi stok, create escrow
-   [ ] `tolak()` - update status, release stock
-   [ ] `proses()` - update status
-   [ ] `kirim()` - update status, set resi

### Views

-   [ ] `pembeli/pesanan-detail.blade.php` - dengan semua aksi
-   [ ] `petani/pesanan/index.blade.php` - list + filter
-   [ ] `petani/pesanan/detail.blade.php` - dengan preview bukti + aksi

### Testing

-   [ ] Test upload bukti (valid file, invalid file)
-   [ ] Test verifikasi (stok & escrow)
-   [ ] Test tolak (release stock)
-   [ ] Test cancel (release stock)
-   [ ] Test konfirmasi (escrow release)
-   [ ] Test refund request

---

## ⚠️ Catatan Penting

1. **Selalu gunakan DB::transaction()** untuk operasi yang melibatkan multiple tables
2. **Selalu cek ownership** sebelum melakukan aksi apapun
3. **Gunakan helper methods di Model** (`bisaUploadBukti()`, `bisaDibatalkan()`, dll.)
4. **File upload harus divalidasi** tipe dan ukuran
5. **Reserved stock harus di-release** saat cancel/tolak untuk mencegah stok terkunci

---

_Last updated: 2026-01-11_
