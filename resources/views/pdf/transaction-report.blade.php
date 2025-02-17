<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        @page { 
            size: A4 landscape; /* Mengatur ukuran kertas A4 landscape */
            margin: 15px;
        }
        body {
            font-family: 'Times New Roman', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding-right: 30px;
        }
        h1 {
            text-align: center;
            font-size: 25px;
            margin-bottom: 10px;
        }
        p {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }
        /* Styling tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-right: 20px;
            /* margin-left: 20px; */
            table-layout: fixed; /* Mengatur agar tabel mengikuti lebar yang telah ditentukan */
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 6px;
            word-wrap: break-word; /* Memastikan teks tetap dalam kolom */
            overflow-wrap: break-word;
        }
        table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }
        
        /* Lebar kolom disesuaikan agar tidak terlalu lebar atau sempit */
        .col-no { width: 3%; text-align: center}
        .col-id { width: 3%; text-align: center}
        .col-date { width: 10%; text-align: center}
        .col-name { width: 12%; text-align: left}
        .col-email { width: 12%;text-align: left}
        .col-phone { width: 10%; text-align: left}
        .col-product { width: 15%; text-align: left}
        .col-payment { width: 8%; text-align: center}
        .col-total { width: 10%; text-align: center}
        .col-paid { width: 10%; text-align: center}
        .col-change { width: 10%; text-align: center}
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Transaksi</h1>
        {{-- <hr style="width: 200px"> --}}
        <hr style="width: 250px">
        <p>
            Periode: {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d F Y') }} -
            {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d F Y') }}
        </p>
        <table>
            <thead>
                <tr>
                    <th class="col-no">#</th>
                    <th class="col-id">ID</th>
                    <th class="col-date">Tanggal</th>
                    <th class="col-name">Nama</th>
                    <th class="col-email">Email</th>
                    <th class="col-phone">Telepon</th>
                    <th class="col-product">Produk</th>
                    <th class="col-payment">Metode</th>
                    <th class="col-total">Total</th>
                    <th class="col-paid">Bayar</th>
                    <th class="col-change">Kembalian</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($orders as $order)
                    <tr>
                        <td class="col-no" style="text-align: center">{{ $no++ }}</td>
                        <td class="col-id">{{ $order->id }}</td>
                        <td class="col-date">{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d/m/Y') }}</td>
                        <td class="col-name">{{ $order->name }}</td>
                        <td class="col-email" style="font-size: 9px;">{{ $order->email }}</td>
                        <td class="col-phone" style="font-size: 9px;">{{ $order->phone }}</td>
                        <td class="col-product">
                            @foreach($order->orderProducts as $orderProduct)
                                ~ {{ $orderProduct->product->name }} ({{ $orderProduct->quantity }})<br>
                            @endforeach
                        </td>
                        <td class="col-payment">{{ $order->paymentMethod->name }}</td>
                        <td class="col-total">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="col-paid">Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</td>
                        <td class="col-change">Rp {{ number_format($order->change_amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
