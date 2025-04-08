# Admin Dashboard Laravel

Sebuah frontend modern untuk Admin Dashboard yang terintegrasi dengan API Backend Go. Dashboard ini dikembangkan menggunakan Laravel dan dirancang dengan tampilan modern, minimalis, dan responsif.

## Demo

Akses demo aplikasi di: [http://admindashboardlaravel.wuaze.com](http://admindashboardlaravel.wuaze.com)

## Fitur

- 🔐 Autentikasi menggunakan JWT
- 📊 Dashboard dengan statistik
- 👥 Manajemen pengguna
- 🏷️ Manajemen peran (roles)
- 🏢 Manajemen divisi
- 📋 Manajemen posisi
- 👤 Halaman profil
- 🎨 Tema dengan palette warna modern
- 📱 Desain responsif
- 🔔 Notifikasi menggunakan SweetAlert

## Teknologi

- Laravel 10
- Tailwind CSS (via CDN)
- SweetAlert
- Font Awesome

## Palette Warna

- Accent: #BF161C (merah)
- Gray: #E0FBFC (abu-abu muda)
- Background: #253237 (biru gelap)

## Penggunaan

### Login

![Login](./images/login-screen.png)

Gunakan kredensial yang valid untuk login ke dashboard.

### Dashboard

![Dashboard](./images/dashboard-screen.png)

Dashboard menampilkan statistik utama seperti:
- Total Users
- Active Users
- Total Divisions
- Total Positions
- Users Per Division
- Users Per Position
- New Users This Month

### Manajemen Pengguna

![Users](./images/users-screen.png)

Menu ini memungkinkan Anda:
- Melihat daftar pengguna
- Menambah pengguna baru
- Mengedit informasi pengguna
- Menghapus pengguna
- Mencari pengguna berdasarkan kata kunci

### Manajemen Peran

![Roles](./images/roles-screen.png)

Menu ini memungkinkan Anda:
- Melihat daftar peran
- Menambah peran baru
- Mengedit peran
- Menghapus peran

### Manajemen Divisi

![Divisions](./images/divisions-screen.png)

Menu ini memungkinkan Anda:
- Melihat daftar divisi
- Menambah divisi baru
- Mengedit divisi
- Menghapus divisi

### Manajemen Posisi

![Positions](./images/positions-screen.png)

Menu ini memungkinkan Anda:
- Melihat daftar posisi
- Menambah posisi baru
- Mengedit posisi
- Menghapus posisi

### Profil

![Profile](./images/profile-screen.png)

Halaman profil menampilkan informasi pengguna yang sedang login.

## Instalasi Lokal

### Persyaratan

- PHP >= 8.0
- Composer
- Laravel 10

### Langkah-langkah

1. Clone repositori
```bash
git clone https://github.com/yourusername/admin-dashboard-laravel.git
cd admin-dashboard-laravel
```

2. Instal dependensi
```bash
composer install
```

3. Salin file .env.example menjadi .env
```bash
cp .env.example .env
```

4. Konfigurasi file .env
```
ADMIN_API_URL=https://admindashboardbackend-production-ba79.up.railway.app
```

5. Generate key aplikasi
```bash
php artisan key:generate
```

6. Jalankan server pengembangan
```bash
php artisan serve
```

7. Akses aplikasi di http://localhost:8000

## Struktur Proyek

```
admin-dashboard/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── UserController.php
│   │   │   ├── RoleController.php
│   │   │   ├── DivisionController.php
│   │   │   ├── PositionController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   │       └── ApiAuthentication.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   └── login.blade.php
│       ├── users/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── roles/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── divisions/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── positions/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── dashboard.blade.php
│       └── profile.blade.php
└── routes/
    └── web.php
```

## API Backend

Dashboard ini terintegrasi dengan API Backend Go yang tersedia di:  
https://admindashboardbackend-production-ba79.up.railway.app

## Kontribusi

Kontribusi untuk meningkatkan proyek ini sangat diterima. Silakan fork repositori, buat perubahan, dan kirimkan pull request.

## Lisensi

[MIT License](LICENSE)

## Kontak

Jika Anda memiliki pertanyaan, silakan buka issue di repositori ini atau hubungi pengembang di [email@example.com](mailto:email@example.com).

---

&copy; 2025 Admin Dashboard Laravel. Dibuat dengan 💻 dan ❤️
