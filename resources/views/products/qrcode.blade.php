<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Produk - {{ $product->name }}</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .qr-container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .qr-code img {
            width: 200px;
            height: 200px;
            margin: 20px 0;
        }
        .btn-custom {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-download {
            background-color: #28a745;
            color: #fff;
            border: none;
        }
        .btn-print {
            background-color: #007bff;
            color: #fff;
            border: none;
        }
        .btn-back {
            background-color: #6c757d;
            color: #fff;
            border: none;
        }
        .btn-download:hover, .btn-print:hover, .btn-back:hover {
            opacity: 0.9;
        }
        @media print {
        .btn-custom {
            display: none !important;
        }
    }
    </style>
</head>
<body>
    <div class="qr-container">
        <h1>{{ $product->name }}</h1>
        <div class="qr-code">
            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
        </div>
        <p>Rp {{ number_format($harga, 0, ',', '.') }}</p>
        <div>
            {{-- <a href="{{ route('products.qrcode.pdf', $product) }}" target="_blank" class="btn-custom btn-download">Download PDF</a> --}}
            <a href="{{ route('products.generatePdf', $product) }}" class="btn-custom btn-download" target="_blank">Download PDF</a>
            <button onclick="window.print()" class="btn-custom btn-print">Print Halaman Ini</button>
            <button onclick="history.back()" class="btn-custom btn-back">Kembali</button>
        </div>
    </div>
</body>
</html>