<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Struk Belanja</title>
   <style>
       /* Mengatur ukuran kertas saat di-generate ke PDF */
       @page {
           size: 58mm auto; /* lebar 58mm, panjang menyesuaikan (auto) */
           margin: 0;       /* hilangkan margin default */
       }

       /* Reset margin & padding di body agar pas dengan ukuran kertas */
       body {
           margin: 0;
           padding: 0;
           font-family: Arial, sans-serif;
           font-size: 12px; /* Sesuaikan ukuran font jika terasa terlalu kecil/besar */
       }

       /* Wrapper utama struk */
       .receipt {
           width: 58mm;    /* pastikan lebar wrapper sama dengan lebar kertas */
           margin: 0 auto; /* center */
           padding: 5px;   /* sedikit ruang di dalam */
       }

       /* Judul Toko */
       .title {
           text-align: center;
           font-size: 25px;
           font-weight: bold;
           margin: 5px 0;
       }

       /* Info ringkas di bawah judul */
       .subtitle {
           text-align: center;
           font-size: 12px;
           margin-bottom: 5px;
       }

       /* Garis pembatas (dotted atau dashed untuk struk thermal) */
       .line {
           border-top: 1px dotted #000;
           margin: 5px 0;
       }

       /* Tabel umum */
       table {
           width: 100%;
           border-collapse: collapse;
       }

       table td {
           vertical-align: top;
           padding: 2px 0;
       }

       /* Utility classes */
       .right {
           text-align: right;
       }

       .center {
           text-align: center;
       }

       .bold {
           font-weight: bold;
       }

       .small {
           font-size: 10px;
       }
   </style>
</head>
<body>
<div class="receipt">
   <!-- Judul / Nama Toko -->
   <div class="title">IntroTech Store</div>
   
   <!-- Info Transaksi -->
   <div class="subtitle">
       Id Transaksi: {{ $order->id }} <br>
       {{ date('d F Y - H:i') }}
   </div>

   <!-- Garis pembatas -->
   <div class="line"></div>

   <!-- Daftar Produk -->
   <table>
       @foreach ($order->orderProducts as $orderProduct)
           <tr>
               <!-- Nama Produk (Bold) -->
               <td colspan="3" class="bold">
                   {{ $orderProduct->product->name }}
               </td>
           </tr>
           <tr>
               <!-- Detail Qty & Harga per item -->
               <td style="width: 10px;"></td>
               <td>
                   {{ $orderProduct->quantity }} x 
                   {{ number_format($orderProduct->unit_price, 0, ',', '.') }}
               </td>
               <!-- Subtotal item (qty * harga) -->
               <td class="right" style="width: 60px;">
                   {{ number_format($orderProduct->quantity * $orderProduct->unit_price, 0, ',', '.') }}
               </td>
           </tr>
       @endforeach
   </table>

   <!-- Garis pembatas -->
   <div class="line"></div>

   <!-- Ringkasan Total -->
   <table>
       <tr>
           <td class="right bold">Total</td>
           <td class="right bold" style="width: 60px;">
               {{ number_format($order->total_price, 0, ',', '.') }}
           </td>
       </tr>
       <tr>
           <td class="right">Bayar</td>
           <td class="right">
               {{ number_format($order->paid_amount, 0, ',', '.') }}
           </td>
       </tr>
       <tr>
           <td class="right">Kembalian</td>
           <td class="right">
               {{ number_format($order->change_amount, 0, ',', '.') }}
           </td>
       </tr>
   </table>

   <!-- Garis pembatas -->
   <div class="line"></div>

   <!-- Pesan Penutup -->
   <div class="center" style="margin-top: 5px;">
       <small>
           Terima Kasih telah berkunjung <br>
           Semoga hari kamu menyenangkan.~
       </small>
   </div>
</div>
</body>
</html>
