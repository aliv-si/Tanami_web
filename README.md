# 🌱 Panduan Setup Project Tanami

Panduan lengkap untuk melakukan setup project **Tanami** dari awal di environment lokal.

---

## 📋 Persyaratan Sistem

Pastikan Anda sudah menginstall:

| Software      | Versi Minimum | Cek Versi     |
| ------------- | ------------- | ------------- |
| PHP           | 8.2+          | `php -v`      |
| Composer      | 2.x           | `composer -V` |
| Node.js       | 18+           | `node -v`     |
| NPM           | 8+            | `npm -v`      |
| MySQL/MariaDB | 5.7+ / 10.3+  | `mysql -V`    |

> [!TIP]
> Jika menggunakan **Laragon**, semua persyaratan di atas sudah tersedia secara default.

---

## 🚀 Langkah-Langkah Setup

### 1. Clone Repository

```bash
git clone <repository-url> web_tanami
cd web_tanami
```

### 2. Install Dependencies PHP

```bash
composer install
```

> [!WARNING]
> Jika muncul error tentang versi PHP, jalankan `composer update` untuk menyesuaikan package dengan versi PHP Anda.

### 3. Konfigurasi Environment

Copy file `.env.example` menjadi `.env`:

```bash
copy .env.example .env
```

Atau di Linux/Mac:

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

**Untuk MySQL:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tanami
DB_USERNAME=root
DB_PASSWORD=
```

**Untuk SQLite (default):**

```env
DB_CONNECTION=sqlite
```

Jika menggunakan SQLite, buat file database:

```bash
# Windows
type nul > database\database.sqlite

# Linux/Mac
touch database/database.sqlite
```

### 6. Jalankan Migrasi Database

```bash
php artisan migrate
```

> [!NOTE]
> Jika ada seeder, jalankan juga:
>
> ```bash
> php artisan db:seed
> ```

### 7. Install Dependencies Node.js

```bash
npm install
```

### 8. Build Assets

**Untuk development:**

```bash
npm run dev
```

**Untuk production:**

```bash
npm run build
```

---

## ▶️ Menjalankan Aplikasi

**Terminal 1 - PHP Server:**

```bash
php artisan serve
```

**Terminal 2 - Storage Link:**

```bash
php artisan storage:link
```

<!-- **Terminal 2 - Vite (untuk hot reload):**

```bash
npm run dev
``` -->

### Opsi 3: Menggunakan Laragon

1. Pastikan project ada di folder `laragon/www/`
2. Start Laragon
3. Akses via browser: `http://web_tanami.test` atau `http://localhost/web_tanami/public`

---

## 🛠️ Quick Setup (One Command)

Jika Anda ingin setup cepat, gunakan:

```bash
composer run setup
```

Ini akan otomatis:

1. Install dependencies PHP
2. Copy `.env.example` ke `.env`
3. Generate application key
4. Link storage
5. Jalankan migrasi
6. Install dependencies Node.js
7. Build assets

---

## 🔧 Troubleshooting

### Error: "Your lock file does not contain a compatible set of packages"

```bash
composer update
```

### Error: "file_put_contents... Resource temporarily unavailable"

1. Tutup VS Code/Editor
2. Stop Laragon
3. Jalankan ulang `composer install`

### Error: "SQLSTATE[HY000]: General error: 1 no such table"

```bash
php artisan migrate:fresh
```

### Error: "Vite manifest not found"

```bash
npm run build
```

### Cache Issues

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## 📁 Struktur Folder Penting

```
web_tanami/
├── app/                 # Logic aplikasi
├── bootstrap/           # File bootstrap framework
├── config/              # File konfigurasi
├── database/
│   ├── migrations/      # File migrasi database
│   ├── factories/       # Factory untuk testing
│   └── seeders/         # Seeder data awal
├── public/              # Entry point & assets publik
├── resources/
│   ├── views/           # Blade templates
│   ├── css/             # Style CSS
│   └── js/              # JavaScript
├── routes/              # Definisi routing
├── storage/             # File generated & logs
├── tests/               # Unit & Feature tests
├── .env                 # Environment variables (JANGAN commit!)
├── composer.json        # Dependencies PHP
└── package.json         # Dependencies Node.js
```

---

## 📝 Catatan Tambahan

- **Never commit** file `.env` ke repository
- Selalu jalankan `composer install` dan `npm install` setelah `git pull`
- Jika ada perubahan migrasi baru, jalankan `php artisan migrate`

---

## 🔗 Useful Links

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Vite](https://vitejs.dev/)

---

**Happy Coding! 🌿**
