# Kasir (Laravel)

Fitur utama:
- 3 role: admin, cashier, user (default hasil register = user)
- Auth (login/register/logout)
- Dashboard:
  - Admin: grafik penjualan 7 hari, notifikasi status bayar, kelola produk, laporan, pengeluaran
  - Cashier: katalog produk, daftar pesanan pending, tandai sudah dibayar, cetak struk
  - User: belanja (di toko / ambil nanti), keranjang, checkout, riwayat + struk
- Produk: diskon nominal/persen, upload gambar, pack template (pack_size, initial_packs -> stok otomatis)
- Order: struk print, expired otomatis jika ambil-nanti melewati jam & belum dibayar (via command)
- Laporan: pemasukan, pengeluaran, keuntungan bersih, download PDF (weekly/bulanan)

## Setup
1) Buat database MySQL `kasir` (sudah dibuat otomatis jika XAMPP aktif). Pastikan `.env` sudah:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kasir
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=file
```

2) Install dependency (sudah dilakukan saat scaffold), generate storage symlink:
```
# opsional bila belum
composer install
php artisan storage:link
```

3) Migrasi + seeder contoh:
```
php artisan migrate --force
php artisan db:seed --class=Database\\Seeders\\RoleUserSeeder
php artisan db:seed --class=Database\\Seeders\\ProductSeeder
```

- Login admin: admin@example.com / password
- Login cashier: cashier@example.com / password

4) Jalankan server dev:
```
php artisan serve
```
Akses: http://127.0.0.1:8000

## Peran & Akses
- Admin: `/admin`, kelola `products`, `reports`, `expenses`
- Cashier: `/cashier` + katalog `/orders/catalog`
- User: `/user` + belanja `/shop`

## Expire Otomatis (Ambil Nanti)
- Command: `php artisan orders:expire` akan menandai order ambil-nanti yang melewati `pickup_at` dengan status `expired` (tidak dihitung di laporan).
- Di Windows (Task Scheduler): buat task tiap 5 menit menjalankan:
```
php C:\xampp\htdocs\kasir\laravel\artisan orders:expire
```

## Cetak Struk
- Setelah pembayaran (kasir menekan "Tandai Sudah Dibayar"), buka tombol "Struk" untuk cetak (print dialog browser).

## Catatan
- Manajemen User untuk Admin (CRUD User) belum dibuat di versi awal ini. Jika diinginkan, bisa ditambahkan pada langkah berikutnya.
- Jika ingin otentikasi UI yang lebih lengkap, bisa install Breeze/Jetstream nanti.
