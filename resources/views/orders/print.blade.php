<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap {{ $order->order_number }} - Eat This One</title>
    <style>
        :root { color-scheme: light; font-family: Arial, sans-serif; }
        body { margin: 0; background: #f7f0f4; color: #351827; }
        .sheet { width: min(760px, calc(100% - 32px)); margin: 32px auto; padding: 36px; background: #fffdf7; box-shadow: 0 10px 35px rgba(163, 29, 93, .12); }
        .brand { display: flex; align-items: center; gap: 16px; border-bottom: 2px solid #a31d5d; padding-bottom: 20px; }
        .brand img { width: 84px; height: 84px; border-radius: 50%; object-fit: cover; }
        .brand h1 { margin: 0; color: #a31d5d; font-size: 28px; }
        .brand p { margin: 6px 0 0; color: #765568; }
        .meta { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px 24px; padding: 24px 0; }
        .meta small { display: block; margin-bottom: 4px; color: #9d8190; text-transform: uppercase; letter-spacing: .08em; font-size: 10px; }
        .meta strong { font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 8px; border-bottom: 1px solid #ead8e1; text-align: left; font-size: 14px; }
        th { color: #a31d5d; font-size: 11px; text-transform: uppercase; letter-spacing: .08em; }
        .number, .price { text-align: right; }
        .total { display: flex; justify-content: space-between; margin-top: 22px; padding: 18px 0; border-top: 2px solid #a31d5d; font-size: 20px; font-weight: 700; color: #a31d5d; }
        .notes { margin-top: 16px; padding: 14px; border-radius: 12px; background: #fdf2f7; color: #765568; font-size: 13px; }
        .footer { margin-top: 36px; text-align: center; color: #9d8190; font-size: 12px; }
        .print-button { position: fixed; right: 24px; top: 24px; padding: 11px 16px; border: 0; border-radius: 99px; background: #a31d5d; color: white; font-weight: 700; cursor: pointer; }
        @media print { body { background: white; } .sheet { width: auto; margin: 0; box-shadow: none; } .print-button { display: none; } }
        @media (max-width: 520px) { .sheet { padding: 22px; } .meta { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">Print rekap</button>
    <main class="sheet">
        <header class="brand">
            <img src="{{ asset('logo.jpg') }}" alt="Eat This One">
            <div>
                <h1>Eat This One</h1>
                <p>Rekap pembelian pelanggan</p>
            </div>
        </header>
        <section class="meta">
            <div><small>Nomor order</small><strong>{{ $order->order_number }}</strong></div>
            <div><small>Status</small><strong>{{ ucfirst($order->status) }}</strong></div>
            <div><small>Nama pelanggan</small><strong>{{ $order->customer_name }}</strong></div>
            <div><small>WhatsApp</small><strong>{{ $order->customer_phone }}</strong></div>
            <div><small>Waktu order</small><strong>{{ optional($order->ordered_at)->format('d M Y, H:i') }}</strong></div>
        </section>
        <table>
            <thead><tr><th>Item</th><th>Jenis</th><th class="number">Qty</th><th class="price">Subtotal</th></tr></thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr><td>{{ $item->item_name }}</td><td>{{ $item->item_type === 'addon' ? 'Packing' : 'Produk' }}</td><td class="number">{{ $item->quantity }}</td><td class="price">Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}</td></tr>
                @endforeach
            </tbody>
        </table>
        <div class="total"><span>Total pembayaran</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
        @if($order->notes)<div class="notes"><strong>Catatan:</strong> {{ $order->notes }}</div>@endif
        <footer class="footer">Terima kasih sudah memilih Eat This One<br>eat.this.one_ · WhatsApp 0823 1168 1167</footer>
    </main>
</body>
</html>
