<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Courier;
use App\Models\Order;

class DashboardController extends Controller
{
    /**
     * Dasbor admin: menampilkan daftar pesanan lengkap dengan data
     * pelanggan + kota, item pesanan + menu + kategori, kurir, dan
     * metode pembayaran — data yang berelasi hingga 3 tingkat kedalaman.
     *
     * ================= SOLUSI NESTED EAGER LOADING =================
     * Tanpa eager loading, setiap baris tabel akan memicu query lazy
     * loading terpisah untuk customer, city, courier, paymentMethod,
     * orderItems, menu, dan category — total bisa mencapai ribuan
     * query untuk 150 order (N+1 berlapis / N+1 bertingkat).
     *
     * Dengan notasi titik (.) pada with(), Laravel menggabungkan semua
     * relasi bertingkat itu menjadi beberapa query saja (idealnya di
     * bawah 10 query), tidak peduli berapa banyak order/order_item-nya.
     * =================================================================
     */
    public function index()
    {
        $orders = Order::with([
            'customer.city',
            'paymentMethod',
            'courier',
            'orderItems.menu.category',
        ])
            ->latest()
            ->paginate(15);

        $stats = [
            'total_orders'  => Order::count(),
            'total_cities'  => City::count(),
            'total_couriers' => Courier::count(),
        ];

        return view('admin.dashboard', compact('orders', 'stats'));
    }
}
