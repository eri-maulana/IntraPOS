<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Masuk</title>
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
        .col-date { width: 12%; text-align: center}
        .col-name { width: 12%; text-align: left}
        .col-qty { width: 3%; text-align: center}
        .col-supplier { width: 12%;text-align: left}
        .col-description { width: 12%; text-align: left}
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Barang Masuk</h1>
        {{-- <hr style="width: 200px"> --}}
        <hr style="width: 250px">
        <p>
            Periode: {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d/m/Y') }} -
            {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d/m/Y') }}
        </p>
        <table>
            <thead>
                <tr>
                    <th class="col-no">#</th>
                    <th class="col-id">ID</th>
                    <th class="col-date">Tanggal Masuk</th>
                    <th class="col-name">Nama Produk</th>
                    <th class="col-qty">Qty</th>
                    <th class="col-supplier">Nama Suplier</th>
                    <th class="col-description">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($incomings as $incoming)
                    <tr>
                        <td class="col-no" style="text-align: center">{{ $no++ }}</td>
                        <td class="col-id">{{ $incoming->id }}</td>
                        <td class="col-date">{{ \Carbon\Carbon::parse($incoming->date_in)->translatedFormat('d/m/Y') }}</td>
                        <td class="col-name">{{ $incoming->product->name }}</td>
                        <td class="col-email" style="font-size: 9px; text-align: center">{{ $incoming->quantity }}</td>
                        <td class="col-phone" style="font-size: 9px;">{{ $incoming->supplier->company_name }}</td>
                        <td class="col-product">{{ $incoming->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
