<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Pembelian - {{ $label }} - Eat This One</title>
    <style>
        :root { color-scheme: light; font-family: Arial, sans-serif; }
        body { margin: 0; background: #f4f7ff; color: #0b1a3a; }
        .sheet { width: min(980px, calc(100% - 32px)); margin: 32px auto; padding: 36px; background: #fff; box-shadow: 0 10px 35px rgba(0, 56, 255, .12); }
        .brand { display: flex; align-items: center; justify-content: space-between; gap: 16px; border-bottom: 2px solid #0038ff; padding-bottom: 20px; }
        .brand-main { display: flex; align-items: center; gap: 16px; }
        .brand img { width: 72px; height: 72px; border-radius: 50%; object-fit: cover; }
        .brand h1 { margin: 0; color: #0038ff; font-size: 28px; }
        .brand p, .range { margin: 6px 0 0; color: #405070; }
        .range { text-align: right; font-size: 13px; }
        .summary { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; padding: 24px 0; }
        .summary div { padding: 14px; background: #f4f7ff; border: 1px solid #dbe5ff; border-radius: 10px; }
        .summary small { display: block; margin-bottom: 5px; color: #405070; text-transform: uppercase; letter-spacing: .08em; font-size: 10px; }
        .summary strong { color: #0038ff; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 11px 8px; border-bottom: 1px solid #dbe5ff; text-align: left; font-size: 13px; }
        th { color: #0038ff; font-size: 10px; text-transform: uppercase; letter-spacing: .08em; }
        .number, .price { text-align: right; }
        .total { display: flex; justify-content: space-between; margin-top: 22px; padding: 18px 0; border-top: 2px solid #0038ff; font-size: 20px; font-weight: 700; color: #0038ff; }
        .empty { padding: 28px 0; color: #405070; text-align: center; }
        .footer { margin-top: 36px; text-align: center; color: #405070; font-size: 12px; }
        .print-button { position: fixed; right: 24px; top: 24px; padding: 11px 16px; border: 0; border-radius: 99px; background: #0038ff; color: white; font-weight: 700; cursor: pointer; }
        @media print { body { background: white; } .sheet { width: auto; margin: 0; box-shadow: none; } .print-button { display: none; } }
        @media (max-width: 620px) { .sheet { padding: 22px; } .brand, .brand-main { align-items: flex-start; flex-direction: column; } .range { text-align: left; } .summary { grid-template-columns: 1fr; } table { display: block; overflow-x: auto; white-space: nowrap; } }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">Print rekap</button>
    <main class="sheet">
        <header class="brand">
            <div class="brand-main">
                <img src="{{ asset('logo.jpg') }}" alt="Eat This One">
                <div><h1>Eat This One</h1><p>Rekap pembelian</p></div>
            </div>
            <p class="range"><strong>{{ $label }}</strong><br>{{ $start->format('d M Y H:i') }} - {{ $end->format('d M Y H:i') }}</p>
        </header>
        <section class="summary">
            <div><small>Jumlah order</small><strong>{{ $orders->count() }}</strong></div>
            <div><small>Item terjual</small><strong>{{ $orders->sum(fn ($order) => $order->items->sum('quantity')) }}</strong></div>
            <div><small>Total pemasukan</small><strong>Rp {{ number_format($orders->sum(fn ($order) => $order->total), 0, ',', '.') }}</strong></div>
        </section>
        @if($orders->isEmpty())
            <p class="empty">Tidak ada pembelian pada periode ini.</p>
        @else
            <table>
                <thead><tr><th>No. Order</th><th>Pelanggan</th><th>Waktu</th><th>Status</th><th class="number">Item</th><th class="price">Total</th></tr></thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr><td>{{ $order->order_number }}</td><td>{{ $order->customer_name }}<br>{{ $order->customer_phone }}</td><td>{{ optional($order->ordered_at)->format('d M Y H:i') }}</td><td>{{ ucfirst($order->status) }}</td><td class="number">{{ $order->items->sum('quantity') }}</td><td class="price">Rp {{ number_format($order->total, 0, ',', '.') }}</td></tr>
                    @endforeach
                </tbody>
            </table>
            <div class="total"><span>Total pemasukan</span><span>Rp {{ number_format($orders->sum(fn ($order) => $order->total), 0, ',', '.') }}</span></div>
        @endif
        <footer class="footer">Eat This One · Small bites, big happiness.<br>eat.this.one_ · WhatsApp 0823 1168 1167</footer>
    </main>
</body>
</html>
