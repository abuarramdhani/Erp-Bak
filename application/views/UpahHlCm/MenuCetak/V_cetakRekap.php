<html>
<head>
</head>
<body>
<?php 
		set_time_limit(0);
		ini_set("memory_limit", "2048M");
							
	?>
<div style="width: 100%; height: 100%; padding: 0px;">
	<table style="width: 100%; font-size: 14px;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black">
		<tr>
			<td height="30px" colspan="2" style="text-align: center;">PEMBAYARAN UPAH PEKERJA HARIAN KHS PUSAT & KHS TUKSONO</td>
		</tr>
		<tr>
			<td style="width: 30%;">PERIODE TANGGAL :</td>
			<td><?php $period=explode(" - ", $periode);echo date('d F Y',strtotime($period[0]));echo " - ";echo date('d F Y',strtotime($period[1]));;?></td>
		</tr>
	</table>
	<div style="width: 100%;height: 10px; border-left: 1px solid black; border-right: 1px solid black">
		
	</div>
	<table style="width: 100%;border-collapse: collapse;font-size: 12px;page-break-after: always;border: 1px solid black">
		<tr style="background-color: #ccffcc;">
			<td style="border-top: 1px solid black;border-bottom: 1px solid black; text-align: center; width: 4%; height: 25px;">NO</td>
			<td style="border: 1px solid black; text-align: center; width: 10%">TGL TERIMA</td>
			<td style="border: 1px solid black; text-align: center; width: 16%">NO REKENING</td>
			<td style="border: 1px solid black; text-align: center; width: 15%">NAMA</td>
			<td style="border: 1px solid black; text-align: center; width: 13%;">TERIMA</td>
			<td style="border: 1px solid black; text-align: center; width: 15%">NAMA PENERIMA REKENING</td>
			<td style="border: 1px solid black; text-align: center; width: 13%">BANK</td>
			<td style="border-top: 1px solid black;border-bottom: 1px solid black; text-align: center;">KETERANGAN</td>
		</tr>
		<tr>
			<td style="text-align: center;background-color: #ccffcc;" colspan="8">TUKSONO</td>
		</tr>
		<?php
		$total_semua = "";
		$no=1;
		$jmlkom=count($kom);
		for ($u=0; $u < $jmlkom; $u++) {
			$gpokok  = $kom[$u]['gpokok'];
			$um		 = $kom[$u]['um'];
			$lembur  = $kom[$u]['lembur'];
			for ($i=0; $i < 8; $i++) { 
				if ($kom[$u]['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $kom[$u]['kdpekerjaan']==$nom[$i]['kode_pekerjaan']) {
					$nomgpokok = $nom[$i]['nominal'];
				}
				if ($kom[$u]['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
					$nomum = $nom[$i]['uang_makan'];
				}
			}
			$gajipokok = $gpokok*$nomgpokok;
			$gajium    = $um*$nomum;
			$gajilembur= $lembur*($nomgpokok/7);
			$total 	   = $gajipokok+$gajilembur+$gajium;
			$total_semua = $total_semua+$total;
			if ($kom[$u]['lokasi_kerja'] == '02' and $no <= 37) {
				?>
				<tr>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;"><?php echo $no;?></td>
					<td style="border: 1px solid black; text-align: center;"><?php ?></td>
					<td style="border: 1px solid black; text-align: center;">
						<?php 
							foreach ($rekap as $ker) {
								if ($kom[$u]['noind'] == $ker['noind']) {
									echo $ker['no_rekening'];
								}
							}
						?>
					</td>
					<td style="border: 1px solid black;padding-left: 2px;"><?php echo $kom[$u]['nama'];?></td>
					<td style="border: 1px solid black;padding-left: 3px;text-align: center;"><?php echo number_format($total,0,'','.');?></td>
					<td style="border: 1px solid black;padding-left: 2px;">
						<?php 
							foreach ($rekap as $ker) {
								if ($kom[$u]['noind'] == $ker['noind']) {
									echo $ker['atas_nama'];
								}
							}
						?>
					</td>
					<td style="border: 1px solid black; text-align: center;">
						<?php 
							foreach ($rekap as $ker) {
								if ($kom[$u]['noind'] == $ker['noind']) {
									echo $ker['bank'];
								}
							}
						?>
					</td>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;"></td>
				</tr>
				<?php
			$no++;
			}
		}
		?>
		</table>
		<table style="width: 100%;border-collapse: collapse;font-size: 12px;margin-top: 10px; border: 1px solid black">
		<tr style="background-color: #ccffcc;">
			<td style="border-top: 1px solid black;border-bottom: 1px solid black; text-align: center; width: 4%; height: 25px;">NO</td>
			<td style="border: 1px solid black; text-align: center; width: 10%">TGL TERIMA</td>
			<td style="border: 1px solid black; text-align: center; width: 16%">NO REKENING</td>
			<td style="border: 1px solid black; text-align: center; width: 15%">NAMA</td>
			<td style="border: 1px solid black; text-align: center; width: 13%;">TERIMA</td>
			<td style="border: 1px solid black; text-align: center; width: 15%">NAMA PENERIMA REKENING</td>
			<td style="border: 1px solid black; text-align: center; width: 13%">BANK</td>
			<td style="border-top: 1px solid black;border-bottom: 1px solid black; text-align: center;">KETERANGAN</td>
		</tr>
		<?php
		$total_semua = "";
		$no=1;
		$jmlkom = count($kom);
		for ($u=0; $u < $jmlkom; $u++){
			$gpokok  = $kom[$u]['gpokok'];
			$um		 = $kom[$u]['um'];
			$lembur  = $kom[$u]['lembur'];
			for ($i=0; $i < 8; $i++) { 
				if ($kom[$u]['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $kom[$u]['kdpekerjaan']==$nom[$i]['kode_pekerjaan']) {
					$nomgpokok = $nom[$i]['nominal'];
				}
				if ($kom[$u]['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
					$nomum = $nom[$i]['uang_makan'];
				}
			}
			$gajipokok = $gpokok*$nomgpokok;
			$gajium    = $um*$nomum;
			$gajilembur= $lembur*($nomgpokok/7);
			$total 	   = $gajipokok+$gajilembur+$gajium;
			$total_semua = $total_semua+$total;
			if ($kom[$u]['lokasi_kerja'] == '02') {
				if ($no > 37) {
					?>
					<tr>
						<td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;"><?php echo $no;?></td>
						<td style="border: 1px solid black; text-align: center;"><?php ?></td>
						<td style="border: 1px solid black; text-align: center;">
							<?php 
								foreach ($rekap as $ker) {
									if ($kom[$u]['noind'] == $ker['noind']) {
										echo $ker['no_rekening'];
									}
								}
							?>
						</td>
						<td style="border: 1px solid black;padding-left: 2px;"><?php echo $kom[$u]['nama'];?></td>
						<td style="border: 1px solid black;padding-left: 3px;text-align: center;"><?php echo number_format($total,0,'','.');?></td>
						<td style="border: 1px solid black;padding-left: 2px;">
							<?php 
								foreach ($rekap as $ker) {
									if ($kom[$u]['noind'] == $ker['noind']) {
										echo $ker['atas_nama'];
									}
								}
							?>
						</td>
						<td style="border: 1px solid black; text-align: center;">
							<?php 
								foreach ($rekap as $ker) {
									if ($kom[$u]['noind'] == $ker['noind']) {
										echo $ker['bank'];
									}
								}
							?>
						</td>
						<td style="border-top: 1px solid black;border-bottom: 1px solid black;"></td>
					</tr>
					<?php
				}				
			$no++;
			}
		}
		?>
		<tr>
			<td style="text-align: center;background-color: #ccffcc;" colspan="8">PUSAT</td>
		</tr>
		<?php
		$jml_tuk ="";
		foreach ($kom as $op) {
			if ($op['lokasi_kerja'] == '02') {
				$jml_tuk = $jml_tuk+1;
			}
		}
		$nomor = $jml_tuk+1;
		foreach ($kom as $key) {
			$gpokok  = $key['gpokok'];
			$um		 = $key['um'];
			$lembur  = $key['lembur'];
			for ($i=0; $i < 8; $i++) { 
				if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $key['kdpekerjaan']==$nom[$i]['kode_pekerjaan']) {
					$nomgpokok = $nom[$i]['nominal'];
				}
				if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
					$nomum = $nom[$i]['uang_makan'];
				}
			}
			$gajipokok = $gpokok*$nomgpokok;
			$gajium    = $um*$nomum;
			$gajilembur= $lembur*($nomgpokok/7);
			$total 	   = $gajipokok+$gajilembur+$gajium;
			if ($key['lokasi_kerja'] == '01') {
				?>
				<tr>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;"><?php echo $nomor;?></td>
					<td style="border: 1px solid black; text-align: center;"><?php ?></td>
					<td style="border: 1px solid black; text-align: center;">
						<?php 
							foreach ($rekap as $ker) {
								if ($key['noind'] == $ker['noind']) {
									echo $ker['no_rekening'];
								}
							}
						?>
					</td>
					<td style="border: 1px solid black;padding-left: 2px;"><?php echo $key['nama'];?></td>
					<td style="border: 1px solid black;padding-left: 3px;text-align: center;"><?php echo number_format($total,0,'','.');?></td>
					<td style="border: 1px solid black;padding-left: 2px;">
						<?php 
							foreach ($rekap as $ker) {
								if ($key['noind'] == $ker['noind']) {
									echo $ker['atas_nama'];
								}
							}
						?>
					</td>
					<td style="border: 1px solid black; text-align: center;">
						<?php 
							foreach ($rekap as $ker) {
								if ($key['noind'] == $ker['noind']) {
									echo $ker['bank'];
								}
							}
						?>
					</td>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;"></td>
				</tr>
				<?php
			$nomor++;
			}
		}
		?>
		<tr>
			<td height="20px;"></td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<td style="border: 1px solid black;"><b>TOTAL</b></td>
			<td style="border: 1px solid black;text-align: center;"><?php echo number_format($total_semua,0,'','.');?></td>
			<td></td>
			<td colspan="2">Yogyakarta, <?php 
				echo date('d');
				$month=date('m');
				if ($month=='01') {
					echo " Januari ";
				}elseif ($month=='02') {
					echo " Februari ";
				}elseif ($month=='03') {
					echo " Maret ";
				}elseif ($month=='04') {
					echo " April ";
				}elseif ($month=='05') {
					echo " Mei ";
				}elseif ($month=='06') {
					echo " Juni ";
				}elseif ($month=='07') {
					echo " Juli ";
				}elseif ($month=='08') {
					echo " Agustus ";
				}elseif ($month=='09') {
					echo " September ";
				}elseif ($month=='10') {
					echo " Oktober ";
				}elseif ($month=='11') {
					echo " November ";
				}elseif ($month=='12') {
					echo " Desember ";
				};
				echo date('Y');
			?></td>
		</tr>
		<tr>
			<td height="50px"></td>
		</tr>
		<tr>
			<td colspan="6"></td>			
			<td colspan="2"><u>Eko Prasetyo Adhi</u></td>
		</tr>
		<tr style="margin-top: 10px;">
			<td colspan="6"></td>			
			<td colspan="2">Kepala Seksi Civil Maintenance</td>
		</tr>
	</table>

</div>
</body>
</html>

