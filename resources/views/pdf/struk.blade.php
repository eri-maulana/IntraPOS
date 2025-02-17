<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Struk Belanja</title>
</head>
<body>
   <table style="border-bottom: solid 2px ; text-align: center; font-size: 14px; width: 240px;">
      <tr>
         <td><b>IntroTech Store</b></td>
      </tr>
      <tr>
         <td>Id Transaksi : {{ $order->id }}</td>
      </tr>
      <tr>
         <td>{{ date('d F Y H:i:s') }}</td>
      </tr>
      {{-- <tr>
         <td><</td>
      </tr> --}}
   </table>
   <table style="border-bottom: dotted 2px ; text-align: center; font-size: 14px; width: 240px;">
      
        @foreach ($order->orderProducts as $orderProduct) 
        
            <tr>
                <td colspan="6" style="width: 70px;text-align: left;"><b>{{ $orderProduct->product->name }}</b></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 70px;text-align: left;"> </td>
                <td style="width: 10px; text-align: center;">{{ $orderProduct->quantity  }}</td>
                <td style="width: 70px; text-align: right;">x   {{ $orderProduct->unit_price  }}</td>
                <td style="width: 70px; text-align: right;" colspan="2">
                {{ number_format($order->total_price, 0, ',', '.')  }}</td>
            </tr>
        <@endforeach
   </table>
   <table style="border-bottom: dotted 2px ;  font-size: 14px; width: 240px;">
      <tr>
         <td colspan="3" style="width: 100px;"></td>
         <td style="width: 50px; text-align: right;">Total</td>
         <td colspan="2" style="width: 70px; text-align: right;">
            <b>{{ number_format($order->total_price, 0, ',', '.')  }}</b>
         </td>
      </tr>
      <tr>
         <td colspan="3" style="width: 100px;"></td>
         <td style="width: 50px; text-align: right;">Bayar</td>
         <td colspan="2" style="width: 70px; text-align: right;">
            <b>{{ number_format($order->paid_amount, 0, ',', '.')  }}</b>
         </td>
      </tr>
   </table>
   <table style="border-bottom: solid 2px ;  font-size: 14px; width: 240px;">
      <tr>
         <td colspan="3" style="width: 100px;"></td>
         <td style="width: 50px; text-align: right;">Kembalian</td>
         <td colspan="2" style="width: 70px; text-align: right;">
            <b>{{ number_format($order->change_amount, 0, ',', '.')  }}</b>
         </td>
      </tr>
   </table>
   <table style="text-align: center; margin-top: 10px; font-size: 16px; width: 240px;">
      <tr>
         <td>Terima kasih Sudah Belanja Disini.~</td>
      </tr>
      <td>Semoga Hari mu Menyenangkan.~</td>
   </table>
</body>
</html>