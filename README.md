# Sistem Katering Nusantara (Advanced Eager Loading)

Nama: Alwi Husein Shahab  
Kelas: XI-3 RPL

## Deskripsi

Simulasi sistem katering dengan 7 tabel berelasi kompleks. Proyek ini
mendemonstrasikan penyelesaian ekstrem dari N+1 Query Problem menggunakan
Nested Eager Loading.

## Struktur Data

| Tabel | Relasi |
|---|---|
| `cities` | punya banyak `customers` |
| `categories` | punya banyak `menus` |
| `payment_methods` | punya banyak `orders` |
| `couriers` | punya banyak `orders` |
| `customers` | milik `city` |
| `menus` | milik `category` |
| `orders` | milik `customer`, `payment_method`, `courier`; punya banyak `order_items` |
| `order_items` | milik `order`, `menu` |

## Solusi Nested Eager Loading

Dasbor admin (`/admin/dashboard`, lihat `App\Http\Controllers\Admin\DashboardController`)
menampilkan pesanan beserta data yang berelasi hingga 3 tingkat kedalaman.
Query dioptimalkan dengan notasi titik:

```php
$orders = Order::with([
    'customer.city',
    'paymentMethod',
    'courier',
    'orderItems.menu.category',
])->latest()->paginate(15);
```

`Model::preventLazyLoading(! app()->isProduction())` juga diaktifkan di
`AppServiceProvider` supaya lazy loading yang tidak sengaja langsung
melempar exception saat pengembangan, bukan diam-diam menjalankan query
tambahan.

## Instalasi

```bash
composer install
npm install
cp .env.example .env   # jika belum ada .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

Kunjungi `http://127.0.0.1:8000` — halaman akan otomatis diarahkan ke
`/admin/dashboard`.

## Memasang Laravel Debugbar (opsional, untuk bukti optimasi di poin 4)

Jangan menambahkan `barryvdh/laravel-debugbar` dengan mengedit `composer.json`
secara manual — itu bisa membuat `composer.lock` tidak sinkron. Gunakan
perintah `composer require` supaya Composer memilih versi yang benar-benar
kompatibel dengan Laravel 13 dan langsung memperbarui lock file:

```bash
composer require barryvdh/laravel-debugbar --dev
```

Setelah terpasang, jalankan `php artisan serve` lagi dan buka
`/admin/dashboard` — panel Debugbar akan muncul di bagian bawah browser
dan menampilkan jumlah query yang dijalankan.

## Bukti Optimasi

- **Screenshot Lazy Loading (Error/Ratusan Query):** [Masukkan Gambar]
- **Screenshot Eager Loading (Berhasil ditekan di bawah 10 Query):** [Masukkan Gambar]