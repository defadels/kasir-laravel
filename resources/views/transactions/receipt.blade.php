<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Transaksi - {{ $transaction->transaction_code }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .mt-2 { margin-top: 8px; }
        .mb-2 { margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { padding: 4px; border-bottom: 1px dashed #ccc; }
        .total { font-size: 14px; font-weight: bold; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div class="center bold">TOKO TRIDIG</div>
    <div class="center"><img src="{{ public_path('logo.jpg') }}" style="width: 100px; height: 100px;" alt="Logo" class="h-16 w-auto"></div>
    <div class="center">Jl. Contoh Alamat No. 123</div>
    <div class="center mb-2">Telp: 0812-3456-7890</div>
    <hr>
    <div>Kode: <span class="bold">{{ $transaction->transaction_code }}</span></div>
    <div>Tanggal: {{ $transaction->transaction_date->format('d/m/Y H:i') }}</div>
    <div>Kasir: {{ $transaction->user->name }}</div>
    @if($transaction->customer_name)
        <div>Pelanggan: {{ $transaction->customer_name }}</div>
    @endif
    <hr>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="right">Qty</th>
                <th class="right">Harga</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td class="right">{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <div class="right">Subtotal: Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</div>
    @if($transaction->discount_amount > 0)
        <div class="right">Diskon: -Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</div>
    @endif
    @if($transaction->tax_amount > 0)
        <div class="right">Pajak: Rp {{ number_format($transaction->tax_amount, 0, ',', '.') }}</div>
    @endif
    <div class="right total">Total: Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>
    <div class="right">Dibayar: Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</div>
    <div class="right">Kembalian: Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</div>
    <hr>
    <div class="center mt-2">Terima kasih atas kunjungan Anda!</div>
</body>
</html> 