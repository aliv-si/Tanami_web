<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #22c55e;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #22c55e;
        }

        .order-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .order-id {
            font-size: 24px;
            font-weight: bold;
            color: #166534;
        }

        .amount {
            font-size: 28px;
            font-weight: bold;
            color: #dc2626;
            margin: 10px 0;
        }

        .deadline {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }

        .deadline-label {
            color: #991b1b;
            font-weight: bold;
        }

        .deadline-time {
            font-size: 20px;
            color: #dc2626;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            background-color: #22c55e;
            color: #ffffff;
            padding: 15px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin: 20px 0;
        }

        .btn:hover {
            background-color: #16a34a;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th,
        .items-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .items-table th {
            background-color: #f9fafb;
            font-weight: 600;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }

        .warning {
            color: #dc2626;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">🌿 TANAMI</div>
            <p>Marketplace Produk Pertanian</p>
        </div>

        <h2>Halo, {{ $pesanan->pembeli->nama_lengkap }}!</h2>

        <p>Pesanan Anda belum dibayar. Segera selesaikan pembayaran sebelum batas waktu berakhir.</p>

        <div class="order-box">
            <div class="order-id">Pesanan #{{ $pesanan->id_pesanan }}</div>
            <p>Tanggal: {{ $pesanan->tgl_dibuat->format('d M Y, H:i') }}</p>
            <div class="amount">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</div>
        </div>

        <div class="deadline">
            <div class="deadline-label">⏰ Batas Waktu Pembayaran:</div>
            <div class="deadline-time">{{ $pesanan->batas_bayar->format('d M Y, H:i') }} WIB</div>
            <p class="warning">Sisa waktu kurang dari 6 jam!</p>
        </div>

        @if($pesanan->items->count() > 0)
        <h3>Detail Pesanan:</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->items as $item)
                <tr>
                    <td>{{ $item->produk->nama_produk ?? 'Produk' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <table style="width: 100%; margin: 20px 0;">
            <tr>
                <td>Subtotal</td>
                <td style="text-align: right;">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Ongkir ({{ $pesanan->kota->nama_kota ?? '-' }})</td>
                <td style="text-align: right;">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</td>
            </tr>
            @if($pesanan->diskon > 0)
            <tr>
                <td>Diskon</td>
                <td style="text-align: right; color: #dc2626;">- Rp {{ number_format($pesanan->diskon, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr style="font-weight: bold; font-size: 18px;">
                <td>Total Bayar</td>
                <td style="text-align: right;">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div style="text-align: center;">
            <a href="{{ url('/pesanan/' . $pesanan->id_pesanan) }}" class="btn">
                Bayar Sekarang
            </a>
        </div>

        <p style="color: #6b7280; font-size: 14px;">
            <strong>Catatan:</strong> Jika pembayaran tidak dilakukan sebelum batas waktu, pesanan akan otomatis dibatalkan dan stok akan dikembalikan.
        </p>

        <div class="footer">
            <p>Email ini dikirim otomatis oleh sistem TANAMI.</p>
            <p>Jika Anda tidak melakukan pesanan ini, abaikan email ini.</p>
            <p>&copy; {{ date('Y') }} TANAMI - Marketplace Produk Pertanian</p>
        </div>
    </div>
</body>

</html>