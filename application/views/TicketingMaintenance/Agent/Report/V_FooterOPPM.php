<html>

<head>
	<style media="screen">
	</style>
</head>
<body>

<?php 
	//DATA ORDER
	foreach ($selectDataOrder as $order) {
		if ($order == null) {
			# code...
		}else{
			// echo "<pre>";print_r($order);die;
			$no_order = $order['no_order'];
			$tgl_order = $order['tgl_order'];
			$arr = explode(" ", $tgl_order);
			$tanggal_order = $arr[0];
			$jam_order = $arr[1];
			$tgl_diterima = $order['tgl_order_diterima'];
			$trm = explode(" ", $tgl_diterima);
			$tanggal_terima = $trm[0];
			$jam_terima = $trm[1];
			$tgl_selesai = $order['tgl_order_selesai'];
			$sls = explode(" ", $tgl_selesai);
			$tanggal_selesai = $sls[0];
			$jam_selesai = $sls[1];
			$tgl_mengetahui_selesai = $order['tgl_mengetahui_order_selesai'];
			$tos = explode(" ",$tgl_mengetahui_selesai);
			$tanggal_tahu_selesai = $tos[0];
			$jam_tahu_selesai = $tos[1];
			$seksi = $order['seksi'];
			$unit = $order['unit'];
			$nama_mesin = $order['nama_mesin'];
			$nomor_mesin = $order['nomor_mesin'];
			$line = $order['line'];
			$kerusakan = $order['kerusakan'];
		}
	}
?>
  <table style="width:100%; padding: 0; border-collapse: collapse !important;margin-top:500px !important;">
    <tr>
      <td colspan="2" width="30%" style="font-size: 12px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding:5px;"><b> Order Dibuat </b></td>
      <td colspan="2" width="30%" style="font-size: 12px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;"><b> Order Diterima </b></td>
      <td width="15%" style="font-size: 12px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black"><b> Order Selesai </b></td>
      <td width="25%" style="font-size: 12px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black"><b> Mengetahui Order Selesai </b></td>
    </tr>
	<tr>
      <td width="15%" style="font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding:5px;">Tgl. :&nbsp;<?php echo $tanggal_order;?> <br> Jam :&nbsp;<?php echo $jam_order;?> </td>
      <td width="15%" style="font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"></td>
      <td width="15%" style="font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;">Tgl. :&nbsp;<?php echo $tanggal_terima;?> <br> Jam :&nbsp;<?php echo $jam_terima;?> </td>
      <td width="15%" style="font-size: 12px;text-align: left;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black"></td>
      <td width="23%" style="font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black">Tgl. :&nbsp;<?php echo $tanggal_selesai;?> <br> Jam :&nbsp;<?php echo $jam_selesai;?> </td>
      <td width="23%" style="font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black">Tgl. :&nbsp;<?php echo $tanggal_tahu_selesai;?> <br> Jam : &nbsp;<?php echo $jam_tahu_selesai;?></td>
    </tr>
    <tr>
      <td width="15%" style="height:60px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;text-transform:capitalize;">
      <td width="15%" style="height:60px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;text-transform:capitalize;">
        <br>
      </td>
	  	<br>
	  <td width="15%" style="height:60px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;text-transform:capitalize;">
      <td width="15%" style="height:60px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;text-transform:capitalize;">
      <td style="height:60px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
        <br>
      </td>
	  <td style="height:60px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
        <br>
        <br>
      </td>
    </tr>
    <tr>
		<td style="padding:5px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;">Spv. / Kasie <br> Pemberi Order</td>
		<td style="padding:5px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;">Ass. Ka. Unit <br> Pemberi Order</td>
      	<td style="padding:5px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">Spv. / Kasie Maintenance</td>
      	<td style="padding:5px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">Ass. Ka. Unit Maintenance</td>
      	<td style="padding:5px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">Pelaksana</td>
      	<td style="padding:5px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">Spv. / Kasie Pemberi Order</td>
    </tr>
  </table>
	<!-- <br> -->
	<!-- <br> -->
  <table style="width:100%; padding: 0; border-collapse: collapse !important;">
    <tr>
    	<td width="75%" >		
	  		<span style="font-size:8px;text-align:left;"> *) Diisi oleh Pemberi Order </span> <br>
			<span style="font-size:8px;text-align:left;"> **) Diisi oleh Seksi Maintenance </span> <br> </b> 
		</td>
      	<td width="25%"> 
		  	<span style="font-size:8px;text-align: right;"> Note: Bila daftar penggunaan spare part penuh,</span> <br>
			<span style="font-size:8px;text-align: right;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;dilanjutkan di belakang form dan di paraf. </span>			
		</td>
    </tr>
  </table>

</body>
</html>
