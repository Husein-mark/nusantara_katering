<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dasbor Admin - Rasa Nusantara</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; background: #f5f5f5; }
        h1 { color: #b23b1d; }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 10px 12px; vertical-align: top; text-align: left; }
        th { background: #b23b1d; color: #fff; }
        tr:nth-child(even) { background: #fafafa; }
        ul { margin: 0; padding-left: 18px; }
        .kota { color: #666; font-size: 0.9em; }
        .kategori { color: #888; font-size: 0.85em; }
        .status { display: inline-block; padding: 2px 8px; border-radius: 4px; background: #eee; font-size: 0.85em; }
        .pagination { margin-top: 16px; }
    </style>
</head>
<body>
    <h1>Dasbor Admin - Pesanan Rasa Nusantara</h1>

    <table>
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Pelanggan</th>
                <th>Pesanan</th>
                <th>Pengiriman & Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>
                        {{ $order->customer->name }}<br>
                        <span class="kota">{{ $order->customer->city->name }}</span>
                    </td>
                    <td>
                        <ul>
                            @foreach ($order->orderItems as $item)
                                <li>
                                    {{ $item->qty }}x {{ $item->menu->name }}
                                    <span class="kategori">({{ $item->menu->category->name }})</span>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        {{ $order->courier->name }} - {{ $order->paymentMethod->name }}
                    </td>
                    <td>
                        <span class="status">{{ ucfirst($order->status) }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $orders->links() }}
    </div>
</body>
</html>
