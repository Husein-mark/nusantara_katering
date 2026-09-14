<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Tampilkan dasbor admin: daftar order lengkap.
     *
     * =====================================================================
     * JEBAKAN N+1 QUERY (JANGAN LAKUKAN INI):
     *
     *     $orders = Order::paginate(15);
     *     // lalu di view melakukan:
     *     // $order->customer->name
     *     // $order->customer->city->name
     *     // $order->courier->name
     *     // $order->paymentMethod->name
     *     // foreach ($order->orderItems as $item) { $item->menu->name; $item->menu->category->name; }
     *
     * Setiap baris di atas, kalau dipanggil dengan Lazy Loading, akan
     * memicu query baru ke database SETIAP KALI diakses per-order.
     * Dengan 150 order x rata-rata 4 item, bisa menghasilkan RIBUAN query
     * (order + customer + city + courier + payment + item + menu + category
     * dikalikan jumlah baris) -> server bisa down / sangat lambat.
     *
     * SOLUSI: Nested Eager Loading dengan notasi titik (.)
     * Ini akan menggabungkan semua kebutuhan relasi menjadi query yang
     * jumlahnya TETAP (konstan), berapa pun banyaknya data order/item.
     * =====================================================================
     */
    public function index()
    {
        $orders = Order::with([
            'customer.city',              // Order -> Customer -> City
            'paymentMethod',              // Order -> PaymentMethod
            'courier',                    // Order -> Courier
            'orderItems.menu.category',   // Order -> OrderItem -> Menu -> Category
        ])->latest()->paginate(15);

        return view('orders.index', compact('orders'));
    }
}
