<html>

<head>
<style media="screen">
</style>
</head>

<body>

<?php 
	//DATA ORDER
	foreach ($selectDataOrder as $order) {
		// echo "<pre>"; print_r($order);die;
		if ($order == null) {
		}else{
			$no_order = $order['no_order'];
			$tgl_order = $order['tgl_order'];
			$arr = explode(" ", $tgl_order);
			$tanggal_order = $arr[0];
			$jam_order = $arr[1];
			$seksi = $order['seksi'];
			$unit = $order['unit'];
			$nama_mesin = $order['nama_mesin'];
			$nomor_mesin = $order['nomor_mesin'];
			$line = $order['line'];
			$kerusakan = $order['kerusakan'];
			$kondisi_mesin = $order['kondisi_mesin'];
			$running_hour = $order['running_hour'];
		}
	}

	//DATA LAPORAN 
	if ($selectDataLaporanPerbaikan !== null) {
		foreach ($selectDataLaporanPerbaikan as $laporan) {
			if ($laporan == null) {
			}else{
				$laporan_kerusakan = $laporan['kerusakan'];
				$penyebab_kerusakan = $laporan['penyebab_kerusakan'];
				$urutan_langkah = $laporan['urutan'];
				$langkah_perbaikan = $laporan['langkah'];
				$langkah_pencegahan = $laporan['langkah_pencegahan'];
				$verifikasi_perbaikan = $laporan['verifikasi_perbaikan'];
			}
		}
	}
?>
	<table style="width:100%; padding: 0; border-collapse: collapse !important;margin-top:30px !important;">
		<tr>
			<td rowspan="3" valign="top" style="text-align: left; border-top: 1px solid black;border-left: 1px solid black;">
				<img style="height: auto; width: 35px;" src="<?php echo base_url('assets/img/logo.png'); ?>" />
			</td>
			<td colspan="5" valign="top" width="20%" style="font-size: 11px;text-align: left; border-top: 1px solid black;padding-left:-50px;">
				<b>CV KARYA HIDUP SENTOSA</b>
			</td>
			<td style="font-size: 11px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;"><b>No. Doc </td> 
			<td style="border-top: 1px solid black;"> : </td> 
			<td colspan="2" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px;"> <b><?php echo "F.RM.MTN-02-02 (Rev.04)";?> </b><br></td>
		</tr>
		<tr>
			<td colspan="5" style="font-size: 10px;padding-left:-50px;padding-top:-10px;"><b>Yogyakarta</b></td>
			<td style="font-size: 11px;text-align: left;border-left: 1px solid black;"><b>No. Order </td>
			<td style="font-size: 11px;"> : </td>
			<td colspan="2" style="border-right: 1px solid black;font-size: 11px;"> <u> <?php echo $no_order;?> </u><br></td>
		</tr>
		<tr>	
			<td colspan="5" valign="top" style="font-size: 15px; padding-left:-95px; padding-top:-15px; text-align: center; border-right: 1px solid black;"><br><b> ORDER</b></td>
			<td style="font-size: 11px;text-align: left;border-left: 1px solid black;"><b>Tgl. Order </td> 
			<td style="font-size: 11px;">: </td>
			<td colspan="2" style="border-right: 1px solid black;font-size: 11px;"> <u> <?php echo $tanggal_order;?> </u></td>
		</tr>
		<tr>
			<td valign="top" colspan="6" style="border-left: 1px solid black;text-align: center;padding-top:-3px;"><b>PERBAIKAN DAN PERAWATAN MESIN (OPPM)</b></td>
			<td style="font-size: 11px;text-align: left;border-left: 1px solid black;"><b>Seksi</td>
			<td style="font-size: 11px;">: </td>
			<td colspan="2" style="border-right: 1px solid black;font-size: 11px;"><u><?php echo $seksi;?> </u></td>
		</tr>
		<tr>
			<td colspan="6" style="font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:left"> <b>MESIN *)</b> </td>
			<td style="font-size: 11px;text-align: left;border-left: 1px solid black;border-bottom: 1px solid black;"><b>Unit</td>
			<td style="font-size: 11px;border-bottom: 1px solid black;">:</td>
			<td colspan="2" style="border-right: 1px solid black;font-size: 11px;border-bottom: 1px solid black;"> <u> <?php echo $unit;?> </u> <br></td>
		</tr>
		<tr>	
			<td colspan="2" style="font-size: 11px;font-weight:normal;text-align: left;border-left: 1px solid black;">Nama Mesin </td> 
			<td style="width: 1px;font-size: 11px; text-align:right;">: </td>
			<td colspan="6" style="border-right: 1px solid black;border-bottom: 1px dotted black;font-size: 11px;"> 
                <?php echo $nama_mesin;?>
            </td>
			<td style="font-size: 11px; border-right: 1px solid black;"><center>Kondisi Mesin saat Order *)</center></td>
		</tr>
		<tr>	
			<td colspan="2" style="font-size: 11px;text-align: left;border-left: 1px solid black;">Nomor Mesin </td> 
			<td style="font-size: 11px;text-align:right;">: </td>
			<td colspan="6" style="border-right: 1px solid black;border-bottom: 1px dotted black;font-size: 11px;">
                <?php echo $nomor_mesin;?>
            </td>
			<td style="font-size: 11px;border-right: 1px solid black;">
				<center><table><tr><td style="width:20px; font-size: 12px;border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;"><center><?php if ($kondisi_mesin == 'Mesin Jalan') { echo "√"; }?></center></td><td style="font-size: 11px;padding-right:20px;">Mesin Jalan</td></tr></table></center>
			</td>
		</tr>
		<!-- <tr>	
			<td colspan="2" style="font-size: 11px;font-weight:normal;text-align: left;border-left: 1px solid black;"> </td> 
			<td style="width: 1px;font-size: 11px; text-align:right;"> </td>
			<td colspan="5" style="border-right: 1px solid black;font-size: 11px;padding-top:-13px;"> 
			...................................................................................................................
            </td>
			<td style="font-size: 11px; border-right: 1px solid black;"></td>
		</tr> -->
		<tr>	
			<td colspan="2" style="font-size: 11px;text-align: left;border-left: 1px solid black;">Line </td> 
			<td style="font-size: 11px;text-align:right;">: </td>
			<td colspan="6" style="border-right: 1px solid black;border-bottom: 1px dotted black;font-size: 11px;"> 
                <?php echo $line;?>
            </td>
			<td style="font-size: 11px;border-right: 1px solid black;">	
				<center><table><tr><td style="width:20px ;font-size: 12px;border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;"><center><?php if ($kondisi_mesin == 'Mesin Berhenti') { echo "√"; }?></center></td><td style="font-size: 11px;">Mesin Berhenti</td></tr></table></center>
				<!-- <center><p style="font-size: 9px;">*Diisi dengan tanda "tick"(√)</p></center> -->
			</td>
		</tr>
		<tr>	
			<td colspan="2" style="font-size: 11px;text-align: left;border-left: 1px solid black;padding-top:-17px;"></td>
			<td colspan="6" style="font-size: 11px;padding-top:-17px;"> 
                <?php //echo $line;?>
            </td>
			<td style="font-size: 11px;border-right: 1px solid black;">	
			<td style="font-size: 11px;border-right: 1px solid black;">	
				<center><p style="font-size: 9px;">*Diisi dengan tanda "tick"(√)</p></center>
			</td>
		</tr>
		<tr>	
			<td colspan="2" style="font-size: 11px;text-align: left;border-left: 1px solid black;padding-top:-10px;">Kerusakan *) <br> <i style="font-size:9px;">(Tulis dengan lengkap dan jelas)</i></td> 
			<td style="font-size: 11px;text-align:right;padding-top:-10px;">: </td>
			<td colspan="6" style="border-right: 1px solid black;border-bottom: 1px dotted black;font-size: 11px;padding-top:-10px;"> 
                <?php echo $kerusakan;?>
            </td>
			<td style="border-right: 1px solid black; border-top: 1px solid black;"><center><b>RUNNING HOUR *)</b></center></td>
		</tr>
		<tr>	
			<td colspan="2" style="font-size: 11px;font-weight:normal;text-align: left;border-left: 1px solid black;"> </td> 
			<td style="width: 1px;font-size: 11px; text-align:right;"> </td>
			<td colspan="6" style="border-right: 1px solid black;border-bottom: 1px dotted black;font-size: 11px;padding-top:5px;"> 
            </td>
			<td style="font-size: 12px; border-right: 1px solid black;text-align:center;"><?php echo $running_hour;?></td>
		</tr>		
	</table>

</body>
</html>
