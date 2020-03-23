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
		}
	}

	//DATA LAPORAN 
	if ($selectDataLaporanPerbaikan !== NULL) {
		foreach ($selectDataLaporanPerbaikan as $laporan) {
			if ($laporan == null) {
				# code...
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
	<br>
  <table style="width:100%; padding: 0; border-collapse: collapse !important; margin-top: 213px !important;">
		<tr>
			<td colspan="9" style="padding: 3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;"> <b>LAPORAN PERBAIKAN *)</b> </td>
		</tr> 
		<tr>
			<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;">Kerusakan **)</td>
			<td style="padding:5px;font-size: 12px;">:</td>
			<td colspan="7" style="padding:5px;font-size: 12px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;"><?php echo $laporan_kerusakan ?></td>
		</tr>
		<tr>
			<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
			<td style="padding:5px;font-size: 12px;"></td>
			<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-13px;"> ............................................................................................................................................................................................................</td>
		</tr>
		<tr>
			<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
			<td style="padding:5px;font-size: 12px;"></td>
			<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-3px;"> ............................................................................................................................................................................................................</td>
		</tr>
		<tr>
			<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;padding-top:-2px;">Penyebab Kerusakan **)</td>
			<td style="padding:5px;font-size: 12px;padding-top:-2px;">:</td>
			<td colspan="7" style="padding:5px;font-size: 12px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-2px;"><?php echo $penyebab_kerusakan ?></td>
		</tr>
		<tr>
			<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
			<td style="padding:5px;font-size: 12px;"></td>
			<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-15px;"> ............................................................................................................................................................................................................</td>
		</tr>
		<tr>
			<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
			<td style="padding:5px;font-size: 12px;"></td>
			<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-3px;"> ............................................................................................................................................................................................................</td>
		</tr>
		<?php 
			for ($i=0; $i < count($selectDataLaporanPerbaikan); $i++) { 
				if ($i == 0) {
		?>		
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;padding-top:-2px;">Langkah yang dilakukan **) <br> (Corrective Action)</td>
				<td style="padding:5px;font-size: 12px;padding-top:-2px;">:</td>
				<td colspan="7" style="padding:5px;font-size: 12px;text-align: left;border-right: 1px solid black;padding-top:-10px;padding-left:-2px;">
					<?php
						echo $selectDataLaporanPerbaikan[$i]['urutan'].". ".$selectDataLaporanPerbaikan[$i]['langkah']; 
					?> 
				</td>
			</tr>  
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
				<td style="padding:5px;font-size: 12px;"> </td>
				<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-40px;"> ............................................................................................................................................................................................................</td>
			</tr>
		<?php 
			} else {
		?>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
				<td style="padding:5px;font-size: 12px;"></td>
				<td colspan="7" style="padding:5px;font-size: 12px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-top:0px;padding-top:-25px;padding-left:-2px;">
					<?php 
						if($i <= 6) {
							echo $selectDataLaporanPerbaikan[$i]['urutan'].". ".$selectDataLaporanPerbaikan[$i]['langkah'];
						}else{
							break;
						}
					?>
				</td>
			</tr>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
				<td style="padding:5px;font-size: 12px;"> </td>
				<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-40px;"> ............................................................................................................................................................................................................</td>
			</tr>
		<?php		
			}
		}
			if ($i >= 6) {
		?>
			<tr>
				<td width="30%" colspan="9" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;padding-top:-75px;"><b><i>(Tulis dengan lengkap dan jelas)</i></b></td>
			</tr>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;padding-top:-20px;">Langkah Pencegahan **) <br> (Preventive Action)</td>
				<td style="padding:5px;font-size: 12px;padding-top:-25px;">:</td>
				<td colspan="7" style="padding:5px;font-size: 12px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-25px;"><?php echo $langkah_pencegahan ?></td>
			</tr>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
				<td style="padding:5px;font-size: 12px;"></td>
				<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-37px;"> ............................................................................................................................................................................................................</td>
			</tr> 
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
				<td style="padding:5px;font-size: 12px;"></td>
				<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-22px;"> ............................................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
				<td style="padding:5px;font-size: 12px;"></td>
				<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-10px;"> ............................................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;padding-top:-7px;">Verifikasi Perbaikan</td>
				<td style="padding:5px;font-size: 12px;padding-top:-7px;">:</td>
				<td colspan="7" style="padding:5px;font-size: 12px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-7px;"><?php echo $verifikasi_perbaikan ?></td>
			</tr>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
				<td style="padding:5px;font-size: 12px;border-bottom: 1px solid black;"></td>
				<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-bottom:-15px;padding-top:5px;border-bottom: 1px solid black;border-right: 1px solid black;padding-left:-2px;padding-top:-30px;"> ............................................................................................................................................................................................................</td>
			</tr> 
		<?php }else { ?>
			<tr>
				<td width="30%" colspan="9" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;padding-top:-50px;"><b><i>(Tulis dengan lengkap dan jelas)</i></b></td>
			</tr>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;padding-top:-15px;">Langkah Pencegahan **) <br> (Preventive Action)</td>
				<td style="padding:5px;font-size: 12px;padding-top:-20px;">:</td>
				<td colspan="7" style="padding:5px;font-size: 12px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-20px;"><?php echo $langkah_pencegahan ?></td>
			</tr>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
				<td style="padding:5px;font-size: 12px;"></td>
				<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-32px;"> ............................................................................................................................................................................................................</td>
			</tr> 
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
				<td style="padding:5px;font-size: 12px;"></td>
				<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-17px;"> ............................................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
				<td style="padding:5px;font-size: 12px;"></td>
				<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-5px;"> ............................................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;padding-top:-2px;">Verifikasi Perbaikan</td>
				<td style="padding:5px;font-size: 12px;padding-top:-2px;">:</td>
				<td colspan="7" style="padding:5px;font-size: 12px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-2px;"><?php echo $verifikasi_perbaikan ?></td>
			</tr>
			<tr>
				<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
				<td style="padding:5px;font-size: 12px;border-bottom: 1px solid black;"></td>
				<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-bottom:-15px;padding-top:5px;border-bottom: 1px solid black;border-right: 1px solid black;padding-left:-2px;padding-top:-30px;"> ............................................................................................................................................................................................................</td>
			</tr> 
		<?php } ?>
	</table>

  <table style="width:100%; padding: -5px; border-collapse: collapse !important;margin-top:2px;">
    <tr>
      <td width="10%" style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center"></td>
      <td width="5%"  style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center"> NO </td>
      <td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> TANGGAL </td>
      <td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> JAM MULAI </td>
      <td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> JAM SELESAI </td>
      <td width="25%" style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> PELAKSANA </td>
    </tr>
		<?php $jumlah_baris = count($selectReparasi)+1; //echo $jumlah_baris;die;?>
	<tr>
		<td rowspan="6" width="10%" style="padding: 3px;font-size: 12px;border-left: 1px solid black;text-align:center;border-bottom: 1px solid black;padding-top:-20px;"> REPARASI  </td>
	</tr> 
		<?php $no=1;
			$amountOfReparasi = count($selectReparasi);
			if ($amountOfReparasi > 5) {
				$amountOfReparasi = 5;
			}else{
				$amountOfReparasi = count($selectReparasi);
			}
			for ($i=0; $i < $amountOfReparasi; $i++) { 
		?>
		<tr>
      		<td width="5%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:center"> 
				  <?php 
				  //if ($i <= 4) {
						echo $no;
					// }else{
						// break;
					// }
			  	?>
			</td>
      		<td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:left;border-right: 1px solid black;"> 
			  	<?php 
					echo $selectReparasi[$i]['tgl_reparasi'];
			  	?>
			</td>
      		<td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:left;border-right: 1px solid black;"> 
			  	<?php 
					echo $selectReparasi[$i]['jam_mulai_reparasi'];
			  	?>
			</td>
      		<td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:left;border-right: 1px solid black;"> 
			 	<?php
					echo $selectReparasi[$i]['jam_selesai_reparasi'];
			  	?>
			</td>
      		<td width="25%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:left;border-right: 1px solid black;"> 
			 	<?php
					echo $selectReparasi[$i]['nama'];
			  	?>			
			</td>
		</tr>
		<?php  $no++; } ?>
  </table>

<!--TABEL SPAREPART-->
  <table style="width:100%; padding: 0; border-collapse: collapse !important;margin-top:2px;">
    <tr>
      <td width="5%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:center"> NO. </td>
      <td colspan="2" width="40%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:center"> NAMA SPAREPART YANG DIGUNAKAN </td>
      <td colspan="2" width="30%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> SPESIFIKASI </td>
      <td colspan="2" width="25%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> JUMLAH </td>
    </tr>
		<!--DATA SPAREPART-->
		<?php $no=1;
			$amountOfSparepart = count($selectSparepart);
			if ($amountOfSparepart > 5) {
				$amountOfSparepart = 5;
			}else{
				$amountOfSparepart = count($selectSparepart);
			}
			for ($i=0; $i < $amountOfSparepart; $i++) { 
				// echo"<pre>";print_r($selectReparasi);die;
		?>
		<tr>
			<td width="5%" style="text-align: center;font-size: 11px;padding:3px;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
				<?php
					echo $no;
			  	?>
			</td>
			<td colspan="2" width="40%" style="font-size: 11px;padding:3px;border-bottom: 1px solid black;"> 
				<?php 
					echo $selectSparepart[$i]['nama_sparepart'];
			  	?>	
			</td>
			<td colspan="2" width="30%" style="font-size: 11px;padding:3px;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			  	<?php 
					echo $selectSparepart[$i]['spesifikasi'];
			  	?>
			</td>
			<td colspan="2" width="25%" style="font-size: 11px;text-align:center; padding:3px;border-bottom: 1px solid black;border-right: 1px solid black;"> 
				<?php 
					echo $selectSparepart[$i]['jumlah'];
			  	?>			
			</td> 
		</tr>
	<?php $no++; } ?>
  </table>

  <table style="width:100%; padding: 0; border-collapse: collapse !important;margin-top:-10px;margin-top:2px;margin-bottom:2px;">
    <tr>
    	<td width="50%" rowspan="3" style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;">ALASAN KETERLAMBATAN <br> REPARASI </b> </td>
    	<td colspan="4" style="padding:3px;font-size: 11px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black"> ORDER / PESANAN PEMBELIAN </td>
    </tr>
	<tr>
		<td colspan="2" style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">MULAI</td>
		<td colspan="2" style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">SELESAI</td>
	</tr>
	<tr>
		<td width="12.5%" style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">TANGGAL</td>
		<td width="12.5%" style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">JAM</td>
		<td width="12.5%" style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">TANGGAL</td>
		<td width="12.5%" style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">JAM</td>
	</tr>
	<?php 				
			if (!empty($selectKeterlambatan)) {
				foreach ($selectKeterlambatan as $key => $tlt) {
					if ($tlt['alasan'] == 'Menunggu Spare Part') {
						$kSP = $key;
					} elseif ($tlt['alasan'] == 'Menunggu Machining Part') {
						$kMP = $key;
					} elseif ($tlt['alasan'] == 'Menunggu Instruksi') {
						$kIN = $key;
					}		
				} 
			}
		?>
	<tr>
		<td style="padding:3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			1. Menunggu Spare Part
		</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			<?php 
			if (isset($kSP)) {
				echo $selectKeterlambatan[$kSP]['tgl_mulai']; 
			}
			?>
		</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			<?php 
			if (isset($kSP)) {
				echo $selectKeterlambatan[$kSP]['jam_mulai']; 
			}
			?>
		</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			<?php 
			if (isset($kSP)) {
				echo $selectKeterlambatan[$kSP]['tgl_selesai']; 
			}
			?>
		</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			<?php 
			if (isset($kSP)) {
				echo $selectKeterlambatan[$kSP]['jam_selesai']; 
			}
			?>
		</td>
	</tr>
	<tr>
		<td style="padding:3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">2. Menunggu Machining Part</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			<?php 
			if (isset($kMP)) {
				echo $selectKeterlambatan[$kMP]['tgl_mulai']; 
			}
			?>
		</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			<?php 
			if (isset($kMP)) {
				echo $selectKeterlambatan[$kMP]['jam_mulai']; 
			}
			?>
		</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			<?php 
			if (isset($kMP)) {
				echo $selectKeterlambatan[$kMP]['tgl_selesai']; 
			}
			?>
		</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			<?php 
			if (isset($kMP)) {
				echo $selectKeterlambatan[$kMP]['jam_selesai']; 
			}
			?>
		</td>
	</tr>
	<tr>
		<td style="padding:3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">3. Menunggu Instruksi</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;"> <?= $tanggal_mulai;?>
			<?php 
			if (isset($kIN)) {
				echo $selectKeterlambatan[$kIN]['tgl_mulai']; 
			}
			?>
		</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			<?php 
			if (isset($kIN)) {
				echo $selectKeterlambatan[$kIN]['jam_mulai']; 
			}
			?>
		</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			<?php 
			if (isset($kIN)) {
				echo $selectKeterlambatan[$kIN]['tgl_selesai']; 
			}
			?>
		</td>
		<td style="padding:3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
			<?php 
			if (isset($kIN)) {
				echo $selectKeterlambatan[$kIN]['jam_selesai']; 
			}
			?>
		</td>
	</tr>
  </table>
		<?php   
				$amountOfLaporanPerbaikan = count($selectDataLaporanPerbaikan);
				$amountOfReparasi = count($selectReparasi);
				$amountOfSparepart = count ($selectSparepart);
				$marginBottomPosition = 2;
				if ($amountOfLaporanPerbaikan >= 8 || $amountOfReparasi >= 6 || $amountOfSparepart >= 6) {	
		?>
				<pagebreak /> <!--move into another page-->
			<br>
		<!--DATA LAPORAN PERBAIKAN-->
		<?php if ($amountOfLaporanPerbaikan >= 8) { ?>
			<table style="width:100%; padding: 0; border-collapse: collapse !important; margin-top: 213px !important;">
				<tr>
					<td colspan="9" style="padding: 3px;font-size: 12px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;"> <b>LAPORAN PERBAIKAN *)</b> </td>
				</tr> 
					<tr>
						<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;">Langkah yang dilakukan **) <br> (Corrective Action)</td>
						<td style="padding:5px;font-size: 12px;">:</td>
						<td colspan="7" style="padding:5px;font-size: 12px;text-align: left;border-right: 1px solid black;padding-top:-10px;padding-left:-2px;"></td>
					</tr> 
					<?php
						if($amountOfLaporanPerbaikan >= 8) {
							for ($i=7; $i < count($selectDataLaporanPerbaikan); $i++) { 
					?>
					<tr>
						<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
						<td style="padding:5px;font-size: 12px;"></td>
						<td colspan="7" style="padding:5px;font-size: 12px;text-align: left;border-right: 1px solid black;padding-top:-10px;padding-left:-2px;padding-top:-50px;">
						<?php
								echo $selectDataLaporanPerbaikan[$i]['urutan'].". ".$selectDataLaporanPerbaikan[$i]['langkah'];
						?>	
						</td>
					</tr> 
					<tr>
						<td width="30%" style="padding:5px;font-size: 12px;text-align: left;border-left: 1px solid black;"></td>
						<td style="padding:5px;font-size: 12px;"> </td>
						<td colspan="7" style="padding:5px;font-size: 11px;text-align: left;padding-top:5px;border-right: 1px solid black;padding-left:-2px;padding-top:-60px;"> ............................................................................................................................................................................................................</td>
					</tr>
					<?php } } ?>
					<tr>
						<td width="30%" colspan="9" style="padding:5px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;padding-top:-75px;"><b><i>(Tulis dengan lengkap dan jelas)</i></b></td>
					</tr>
			</table>
		<?php } ?>

		<!--DATA REPARASI-->
		<?php if ($amountOfReparasi >= 6) { ?>
			<table style="width:100%; padding: -5px; border-collapse: collapse !important;margin-top:<?php if ($amountOfLaporanPerbaikan <= 7) { echo "184"; }else { echo $marginBottomPosition; }?>px;">
				<tr>
				<td width="10%" style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center"></td>
				<td width="5%" style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center"> NO </td>
				<td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> TANGGAL </td>
				<td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> JAM MULAI </td>
				<td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> JAM SELESAI </td>
				<td width="25%" style="padding: 3px;font-size: 12px;text-align: left;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> PELAKSANA </td>
				</tr>
					<?php $jumlah_baris = count($selectReparasi)+1; //echo $jumlah_baris;die;?>
				<tr>
					<td rowspan="6" width="10%" style="padding: 3px;font-size: 12px;border-left: 1px solid black;text-align:center;border-bottom: 1px solid black;padding-top:-20px;"> REPARASI  </td>
				</tr> 
					<?php $no=6;
						if($amountOfReparasi >= 6) {
							for ($i=5; $i < count($selectReparasi); $i++) { 
							// echo"<pre>";print_r($selectReparasi);die;
					?>
					<tr>
						<td width="5%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:center"> 
							<?php
								echo $no;
							?>
						</td>
						<td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:left;border-right: 1px solid black;"> 
							<?php 
								echo $selectReparasi[$i]['tgl_reparasi'];
							?>
						</td>
						<td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:left;border-right: 1px solid black;"> 
							<?php 
								echo $selectReparasi[$i]['jam_mulai_reparasi'];
							?>
						</td>
						<td width="20%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:left;border-right: 1px solid black;"> 
							<?php 
								echo $selectReparasi[$i]['jam_selesai_reparasi'];
							?>
						</td>
						<td width="25%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:left;border-right: 1px solid black;"> 
							<?php 
								echo $selectReparasi[$i]['nama'];
							?>			
						</td>
					</tr>
					<?php  $no++; } } ?>
			</table>
		<!--DATA SPAREPART-->
		<?php } ?>

<?php if ($amountOfSparepart >= 6) { ?>
	<table style="width:100%; padding: 0; border-collapse: collapse !important;margin-top:	
		<?php 
			if ($amountOfLaporanPerbaikan < 8 && $amountOfReparasi > 6) { 
				echo $marginBottomPosition; 
			}elseif ($amountOfLaporanPerbaikan < 8 && $amountOfReparasi < 6){
				echo "184";
			}else{ 
				echo $marginBottomPosition;
			}
		?>px;">
		<tr>
		<td width="5%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:center"> NO. </td>
		<td colspan="2" width="40%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:center"> NAMA SPAREPART YANG DIGUNAKAN </td>
		<td colspan="2" width="30%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> SPESIFIKASI </td>
		<td colspan="2" width="25%" style="padding: 3px;font-size: 12px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;text-align:center;border-right: 1px solid black;"> JUMLAH </td>
		</tr>
			<!--DATA SPAREPART-->
			<?php $no=6;
				if($amountOfSparepart >= 6) {
					for ($i=5; $i < count($selectSparepart); $i++) { 
					// echo"<pre>";print_r($selectReparasi);die;
			?>
			<tr>
				<td width="5%" style="text-align: center;font-size: 11px;padding:3px;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
					<?php
						echo $no;
					?>
				</td>
				<td colspan="2" width="40%" style="font-size: 11px;padding:3px;border-bottom: 1px solid black;"> 
					<?php 
						echo $selectSparepart[$i]['nama_sparepart'];
					?>	
				</td>
				<td colspan="2" width="30%" style="font-size: 11px;padding:3px;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
					<?php 
						echo $selectSparepart[$i]['spesifikasi'];
					?>	
				</td>
				<td colspan="2" width="25%" style="font-size: 11px;text-align:center; padding:3px;border-bottom: 1px solid black;border-right: 1px solid black;"> 
					<?php 
						echo $selectSparepart[$i]['jumlah'];
					?>				
				</td> 
			</tr>
			<?php  $no++; } } ?>
	</table>
	
<?php } }//die;?>

</body>
</html>
