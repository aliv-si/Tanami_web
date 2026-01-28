# 🚂 Panduan Deploy TANAMI ke Railway

## Prasyarat

- Akun GitHub dengan repository project
- Akun Railway (https://railway.app) - bisa login dengan GitHub

---

## Step 1: Push Project ke GitHub

```bash
cd /var/www/html/web_tanami2

# Inisialisasi git (jika belum)
git init
git add .
git commit -m "Initial commit for Railway deployment"

# Tambahkan remote repository
git remote add origin https://github.com/USERNAME/web_tanami2.git
git branch -M main
git push -u origin main
```

---

## Step 2: Buat Project di Railway

1. Buka https://railway.app dan login dengan GitHub
2. Klik **"New Project"**
3. Pilih **"Deploy from GitHub repo"**
4. Pilih repository `web_tanami2`
5. Railway akan mendeteksi Laravel dan mulai build

---

## Step 3: Tambahkan MySQL Database

1. Di dashboard project Railway, klik **"+ New"**
2. Pilih **"Database" → "MySQL"**
3. Railway akan otomatis membuat database
4. Copy variable credentials yang muncul

---

## Step 4: Konfigurasi Environment Variables

Di dashboard Railway → Service Laravel → **Variables**, tambahkan:

```env
APP_NAME=Tanami
APP_ENV=production
APP_KEY=base64:NkRrtQe0F5v2ey1It5p4UhXXUDZUbhOC78wqlkAJBhg=
APP_DEBUG=false
APP_URL=https://YOUR-APP.up.railway.app

# Railway MySQL Variables (referensi otomatis)
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync

# Logging (Railway will show in dashboard)
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

> **Tip:** Gunakan syntax `${{MySQL.VARIABLE}}` untuk referensi variable dari service MySQL Railway.

---

## Step 5: Generate Domain Publik

1. Di dashboard service Laravel, klik tab **"Settings"**
2. Scroll ke **"Networking"**
3. Klik **"Generate Domain"**
4. Railway akan membuat URL seperti: `https://web-tanami2.up.railway.app`

---

## Step 6: Jalankan Migrasi & Seeder

Railway akan otomatis menjalankan migrasi saat deploy karena sudah dikonfigurasi di `nixpacks.toml`.

Untuk menjalankan seeder manual:

1. Buka tab **"Deploy"** → klik tombol **"..."** → **"Run Command"**
2. Ketik: `php artisan db:seed --force`
3. Klik **"Run"**

---

## Step 7: Tambahkan User Admin

Jalankan command ini di Railway:

```bash
php artisan tinker --execute="
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
Pengguna::create([
    'nama_lengkap' => 'Admin',
    'email' => 'admin',
    'password' => Hash::make('admin'),
    'role_pengguna' => 'admin',
    'alamat' => 'Kantor Pusat',
    'no_hp' => '081234567899',
    'is_verified' => true,
]);
"
```

---

## Troubleshooting

### Error: APP_KEY not set

```bash
php artisan key:generate --show
```

Copy hasilnya dan set di environment variable `APP_KEY`.

### Error: Storage permission

Pastikan folder storage sudah di-commit:

```bash
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p storage/logs
touch storage/logs/.gitkeep
git add storage -f
```

### Error: Asset tidak loading (CSS/JS)

Pastikan sudah build assets:

```bash
npm run build
git add public/build -f
git commit -m "Add compiled assets"
git push
```

---

## File yang Sudah Dibuat

| File            | Fungsi                            |
| --------------- | --------------------------------- |
| `Procfile`      | Konfigurasi web process           |
| `nixpacks.toml` | Build configuration untuk Railway |
| `.env.railway`  | Template environment variables    |

---

## URL Final Setelah Deploy

Setelah deploy berhasil, update dokumentasi dengan:

- **URL:** `https://YOUR-APP.up.railway.app`
- **Login Admin:** email = `admin`, password = `admin`

---

_Railway menyediakan $5 free credit per bulan yang cukup untuk testing._
