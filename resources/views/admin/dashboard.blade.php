@extends('layouts.app')

@section('title', 'Dasbor Pesanan')

@section('content')
    <div class="kn-shell">

        <header class="kn-masthead">
            <div class="kn-brand">
                Rasa Nusantara
                <span>Sistem Katering Nusantara</span>
            </div>
            <div class="kn-context">
                <strong>Dasbor Pesanan</strong>
                Panel Admin
            </div>
        </header>

        <section class="kn-summary" aria-label="Ringkasan operasional">
            <div class="kn-summary-item">
                <span class="kn-summary-number">{{ number_format($stats['total_orders']) }}</span>
                <span class="kn-summary-label">Total Pesanan Tercatat</span>
            </div>
            <div class="kn-summary-item">
                <span class="kn-summary-number">{{ number_format($stats['total_cities']) }}</span>
                <span class="kn-summary-label">Kota Terlayani</span>
            </div>
            <div class="kn-summary-item">
                <span class="kn-summary-number">{{ number_format($stats['total_couriers']) }}</span>
                <span class="kn-summary-label">Kurir Aktif</span>
            </div>
        </section>

        <h1 class="kn-section-title">Daftar Pesanan</h1>

        <div class="kn-table-wrap">
            <table class="kn-table">
                <thead>
                    <tr>
                        <th scope="col">ID Order</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Pesanan</th>
                        <th scope="col">Pengiriman &amp; Pembayaran</th>
                        <th scope="col">Total</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="kn-order-id">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>

                            <td>
                                <span class="kn-customer-name">{{ $order->customer->name }}</span>
                                <span class="kn-customer-city">{{ $order->customer->city->name }}</span>
                            </td>

                            <td>
                                <ul class="kn-item-list">
                                    @foreach ($order->orderItems as $item)
                                        <li>
                                            <span class="kn-item-qty">{{ $item->qty }}x</span>
                                            {{ $item->menu->name }}
                                            <span class="kn-item-category">({{ $item->menu->category->name }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>

                            <td>
                                <span class="kn-delivery-courier">{{ $order->courier->name }}</span>
                                <span class="kn-delivery-method">{{ $order->paymentMethod->name }}</span>
                            </td>

                            <td class="kn-order-total">{{ $order->formatted_total }}</td>

                            <td>
                                <span class="kn-status kn-status-{{ $order->status }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Belum ada data pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="kn-pagination">
            {{ $orders->links() }}
        </div>

        <p class="kn-footnote">
            Tabel di atas dimuat menggunakan nested eager loading
            (<code>customer.city</code>, <code>orderItems.menu.category</code>,
            <code>paymentMethod</code>, <code>courier</code>) sehingga jumlah query
            tetap rendah walau relasi data mencapai tiga tingkat kedalaman.
        </p>

    </div>
@endsection
