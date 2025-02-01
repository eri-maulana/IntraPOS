<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR Code Produk - {{ $product->name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }
        .page {
            width: 210mm; /* Lebar kertas A4 */
            height: 297mm; /* Tinggi kertas A4 */
            margin: 0 auto;
            padding: 5mm;
            box-sizing: border-box;
            /* page-break-after: always; Memastikan setiap halaman terpisah */
        }
        table {
            width: 100vh;
            border-collapse: collapse; /* Menghilangkan jarak antar sel */
        }
        td {
            width: 35%; /* 3 kolom per baris */
            text-align: center;
            border: 1px solid #000; /* Garis kotak */
            padding: 10px;
            box-sizing: border-box;
        }
        td img {
            width: 80%; /* Sesuaikan ukuran QR code */
            height: auto;
        }
        td p {
            margin: 5px 0 0;
            font-size: 12px;
        }
        .nama-produk{
            font-weight: bold;
            margin-bottom: 5px;
        }
        @media print {
            .page {
                margin: 0;
                padding: 0;
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <table>
            <!-- Loop untuk membuat 5 baris -->
            @for ($i = 0; $i < 6; $i++)
                <tr>
                    <!-- Loop untuk membuat 3 kolom per baris -->
                    @for ($j = 0; $j < 5; $j++)
                        <td>
                            <p class="nama-produk">{{ $product->name }}</p>
                            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
                            <p>Rp: {{ number_format($harga, 0, ',', '.') }}</p>
                        </td>
                    @endfor
                </tr>
            @endfor
        </table>
    </div>
</body>
</html>