<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        h1, p {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        th, td {
            padding: 8px;
        }
        td {
            text-align: center;
        }
        .total-harga {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Transaksi</h1>
        <p>
            Periode : <br> {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d F Y') }} - 
            {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d F Y') }}
        </p>
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th class="total-harga">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->phone }}</td>
                        <td class="total-harga">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
